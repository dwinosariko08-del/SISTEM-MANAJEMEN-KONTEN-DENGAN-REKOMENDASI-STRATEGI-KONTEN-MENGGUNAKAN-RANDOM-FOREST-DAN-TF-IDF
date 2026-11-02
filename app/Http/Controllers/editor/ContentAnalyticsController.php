<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\ContentPlan;
use App\Models\ContentAnalytics;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContentAnalyticsController extends Controller
{
    /**
     * Form input analytics
     */
    public function create(ContentPlan $content)
    {
        if ($content->status !== 'published') {
            abort(403);
        }

        if ($content->analytics) {
            return redirect()
                ->route('editor.analytics.show', $content->id);
        }

        return view('editor.analytics.create', compact('content'));
    }

    /**
     * Simpan analytics + hitung ERP
     */
    public function store(Request $request, ContentPlan $content)
    {
        if ($content->status !== 'published') {
            abort(403);
        }

        $request->validate([
            'platform' => 'required|in:instagram,tiktok',
            'views' => 'required|integer|min:1',
            'likes' => 'required|integer|min:0',
            'comments' => 'required|integer|min:0',
            'shares' => 'required|integer|min:0',
            'posting_hour' => 'required|integer|min:0|max:23',
            'posting_day' => 'required|string',
            'hashtag_count' => 'nullable|integer',
        ], [
            'views.min' => 'Views minimal harus bernilai 1.',
            'posting_hour.min' => 'Posting Hour harus antara 0 sampai 23.',
            'posting_hour.max' => 'Posting Hour harus antara 0 sampai 23.',
        ]);

        $views = $request->views;
        $likes = $request->likes;
        $comments = $request->comments;
        $shares = $request->shares;

        /**
         * Hitung Engagement Rate
         */
        $engagementRate = (($likes + $comments + $shares) / $views) * 100;

        /**
         * Hitung Engagement Score
         */
        if ($request->platform === 'instagram') {

            $score = ($likes * 1) + ($comments * 2) + ($shares * 3);

        } else {

            $score = ($likes * 1) + ($comments * 2) + ($shares * 4);

        }

        ContentAnalytics::create([
            'content_plan_id' => $content->id,
            'platform' => $request->platform,
            'views' => $views,
            'likes' => $likes,
            'comments' => $comments,
            'shares' => $shares,
            'posting_hour' => $request->posting_hour,
            'posting_day' => $request->posting_day,
            'hashtag_count' => $request->hashtag_count,
            'engagement_rate' => $engagementRate,
            'engagement_score' => $score,
        ]);

        return redirect()
            ->route('editor.analytics.show', $content->id)
            ->with('success', 'Analytics berhasil disimpan');
    }

    /**
     * Lihat hasil analytics
     */
    public function show(ContentPlan $content)
    {
        $analytics = $content->analytics;

        if (!$analytics) {
            return redirect()
                ->route('editor.analytics.create', $content->id);
        }

        return view('editor.analytics.show', compact('content', 'analytics'));
    }

  public function export()
{
    $data = ContentPlan::with(['editorContent', 'analytics'])->get();

    $response = new StreamedResponse(function () use ($data) {

        $handle = fopen('php://output', 'w');

        // HEADER CSV
        fputcsv($handle, [
            'pillar',
            'topic',
            'title',
            'script',
            'platform',
            'posting_hour',
            'hashtag_count',
            'views',
            'likes',
            'comments',
            'shares',
            'er',
            'label'
        ]);

        foreach ($data as $item) {

            // 🔥 AMANKAN RELASI
            $a = $item->analytics;

            $views = $a->views ?? 0;
            $likes = $a->likes ?? 0;
            $comments = $a->comments ?? 0;
            $shares = $a->shares ?? 0;

            // 🔥 HITUNG ER
            $er = $views > 0 
                ? (($likes + $comments + $shares) / $views) * 100 
                : 0;

            // 🔥 LABEL ML
            $label = $er >= 2.07 ? 'HIGH' : 'LOW';

            fputcsv($handle, [
                $item->pillar,
                $item->topic,
                optional($item->editorContent)->content_title,
                optional($item->editorContent)->script_brief,
                $a->platform ?? '',
                $a->posting_hour ?? '',
                $a->hashtag_count ?? '',
                $views,
                $likes,
                $comments,
                $shares,
                round($er, 2),
                $label
            ]);
        }

        fclose($handle);
    });

    // 🔥 FIX RESPONSE HEADER
    $response->headers->set('Content-Type', 'text/csv');
    $response->headers->set('Content-Disposition', 'attachment; filename="dataset_ml.csv"');

    return $response;
}
}