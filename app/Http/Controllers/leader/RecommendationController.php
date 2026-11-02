<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\ContentPlan;
use Illuminate\Support\Facades\Http;

class RecommendationController extends Controller
{
    public function index()
    {
        $data = ContentPlan::with([
            'analytics',
            'editorContent'
        ])
        ->where('status', 'published')
        ->get();

        if ($data->isEmpty()) {

            return view('leader.recommendations.index', [
                'recommendation' => null,
                'top' => [],
                'insight' => null
            ]);
        }

        $results = [];

        foreach ($data as $item) {

            if (!$item->analytics) {
                continue;
            }

            $a = $item->analytics;

            if (!$a->views || $a->views <= 0) {
                continue;
            }

            $er = (
                ($a->likes + $a->comments + $a->shares)
                / $a->views
            ) * 100;

            $results[] = [

                'pillar' => $item->pillar,

                'topic' => $item->topic,
                
                'script' => $item->editorContent->script_brief ?? $item->topic,
                
                'title' => $item->editorContent->content_title ?? $item->topic,

                'platform' => $a->platform,

                'hour' => $a->posting_hour,

                'hashtag_count' => $a->hashtag_count ?? 5,

                'er' => round($er, 2)
            ];
        }

        if (empty($results)) {

            return view('leader.recommendations.index', [
                'recommendation' => null,
                'top' => [],
                'insight' => null
            ]);
        }

        // ==========================
        // SORT BERDASARKAN ER
        // ==========================
        usort($results, function ($a, $b) {

            return $b['er'] <=> $a['er'];

        });

        $top = array_slice($results, 0, 10);

        // ==========================
        // AMBIL POLA TERBAIK (VARIATIF DARI TOP 5)
        // ==========================

        $top5 = array_slice($top, 0, 5);
        $bestPattern = $top5[array_rand($top5)];

        $platform = $bestPattern['platform'] ?? 'instagram';
        $pillar = $bestPattern['pillar'] ?? 'Problem Solving';
        $hour = $bestPattern['hour'] ?? 19;
        
        // Hashtag ideal berdasarkan kombinasi terbaik tersebut
        $avgHashtag = $bestPattern['hashtag_count'] ?? 5;

        $avgEr = round(
            collect($top)->avg('er'),
            2
        );

        // ==========================
        // GENERATE TOPIC BARU
        // ==========================
        $topics =
            config('content_ideas.' . $pillar, []);

        // Jika ada di config, ambil acak. Jika tidak, gunakan topik dari pattern terbaik.
        // Jika pattern terbaik juga tidak punya topik, gunakan default.
        $topic =
            count($topics)
                ? $topics[array_rand($topics)]
                : ($bestPattern['topic'] ?? 'Konten Baru');

        // ==========================
        // RANGE JAM
        // ==========================
        $endHour = min($hour + 2, 23);

        $hourRange =
            sprintf('%02d:00', $hour)
            . ' - '
            . sprintf('%02d:00', $endHour);

        // ==========================
        // PREDIKSI RANDOM FOREST
        // ==========================
        $confidence = 0;
        $prediction = 'UNKNOWN';

        try {

            $response = Http::timeout(10)
                ->post(
                    env('AI_API_URL', 'https://sistem-manajemen-konten.vercel.app') . '/api/predict',
                    [

                        'platform' => $platform,

                        'posting_hour' => (int) $hour,

                        'hashtag_count' => (int) $avgHashtag,

                        'topic' => $topic,

                        'script' => $bestPattern['script'] ?? $topic,

                        'pillar' => $pillar,
                        
                        'title' => $bestPattern['title'] ?? $topic,


                    ]
                );

            if ($response->successful()) {

                $json = $response->json();

                $prediction =
                    $json['prediction']
                    ?? 'UNKNOWN';

                $rawConf = $json['confidence'] ?? 0;
                // Jika server mengirimkan angka desimal 0-1, kalikan 100. Jika 1-100, biarkan.
                $confPercentage = $rawConf <= 1 ? $rawConf * 100 : $rawConf;
                
                // Pastikan persentase tidak melebihi 100%
                $confidence = min(round($confPercentage), 100);
            }

        } catch (\Exception $e) {

            $prediction = 'ERROR';
            $confidence = 0;
        }



        // ==========================
        // FINAL REKOMENDASI
        // ==========================
        $recommendation = [

            'platform' => strtoupper($platform),

            'pillar' => $pillar,

            'topic' => $topic,

            'title' => $bestPattern['title'] ?? $topic,

            'script' => $bestPattern['script'] ?? '',

            'hour' => $hourRange,

            'hashtag' => $avgHashtag,

            'prediction' => $prediction,

            'potential' => $confidence
        ];

        // ==========================
        // INSIGHT DASHBOARD
        // ==========================
        $insight = [

            'platform' => strtoupper($platform),

            'pillar' => $pillar,

            'avg_er' => $avgEr,

            'hour' => sprintf('%02d:00', $hour)
        ];

        return view(
            'leader.recommendations.index',
            compact(
                'recommendation',
                'top',
                'insight'
            )
        );
    }
}