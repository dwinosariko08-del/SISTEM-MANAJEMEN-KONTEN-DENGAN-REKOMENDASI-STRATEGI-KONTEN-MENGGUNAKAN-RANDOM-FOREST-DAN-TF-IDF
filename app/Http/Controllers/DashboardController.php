<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\ContentPlan;
use App\Models\EditorContent;
use App\Models\ContentAnalytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard sesuai role user yang login
     */
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'leader'   => $this->leaderDashboard(),
            'editor'   => $this->editorDashboard(),
            'lapangan' => $this->lapanganDashboard(),
            default    => redirect('/'),
        };
    }

    /**
     * Dashboard untuk Leader
     */
    private function leaderDashboard()
    {
        // 1. Stats Card
        $stats = [
            'total_plans'         => ContentPlan::count(),
            'pending_script'      => ContentPlan::whereIn('status', ['on_progress', 'revision'])->count(),
            'pending_video'       => ContentPlan::whereIn('status', ['video_uploaded', 'video_revision'])->count(),
            'total_published'     => ContentPlan::where('status', 'published')->count(),
        ];

        // 2. Status Distribution
        $statusRaw = ContentPlan::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statusStats = [
            'assigned' => $statusRaw['assigned'] ?? 0,
            'scripting' => ($statusRaw['on_progress'] ?? 0) + ($statusRaw['revision'] ?? 0),
            'video' => ($statusRaw['done'] ?? 0) + ($statusRaw['video_uploaded'] ?? 0) + ($statusRaw['video_revision'] ?? 0),
            'published' => $statusRaw['published'] ?? 0,
        ];

        // 3. Average Engagement Rate by Pillar Konten
        $pillarPerformance = ContentPlan::join('content_analytics', 'content_plans.id', '=', 'content_analytics.content_plan_id')
            ->selectRaw('content_plans.pillar, AVG(content_analytics.engagement_rate) as avg_er')
            ->groupBy('content_plans.pillar')
            ->pluck('avg_er', 'pillar')
            ->toArray();

        // Format chart data
        $pillarChart = [
            'labels' => array_keys($pillarPerformance),
            'data'   => array_map(fn($val) => round($val, 2), array_values($pillarPerformance)),
        ];

        // 4. Recent Assets from Lapangan
        $recentAssets = Asset::with('uploader')
            ->latest()
            ->take(5)
            ->get();

        // 5. Recent Video Upload Status
        $recentVideos = ContentPlan::whereIn('status', ['video_uploaded', 'video_revision', 'published'])
            ->with(['producedVideo', 'editorContent'])
            ->latest()
            ->take(5)
            ->get();

        return view('leader.dashboard', compact('stats', 'statusStats', 'pillarChart', 'recentAssets', 'recentVideos'));
    }

    /**
     * Dashboard untuk Editor
     */
    private function editorDashboard()
    {
        // 1. Stats Card
        $stats = [
            'total_tasks'     => ContentPlan::count(),
            'new_tasks'       => ContentPlan::where('status', 'assigned')->count(),
            'needs_revision'  => ContentPlan::whereIn('status', ['revision', 'video_revision'])->count(),
            'done_published'  => ContentPlan::where('status', 'published')->count(),
        ];

        // 2. Average ER by Post Type (Reels, Feed, Tiktok)
        $postTypePerformance = EditorContent::join('content_analytics', 'editor_contents.content_plan_id', '=', 'content_analytics.content_plan_id')
            ->selectRaw('editor_contents.post_type, AVG(content_analytics.engagement_rate) as avg_er')
            ->groupBy('editor_contents.post_type')
            ->pluck('avg_er', 'post_type')
            ->toArray();

        $postTypeChart = [
            'labels' => array_map(fn($label) => ucfirst($label), array_keys($postTypePerformance)),
            'data'   => array_map(fn($val) => round($val, 2), array_values($postTypePerformance)),
        ];

        // 3. Engagement Rate by Posting Hour (Line Chart)
        $peakHoursRaw = ContentAnalytics::selectRaw('posting_hour, AVG(engagement_rate) as avg_er')
            ->groupBy('posting_hour')
            ->orderBy('posting_hour')
            ->get();

        $peakHoursChart = [
            'labels' => $peakHoursRaw->pluck('posting_hour')->map(fn($h) => sprintf('%02d:00', $h))->toArray(),
            'data'   => $peakHoursRaw->pluck('avg_er')->map(fn($val) => round($val, 2))->toArray(),
        ];

        // 4. Priority Tasks (Tasks waiting for scripts, review revisions, or video production)
        $priorityTasks = ContentPlan::with(['asset', 'editorContent'])
            ->whereIn('status', ['assigned', 'revision', 'done', 'video_revision'])
            ->latest()
            ->take(5)
            ->get();

        // 5. Popular Pillars recommendations (shortcut references)
        $popularPillars = ContentPlan::join('content_analytics', 'content_plans.id', '=', 'content_analytics.content_plan_id')
            ->selectRaw('content_plans.pillar, AVG(content_analytics.engagement_rate) as avg_er, COUNT(*) as count')
            ->groupBy('content_plans.pillar')
            ->orderByDesc('avg_er')
            ->take(3)
            ->get();

        return view('editor.dashboard', compact('stats', 'postTypeChart', 'peakHoursChart', 'priorityTasks', 'popularPillars'));
    }

    /**
     * Dashboard untuk Tim Lapangan
     */
    private function lapanganDashboard()
    {
        $userId = Auth::id();

        // 1. Stats Card
        $stats = [
            'my_assets'     => Asset::where('uploaded_by', $userId)->count(),
            'my_clients'    => Asset::where('uploaded_by', $userId)->distinct('nama_client')->count('nama_client'),
            'my_locations'  => Asset::where('uploaded_by', $userId)->distinct('lokasi')->count('lokasi'),
        ];

        // 2. Project Type Distribution uploaded by this user (commercial, wedding, event, etc.)
        $projectTypeRaw = Asset::where('uploaded_by', $userId)
            ->selectRaw('jenis_project, count(*) as count')
            ->groupBy('jenis_project')
            ->pluck('count', 'jenis_project')
            ->toArray();

        $projectTypeChart = [
            'labels' => array_keys($projectTypeRaw),
            'data'   => array_values($projectTypeRaw),
        ];

        // 3. Monthly Upload Activity Trend (this year)
        $monthlyUploadsRaw = Asset::where('uploaded_by', $userId)
            ->whereYear('created_at', date('Y'))
            ->selectRaw('MONTH(created_at) as month, count(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthsIndo = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        $monthlyLabels = [];
        $monthlyData = [];

        foreach ($monthlyUploadsRaw as $row) {
            $monthlyLabels[] = $monthsIndo[$row->month] ?? $row->month;
            $monthlyData[] = $row->count;
        }

        // Fallback jika kosong agar chart tidak rusak
        if (empty($monthlyLabels)) {
            $monthlyLabels = [$monthsIndo[(int)date('n')]];
            $monthlyData = [0];
        }

        $monthlyChart = [
            'labels' => $monthlyLabels,
            'data'   => $monthlyData,
        ];

        // 4. Recent uploads by this user
        $myRecentAssets = Asset::where('uploaded_by', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('lapangan.dashboard', compact('stats', 'projectTypeChart', 'monthlyChart', 'myRecentAssets'));
    }
}
