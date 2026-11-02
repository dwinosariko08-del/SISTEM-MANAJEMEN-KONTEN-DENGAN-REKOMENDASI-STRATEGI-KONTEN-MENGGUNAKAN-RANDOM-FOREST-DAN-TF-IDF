<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CombinedHistoryCsvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = base_path('database/data/combined_history.csv');

        if (!file_exists($csvPath)) {
            $this->command->error("❌ File tidak ditemukan: " . $csvPath);
            return;
        }

        $this->command->info('📥 Membaca CSV: combined_history.csv...');

        // Kosongkan tabel (hapus data lama agar tidak menumpuk)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('content_analytics')->truncate();
        DB::table('produced_videos')->truncate();
        DB::table('editor_contents')->truncate();
        DB::table('content_plans')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('🗑️ Tabel terkait berhasil dikosongkan.');

        $handle = fopen($csvPath, "r");
        $header = fgetcsv($handle); // Baca header

        $count = 0;
        $now = now();

        while (($row = fgetcsv($handle)) !== false) {
            // Hindari baris kosong atau tidak lengkap
            if (count($header) !== count($row)) {
                continue;
            }
            $data = array_combine($header, $row);

            $postingDate = $data['posting_date'];
            if (empty($postingDate)) {
                continue;
            }

            // Status: Di CSV statusnya 'done' atau 'pending'.
            // Untuk data history ML yang sudah ada angkanya, biasanya 'published'.
            $status = strtolower($data['status']);
            if ($status === 'done' || !empty($data['views'])) {
                $status = 'published';
            }

            // Insert Content Plan
            $planId = DB::table('content_plans')->insertGetId([
                'posting_date' => Carbon::parse($postingDate)->toDateString(),
                'status' => $status,
                'pillar' => $data['pillar'] ?? '',
                'topic' => $data['topic'] ?? '',
                'asset_id' => null,
                'notes_for_creator' => $data['notes_creator'] ?: null,
                'revision_notes' => $data['revision_notes'] ?: null,
                'approved' => strtolower($data['approved'] ?? '') === 'true',
                'video_path' => null,
                'video_revision_notes' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $formattedScript = $this->formatScriptBrief($data['script_brief']);

            // Insert Editor Content
            DB::table('editor_contents')->insert([
                'content_plan_id' => $planId,
                'post_type' => strtolower($data['post_type'] ?: 'reels'),
                'content_title' => $data['content_title'] ?? '',
                'script_brief' => $formattedScript,
                'reference' => $data['reference'] ?: null,
                'caption' => $data['caption'] ?: null,
                'hashtag' => $data['hashtag'] ?: null,
                'talent' => $data['talent'] ?: null,
                'editor_name' => $data['editor_name'] ?: 'System',
                'preview_thumbnail' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Insert Analytics (hanya jika ada views)
            if (!empty($data['views']) && $data['views'] > 0) {
                DB::table('content_analytics')->insert([
                    'content_plan_id' => $planId,
                    'platform' => strtolower($data['platform'] ?: 'instagram'),
                    'views' => (int) $data['views'],
                    'likes' => (int) $data['likes'],
                    'comments' => (int) $data['comments'],
                    'shares' => (int) $data['shares'],
                    'posting_hour' => (int) ($data['posting_hour'] ?? 0),
                    'posting_day' => $data['posting_day'] ?? Carbon::parse($postingDate)->locale('id')->isoFormat('dddd'),
                    'caption_length' => (int) ($data['caption_length'] ?? 0),
                    'hashtag_count' => (int) ($data['hashtag_count'] ?? 0),
                    'engagement_rate' => (float) ($data['er'] ?? 0),
                    'engagement_score' => (float) ($data['engagement_score'] ?? 0),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $count++;
        }

        fclose($handle);

        $this->command->info("✅ Selesai! {$count} baris data berhasil di-seed dari combined_history.csv");
    }

    private function formatScriptBrief(?string $script): ?string
    {
        if (empty($script)) return null;

        $hook = '';
        $body = '';
        $closing = '';

        // Normalize variations of tags into unique delimiters
        $script = preg_replace('/\[?HOOK\]?\s*[:-]?\s*/i', '{{HOOK}}', $script);
        $script = preg_replace('/\[?BODY\]?\s*[:-]?\s*/i', '{{BODY}}', $script);
        $script = preg_replace('/\[?CLOSING\]?\s*[:-]?\s*/i', '{{CLOSING}}', $script);

        // Split by the delimiters
        $parts = preg_split('/\{\{(HOOK|BODY|CLOSING)\}\}/', $script, -1, PREG_SPLIT_DELIM_CAPTURE);

        if (count($parts) === 1) {
            // No tags found, assume everything is BODY
            $body = trim($parts[0]);
        } else {
            // First part before any tag
            if (trim($parts[0]) !== '') {
                $body .= trim($parts[0]) . "\n";
            }
            // Loop through captured tags and their content
            for ($i = 1; $i < count($parts); $i += 2) {
                $tag = $parts[$i];
                $content = $parts[$i + 1] ?? '';
                
                if ($tag === 'HOOK') {
                    $hook .= $content;
                } elseif ($tag === 'BODY') {
                    $body .= $content;
                } elseif ($tag === 'CLOSING') {
                    $closing .= $content;
                }
            }
        }

        return "HOOK:\n" . trim($hook) . "\n\nBODY:\n" . trim($body) . "\n\nCLOSING:\n" . trim($closing);
    }
}
