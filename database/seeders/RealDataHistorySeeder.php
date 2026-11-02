<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RealDataHistorySeeder extends Seeder
{
    /**
     * Letakkan file combined_history.csv di: database/data/combined_history.csv
     */
    protected string $csvPath = 'database/data/combined_history.csv';

    public function run(): void
    {
        if (!file_exists(base_path($this->csvPath))) {
            $this->command->error('❌ File tidak ditemukan: ' . base_path($this->csvPath));
            return;
        }

        // ── Bersihkan tabel ───────────────────────────────────────────────────
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('content_analytics')->truncate();
        DB::table('editor_contents')->truncate();
        DB::table('content_plans')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->command->info('🗑️  Tabel berhasil dikosongkan.');

        // ── Baca CSV ──────────────────────────────────────────────────────────
        $handle  = fopen(base_path($this->csvPath), 'r');
        $headers = array_map('trim', fgetcsv($handle));

        $count = 0;
        $this->command->getOutput()->progressStart();

        while (($raw = fgetcsv($handle)) !== false) {
            $d = array_combine($headers, $raw);

            $now = now();

            // ── 1. content_plans ──────────────────────────────────────────────
            $planId = DB::table('content_plans')->insertGetId([
                'posting_date'         => $d['posting_date']   ?: $now->toDateString(),
                'status'               => $d['status']         ?: 'pending',
                'pillar'               => $d['pillar']         ?: '',
                'topic'                => $d['topic']          ?: '',
                'asset_id'             => null,
                'notes_for_creator'    => $d['notes_creator']  ?: null,
                'revision_notes'       => $d['revision_notes'] ?: null,
                'approved'             => $d['approved'] === 'true' ? true : ($d['approved'] === 'false' ? false : null),
                'video_path'           => null,
                'video_revision_notes' => null,
                'created_at'           => $now,
                'updated_at'           => $now,
            ]);

            // ── 2. editor_contents ────────────────────────────────────────────
            DB::table('editor_contents')->insert([
                'content_plan_id'   => $planId,
                'post_type'         => $d['post_type']      ?: 'feed',
                'content_title'     => $d['content_title']  ?: '',
                'script_brief'      => $d['script_brief']   ?: null,
                'reference'         => $d['reference']      ?: null,
                'caption'           => $d['caption']        ?: null,
                'hashtag'           => $d['hashtag']        ?: null,
                'talent'            => $d['talent']         ?: null,
                'editor_name'       => $d['editor_name']    ?: $d['company'],
                'preview_thumbnail' => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ]);

            // ── 3. content_analytics (hanya jika ada data) ───────────────────
            $hasAnalytics = $d['views'] || $d['likes'] || $d['er'];
            if ($hasAnalytics) {
                DB::table('content_analytics')->insert([
                    'content_plan_id'  => $planId,
                    'platform'         => 'instagram',
                    'views'            => (int)   ($d['views']            ?? 0),
                    'likes'            => (int)   ($d['likes']            ?? 0),
                    'comments'         => (int)   ($d['comments']         ?? 0),
                    'shares'           => (int)   ($d['shares']           ?? 0),
                    'posting_hour'     => (int)   ($d['posting_hour']     ?? 0),
                    'posting_day'      => $d['posting_day']               ?: null,
                    'caption_length'   => (int)   ($d['caption_length']   ?? 0),
                    'hashtag_count'    => (int)   ($d['hashtag_count']    ?? 0),
                    'engagement_rate'  => $d['er'] !== '' ? (float) $d['er'] : null,
                    'engagement_score' => $d['engagement_score'] !== '' ? (float) $d['engagement_score'] : null,
                    'created_at'       => $now,
                    'updated_at'       => $now,
                ]);
            }

            $count++;
            $this->command->getOutput()->progressAdvance();
        }

        fclose($handle);
        $this->command->getOutput()->progressFinish();
        $this->command->info("✅ Selesai! Total {$count} baris berhasil diimport.");
        $this->command->info("💡 Jalankan: php artisan ml:export untuk export dataset ML.");
    }
}