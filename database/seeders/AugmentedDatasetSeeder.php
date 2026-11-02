<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AugmentedDatasetSeeder extends Seeder
{
    /**
     * Letakkan file di: database/data/dataset_ml_augmented.csv
     */
    protected string $csvPath = 'database/data/dataset_ml_augmented.csv';

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
            $d   = array_combine($headers, $raw);
            $now = now();

            // ── Format script → [HOOK]...[BODY]...[CLOSING] ───────────────────
            // Dataset pakai format: "HOOK:\n...\nBODY:\n...\nCLOSING:\n..."
            // Kita standarisasi ke:  "[HOOK]\n...\n\n[BODY]\n...\n\n[CLOSING]\n..."
            $scriptFormatted = $this->formatScript($d['script'] ?? '');

            // ── Hitung caption_length dari script ─────────────────────────────
            $captionLength = mb_strlen($d['script'] ?? '');

            // ── Hitung posting_day dari posting_hour ──────────────────────────
            // Dataset tidak punya tanggal, pakai tanggal hari ini sebagai proxy
            $postingDate = now()->toDateString();
            $postingDay  = now()->locale('id')->isoFormat('dddd');

            // ── engagement_score = er × views ─────────────────────────────────
            $er              = (float) ($d['er']    ?? 0);
            $views           = (int)   ($d['views'] ?? 0);
            $engagementScore = round($er * $views / 100, 2); // er dalam persen

            // ── 1. content_plans ──────────────────────────────────────────────
            // Kolom sesuai ERD:
            //   posting_date  → tanggal hari ini (dataset tidak punya tanggal)
            //   status        → 'done' (data historis augmented)
            //   pillar        → pillar (CSV)
            //   topic         → topic (CSV)
            $planId = DB::table('content_plans')->insertGetId([
                'posting_date'         => $postingDate,
                'status'               => 'done',
                'pillar'               => $d['pillar'] ?? '',
                'topic'                => $d['topic']  ?? '',
                'asset_id'             => null,
                'notes_for_creator'    => null,
                'revision_notes'       => null,
                'approved'             => true,
                'video_path'           => null,
                'video_revision_notes' => null,
                'created_at'           => $now,
                'updated_at'           => $now,
            ]);

            // ── 2. editor_contents ────────────────────────────────────────────
            // Kolom sesuai ERD:
            //   content_title → title (CSV)
            //   script_brief  → script diformat [HOOK][BODY][CLOSING]
            //   post_type     → 'reels' (dataset platform instagram, augmented)
            DB::table('editor_contents')->insert([
                'content_plan_id'   => $planId,
                'post_type'         => 'reels',
                'content_title'     => $d['title']      ?? '',
                'script_brief'      => $scriptFormatted ?: null,
                'reference'         => null,
                'caption'           => null,
                'hashtag'           => null,
                'talent'            => null,
                'editor_name'       => 'System Augmented',
                'preview_thumbnail' => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ]);

            // ── 3. content_analytics ──────────────────────────────────────────
            // Kolom sesuai ERD:
            //   views           → views (CSV)
            //   likes           → likes (CSV)
            //   comments        → comments (CSV)
            //   shares          → shares (CSV)
            //   posting_hour    → posting_hour (CSV)
            //   hashtag_count   → hashtag_count (CSV)
            //   engagement_rate → er (CSV) — dalam persen, simpan as-is
            //   engagement_score→ er × views / 100
            DB::table('content_analytics')->insert([
                'content_plan_id'  => $planId,
                'platform'         => $d['platform'] ?? 'instagram',
                'views'            => $views,
                'likes'            => (int)   ($d['likes']         ?? 0),
                'comments'         => (int)   ($d['comments']      ?? 0),
                'shares'           => (int)   ($d['shares']        ?? 0),
                'posting_hour'     => (int)   ($d['posting_hour']  ?? 18),
                'posting_day'      => $postingDay,
                'caption_length'   => $captionLength,
                'hashtag_count'    => (int)   ($d['hashtag_count'] ?? 0),
                'engagement_rate'  => $er   ?: null,
                'engagement_score' => $engagementScore ?: null,
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);

            $count++;
            $this->command->getOutput()->progressAdvance();
        }

        fclose($handle);
        $this->command->getOutput()->progressFinish();
        $this->command->info("✅ Selesai! Total {$count} baris berhasil diimport.");
        $this->command->info("💡 Jalankan: php artisan ml:export untuk export dataset ML.");
    }

    /**
     * Standarisasi format script dari CSV ke format sistem:
     *
     * Input  (dari dataset):  "HOOK:\n...\nBODY:\n...\nCLOSING:\n..."
     * Output (ke DB)       :  "[HOOK]\n...\n\n[BODY]\n...\n\n[CLOSING]\n..."
     */
    protected function formatScript(string $raw): string
    {
        $raw = trim($raw);
        if (!$raw || strtolower($raw) === 'nan') return '';

        // Split berdasarkan penanda HOOK / BODY / CLOSING
        // Tangkap berbagai variasi: "HOOK:", "Hook:", "hook :", "[HOOK]", dst
        $pattern = '/\[?(?:HOOK|BODY|CLOSING)\]?\s*:?\s*/i';
        preg_match_all($pattern, $raw, $labelMatches, PREG_OFFSET_CAPTURE);
        $labels  = $labelMatches[0];

        if (count($labels) < 2) {
            // Tidak ada penanda → bagi jadi 3 bagian rata
            return $this->splitByThird($raw);
        }

        $hook = $body = $closing = '';

        foreach ($labels as $i => $labelInfo) {
            $labelText = strtolower(preg_replace('/[\[\]:?\s]/', '', $labelInfo[0]));
            $start     = $labelInfo[1] + strlen($labelInfo[0]);
            $end       = isset($labels[$i + 1]) ? $labels[$i + 1][1] : strlen($raw);
            $content   = trim(substr($raw, $start, $end - $start));

            if (str_starts_with($labelText, 'hook'))    $hook    = $content;
            elseif (str_starts_with($labelText, 'body')) $body   = $content;
            elseif (str_starts_with($labelText, 'clos')) $closing = $content;
        }

        return $this->buildFormat($hook, $body, $closing);
    }

    protected function splitByThird(string $text): string
    {
        $sentences = preg_split('/(?<=[.!?])\s+/', trim($text), -1, PREG_SPLIT_NO_EMPTY);
        $n         = count($sentences);
        $third     = max(1, (int) ceil($n / 3));

        $hook    = implode(' ', array_slice($sentences, 0, $third));
        $body    = implode(' ', array_slice($sentences, $third, $third));
        $closing = implode(' ', array_slice($sentences, $third * 2));

        if (!$body) {
            $len     = mb_strlen($text);
            $hook    = mb_substr($text, 0, (int) ($len / 3));
            $body    = mb_substr($text, (int) ($len / 3), (int) ($len / 3));
            $closing = mb_substr($text, (int) ($len * 2 / 3));
        }

        return $this->buildFormat($hook, $body, $closing);
    }

    protected function buildFormat(string $hook, string $body, string $closing): string
    {
        return implode("\n\n", array_filter([
            "[HOOK]\n"    . trim($hook),
            "[BODY]\n"    . trim($body),
            "[CLOSING]\n" . trim($closing),
        ]));
    }
}