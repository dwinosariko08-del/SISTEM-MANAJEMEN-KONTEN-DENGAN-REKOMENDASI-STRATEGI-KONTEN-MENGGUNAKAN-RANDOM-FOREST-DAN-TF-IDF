<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatasetMlAugmentedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = base_path('database/data/dataset_ml_augmented.csv');

        if (!file_exists($csvPath)) {
            $this->command->error("❌ File tidak ditemukan: " . $csvPath);
            return;
        }

        $this->command->info('📥 Membaca CSV: dataset_ml_augmented.csv...');

        // Kosongkan tabel (hapus data lama agar tidak menumpuk)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('content_analytics')->truncate();
        DB::table('produced_videos')->truncate();
        DB::table('editor_contents')->truncate();
        DB::table('content_plans')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('🗑️ Tabel terkait berhasil dikosongkan.');

        // Membaca file CSV
        $handle = fopen($csvPath, "r");
        
        // Baca header
        $header = fgetcsv($handle); 
        // Header diharapkan: pillar,topic,title,script,platform,posting_hour,hashtag_count,views,likes,comments,shares,er,label

        $count = 0;
        $now = now();
        $baseDate = now()->subYears(2); // Mulai dari 2 tahun lalu untuk variasi tanggal

        while (($row = fgetcsv($handle)) !== false) {
            if (count($header) !== count($row)) {
                continue;
            }
            $data = array_combine($header, $row);

            // Generate tanggal secara inkremental atau acak (di sini kita tambah beberapa jam setiap baris)
            $postingDate = (clone $baseDate)->addHours($count * 12);
            $postingDay = $postingDate->locale('id')->isoFormat('dddd');

            // Insert Content Plan
            $planId = DB::table('content_plans')->insertGetId([
                'posting_date' => $postingDate->toDateString(),
                'status' => 'published', // Asumsikan semua data ML sudah dipublish
                'pillar' => $data['pillar'] ?? '',
                'topic' => $data['topic'] ?? '',
                'asset_id' => null,
                'notes_for_creator' => null,
                'revision_notes' => null,
                'approved' => true,
                'video_path' => null,
                'video_revision_notes' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Format Script (sama seperti CombinedHistoryCsvSeeder)
            $formattedScript = $this->formatScriptBrief($data['script'] ?? '');

            // Insert Editor Content
            DB::table('editor_contents')->insert([
                'content_plan_id' => $planId,
                'post_type' => 'reels', // Default ke reels
                'content_title' => $data['title'] ?? '',
                'script_brief' => $formattedScript,
                'reference' => null,
                'caption' => null,
                'hashtag' => null,
                'talent' => null,
                'editor_name' => 'Riko',
                'preview_thumbnail' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Insert Analytics
            DB::table('content_analytics')->insert([
                'content_plan_id' => $planId,
                'platform' => strtolower($data['platform'] ?: 'instagram'),
                'views' => (int) ($data['views'] ?? 0),
                'likes' => (int) ($data['likes'] ?? 0),
                'comments' => (int) ($data['comments'] ?? 0),
                'shares' => (int) ($data['shares'] ?? 0),
                'posting_hour' => (int) ($data['posting_hour'] ?? 0),
                'posting_day' => $postingDay,
                'caption_length' => 0, // Tidak ada di dataset ini
                'hashtag_count' => (int) ($data['hashtag_count'] ?? 0),
                'engagement_rate' => (float) ($data['er'] ?? 0),
                'engagement_score' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $count++;
        }

        fclose($handle);

        $this->command->info("✅ Selesai! {$count} baris data berhasil di-seed dari dataset_ml_augmented.csv");
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

        $formatted = '';
        if (!empty(trim($hook))) $formatted .= "HOOK:\n" . trim($hook) . "\n\n";
        if (!empty(trim($body))) $formatted .= "BODY:\n" . trim($body) . "\n\n";
        if (!empty(trim($closing))) $formatted .= "CLOSING:\n" . trim($closing);

        return trim($formatted);
    }
}
