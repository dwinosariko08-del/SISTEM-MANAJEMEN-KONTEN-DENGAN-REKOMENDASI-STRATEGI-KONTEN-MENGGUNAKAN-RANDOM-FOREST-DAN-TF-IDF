@extends('layouts.leader.app')

@section('title', 'Leader Dashboard')

@section('content')

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 overflow-hidden corp-header">
                    <div class="card-body p-4 position-relative">
                        <div class="row align-items-center position-relative" style="z-index: 1;">
                            <div class="col-md-8">
                                <h2 class="mb-2 corp-header-title">Selamat Datang, {{ Auth::user()->name }}</h2>
                                <p class="mb-0 corp-header-sub">
                                    <span class="badge corp-badge-gold me-2">Content Leader</span>
                                    <span class="d-block d-md-inline mt-1 mt-md-0">Pantau seluruh alur kerja konten, tinjau script, dan verifikasi video di sini.</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-6 col-xxl-3 mb-4">
                <div class="card h-100 corp-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="corp-icon corp-icon-navy">
                                    <i class="mdi mdi-folder-multiple-image"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 corp-label">Total Konten</h6>
                            </div>
                        </div>
                        <div class="corp-stat-box mt-3 d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="mb-1 corp-stat-number">{{ $stats['total_plans'] }}</h3>
                                <p class="mb-0 corp-stat-caption">Semua pilar konten</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xxl-3 mb-4">
                <div class="card h-100 corp-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="corp-icon corp-icon-gold">
                                    <i class="mdi mdi-file-document-edit"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 corp-label">Butuh Review Script</h6>
                            </div>
                        </div>
                        <div class="corp-stat-box mt-3 d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="mb-1 corp-stat-number">{{ $stats['pending_script'] }}</h3>
                                <p class="mb-0 corp-stat-caption">Menunggu persetujuan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xxl-3 mb-4">
                <div class="card h-100 corp-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="corp-icon corp-icon-slate">
                                    <i class="mdi mdi-video-vintage"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 corp-label">Butuh Review Video</h6>
                            </div>
                        </div>
                        <div class="corp-stat-box mt-3 d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="mb-1 corp-stat-number">{{ $stats['pending_video'] }}</h3>
                                <p class="mb-0 corp-stat-caption">Siap diperiksa</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xxl-3 mb-4">
                <div class="card h-100 corp-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="corp-icon corp-icon-navy">
                                    <i class="mdi mdi-check-circle"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 corp-label">Published / Done</h6>
                            </div>
                        </div>
                        <div class="corp-stat-box mt-3 d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="mb-1 corp-stat-number">{{ $stats['total_published'] }}</h3>
                                <p class="mb-0 corp-stat-caption">Performa meningkat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card h-100 corp-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="mb-0 corp-section-title">Rata-rata Engagement Rate per Pilar Konten</h5>
                            <span class="corp-tag">Dalam Persentase (%)</span>
                        </div>
                        <div style="height: 310px; position: relative;">
                            <canvas id="pillarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card h-100 corp-card">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="mb-4 corp-section-title">Status Semua Konten</h5>
                            <div style="height: 200px; position: relative; margin: 0 auto;">
                                <canvas id="statusChart"></canvas>
                            </div>
                        </div>
                        <div class="row g-2 mt-4 pt-3 corp-divider-top">
                            <div class="col-6 text-center corp-divider-right">
                                <span class="d-block corp-mini-label mb-1"><i class="mdi mdi-lead-pencil me-1"></i> Scripting</span>
                                <h5 class="mb-0 corp-mini-number">{{ $statusStats['scripting'] }} <span class="corp-mini-unit">Plan</span></h5>
                            </div>
                            <div class="col-6 text-center">
                                <span class="d-block corp-mini-label mb-1"><i class="mdi mdi-video-vintage me-1"></i> Video</span>
                                <h5 class="mb-0 corp-mini-number">{{ $statusStats['video'] }} <span class="corp-mini-unit">Plan</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 mb-4">
                <div class="card h-100 corp-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="mb-0 corp-section-title">Asset Raw Terbaru <span class="corp-section-subtitle">(Tim Lapangan)</span></h5>
                            <a href="{{ route('assets.index') }}" class="corp-btn-outline">Lihat Semua</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 corp-table">
                                <thead>
                                    <tr>
                                        <th class="px-3 py-3">Client / Project</th>
                                        <th class="py-3">Lokasi</th>
                                        <th class="py-3">Uploaded By</th>
                                        <th class="py-3">Link Drive</th>
                                        <th class="px-3 py-3">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentAssets as $asset)
                                        <tr>
                                            <td class="px-3 py-3">
                                                <div class="corp-table-primary">{{ $asset->nama_client }}</div>
                                                <div class="corp-table-secondary">{{ $asset->jenis_project }}</div>
                                            </td>
                                            <td class="py-3"><i class="mdi mdi-map-marker-outline me-1 corp-table-icon"></i>{{ $asset->lokasi }}</td>
                                            <td class="py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="corp-avatar me-2">
                                                        {{ strtoupper(substr($asset->uploader->name ?? 'U', 0, 2)) }}
                                                    </div>
                                                    <span class="corp-table-name">{{ $asset->uploader->name ?? 'Unknown' }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <a href="{{ $asset->gdrive_link }}" target="_blank" class="corp-btn-drive">
                                                    <i class="fab fa-google-drive"></i> Drive Link
                                                </a>
                                            </td>
                                            <td class="px-3 py-3 corp-table-date">{{ \Carbon\Carbon::parse($asset->created_at)->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 corp-empty">
                                                <i class="mdi mdi-folder-open-outline d-block mb-2" style="font-size: 32px; opacity: 0.35;"></i>
                                                Belum ada asset raw diupload.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 mb-4">
                <div class="card mb-4 corp-card">
                    <div class="card-body">
                        <h5 class="mb-3 corp-section-title">Aksi Cepat Leader</h5>
                        <div class="d-flex flex-column" style="gap: 10px;">
                            <a href="{{ route('leader.contents.create') }}" class="corp-action corp-action-primary">
                                <span><i class="mdi mdi-plus-circle-outline me-2"></i> Buat Plan Baru</span>
                                <i class="mdi mdi-chevron-right"></i>
                            </a>
                            <a href="{{ route('leader.contents.index') }}" class="corp-action corp-action-light">
                                <span><i class="mdi mdi-playlist-check me-2 corp-action-icon-gold"></i> Tinjau Script / Konten</span>
                                <span class="corp-count-badge corp-count-gold">{{ $stats['pending_script'] }}</span>
                            </a>
                            <a href="{{ route('leader.contents.index') }}" class="corp-action corp-action-light">
                                <span><i class="mdi mdi-video-switch me-2 corp-action-icon-slate"></i> Tinjau Video Editor</span>
                                <span class="corp-count-badge corp-count-slate">{{ $stats['pending_video'] }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card corp-card">
                    <div class="card-body">
                        <h5 class="mb-3 corp-section-title">Pekerjaan Video Terbaru</h5>
                        <div class="slimscroll" style="max-height: 290px; overflow-y: auto; padding-right: 4px;">
                            @forelse($recentVideos as $videoPlan)
                                <div class="pb-3 mb-3 d-flex align-items-start justify-content-between corp-list-item">
                                    <div style="max-width: 72%;">
                                        <h6 class="mb-1 text-truncate corp-list-title">{{ $videoPlan->editorContent->content_title ?? $videoPlan->topic }}</h6>
                                        <div class="corp-list-meta d-flex align-items-center flex-wrap" style="gap: 6px;">
                                            <span>Pilar: {{ $videoPlan->pillar }}</span>
                                            <span class="corp-list-divider">|</span>
                                            <span class="text-truncate">Editor: {{ $videoPlan->editorContent->editor_name ?? 'System' }}</span>
                                        </div>
                                    </div>
                                    <div class="ps-2">
                                        @if($videoPlan->status === 'video_uploaded')
                                            <span class="corp-status corp-status-slate">Uploaded</span>
                                        @elseif($videoPlan->status === 'video_revision')
                                            <span class="corp-status corp-status-gold">Revisi</span>
                                        @elseif($videoPlan->status === 'published')
                                            <span class="corp-status corp-status-navy">Published</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center corp-empty py-4">
                                    <i class="mdi mdi-video-off-outline d-block mb-1" style="font-size: 26px; opacity: 0.4;"></i>
                                    <span style="font-size: 13px;">Belum ada progres video.</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>


<style>
    /* ============================================================
       Soft Light Theme — Clean Cards / Pastel Icons (ala referensi)
       ============================================================ */

    :root {
        --corp-bg: #F5F7FA;
        --corp-surface: #FFFFFF;
        --corp-border: #EEF1F6;
        --corp-text-primary: #15192B;
        --corp-text-secondary: #6B7280;
        --corp-text-muted: #9AA3B2;

        --corp-blue:    #3B82F6;
        --corp-blue-bg: #EAF1FF;
        --corp-orange:    #F59E0B;
        --corp-orange-bg: #FFF3E2;
        --corp-green:    #10B981;
        --corp-green-bg: #E7F8ED;
        --corp-red:    #EF4444;
        --corp-red-bg: #FDEAEC;

        --corp-accent: #3B82F6;

        --corp-font-body: "Segoe UI", -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .pc-container {
        /* wrapper dihilangkan */
    }

    @media (max-width: 1024px) {
        .pc-container {
            /* margin dihilangkan */
        }
    }

    .pc-content, .pc-content * {
        font-family: var(--corp-font-body);
    }

    /* ---------- Header band ---------- */
    .corp-header {
        background: var(--corp-surface);
        border-radius: 14px;
        border: 1px solid var(--corp-border);
        box-shadow: 0 2px 10px rgba(20, 30, 60, 0.04);
    }
    .corp-header-title {
        font-weight: 700;
        color: var(--corp-text-primary);
        font-size: 23px;
        letter-spacing: -0.2px;
    }
    .corp-header-sub {
        color: var(--corp-text-secondary);
        font-size: 13.5px;
        line-height: 1.7;
    }
    .corp-badge-gold {
        display: inline-block;
        background: var(--corp-blue-bg);
        color: var(--corp-blue);
        font-weight: 700;
        font-size: 10.5px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 6px;
    }

    /* ---------- Cards ---------- */
    .corp-card {
        background: var(--corp-surface);
        border: 1px solid var(--corp-border);
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(20, 30, 60, 0.04);
    }

    .corp-label {
        color: var(--corp-text-secondary);
        font-size: 14px;
        font-weight: 600;
        font-family: var(--corp-font-body);
    }

    .corp-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .corp-icon-navy   { background: var(--corp-blue-bg); color: var(--corp-blue); }
    .corp-icon-gold   { background: var(--corp-orange-bg); color: var(--corp-orange); }
    .corp-icon-slate  { background: var(--corp-green-bg); color: var(--corp-green); }

    .corp-stat-box {
        background: var(--corp-bg);
        border: 1px solid var(--corp-border);
        border-radius: 12px;
        padding: 14px 16px;
    }
    .corp-stat-number {
        font-weight: 800;
        color: var(--corp-text-primary);
        font-size: 30px;
        letter-spacing: -0.5px;
    }
    .corp-stat-caption {
        color: var(--corp-text-secondary);
        font-size: 12px;
    }

    .corp-section-title {
        font-weight: 700;
        color: var(--corp-text-primary);
        font-size: 16px;
        letter-spacing: -0.1px;
    }
    .corp-section-subtitle {
        color: var(--corp-text-muted);
        font-weight: 400;
        font-size: 13px;
        font-family: var(--corp-font-body);
    }
    .corp-tag {
        background: var(--corp-bg);
        border: 1px solid var(--corp-border);
        color: var(--corp-text-secondary);
        font-size: 11px;
        padding: 4px 9px;
        border-radius: 6px;
        font-weight: 600;
    }

    .corp-divider-top {
        border-top: 1px solid var(--corp-border) !important;
    }
    .corp-divider-right {
        border-right: 1px solid var(--corp-border) !important;
    }
    .corp-mini-label {
        color: var(--corp-text-muted);
        font-size: 12px;
    }
    .corp-mini-number {
        font-weight: 700;
        color: var(--corp-text-primary);
    }
    .corp-mini-unit {
        color: var(--corp-text-muted);
        font-weight: 400;
        font-size: 12px;
        font-family: var(--corp-font-body);
    }

    /* ---------- Table ---------- */
    .corp-table thead tr {
        background: transparent;
    }
    .corp-table thead th {
        color: var(--corp-text-muted);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        font-weight: 700;
        border-bottom: 1px solid var(--corp-border);
    }
    .corp-table tbody tr {
        border-bottom: 1px solid var(--corp-border);
    }
    .corp-table tbody tr:hover {
        background: var(--corp-bg);
    }
    .corp-table tbody td {
        font-size: 13.5px;
        color: var(--corp-text-primary);
    }
    .corp-table-primary {
        font-weight: 700;
        color: var(--corp-text-primary);
        font-size: 14px;
    }
    .corp-table-secondary {
        color: var(--corp-text-muted);
        font-size: 11px;
        margin-top: 2px;
    }
    .corp-table-icon {
        color: var(--corp-text-muted);
    }
    .corp-table-name {
        font-weight: 600;
        color: var(--corp-text-primary);
    }
    .corp-table-date {
        color: var(--corp-text-muted);
        font-size: 12px;
    }
    .corp-avatar {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: var(--corp-blue-bg);
        color: var(--corp-blue);
        font-size: 10px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .corp-empty {
        color: var(--corp-text-muted);
        font-size: 13.5px;
    }

    .corp-btn-outline {
        border: 1px solid var(--corp-border);
        color: var(--corp-text-secondary);
        background: var(--corp-surface);
        font-size: 12px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .corp-btn-outline:hover {
        border-color: var(--corp-blue);
        color: var(--corp-blue);
    }

    .corp-btn-drive {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: 1px solid var(--corp-green-bg);
        color: var(--corp-green);
        background: var(--corp-green-bg);
        font-size: 11px;
        font-weight: 700;
        padding: 5px 10px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .corp-btn-drive:hover {
        filter: brightness(0.96);
    }

    /* ---------- Quick actions ---------- */
    .corp-action {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 13px 14px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        font-size: 13.5px;
        transition: all 0.15s ease;
    }
    .corp-action-primary {
        background: var(--corp-blue);
        color: #FFFFFF;
        border: 1px solid var(--corp-blue);
    }
    .corp-action-primary:hover {
        filter: brightness(1.05);
    }
    .corp-action-light {
        background: var(--corp-surface);
        color: var(--corp-text-primary);
        border: 1px solid var(--corp-border);
    }
    .corp-action-light:hover {
        border-color: var(--corp-blue);
        background: var(--corp-bg);
    }
    .corp-action-icon-gold { color: var(--corp-orange); }
    .corp-action-icon-slate { color: var(--corp-green); }

    .corp-count-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 6px;
        color: #FFFFFF;
    }
    .corp-count-gold { background: var(--corp-orange); }
    .corp-count-slate { background: var(--corp-green); }

    /* ---------- Video list ---------- */
    .corp-list-item {
        border-bottom: 1px solid var(--corp-border);
    }
    .corp-list-title {
        font-weight: 700;
        color: var(--corp-text-primary);
        font-size: 13.5px;
        font-family: var(--corp-font-body);
    }
    .corp-list-meta {
        color: var(--corp-text-muted);
        font-size: 11.5px;
    }
    .corp-list-divider {
        opacity: 0.5;
    }

    .corp-status {
        display: inline-block;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        padding: 4px 9px;
        border-radius: 6px;
    }
    .corp-status-navy  { background: var(--corp-blue-bg); color: var(--corp-blue); }
    .corp-status-gold  { background: var(--corp-orange-bg); color: var(--corp-orange); }
    .corp-status-slate { background: var(--corp-green-bg); color: var(--corp-green); }

    /* ---------- Scrollbar ---------- */
    .slimscroll::-webkit-scrollbar {
        width: 4px;
    }
    .slimscroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .slimscroll::-webkit-scrollbar-thumb {
        background: var(--corp-border);
        border-radius: 10px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // --- Pillar Performance Bar Chart ---
        const ctxPillar = document.getElementById('pillarChart').getContext('2d');

        new Chart(ctxPillar, {
            type: 'bar',
            data: {
                labels: {!! json_encode($pillarChart['labels']) !!},
                datasets: [{
                    label: 'Avg Engagement Rate (%)',
                    data: {!! json_encode($pillarChart['data']) !!},
                    backgroundColor: '#3B82F6',
                    borderColor: '#3B82F6',
                    borderWidth: 1,
                    borderRadius: 6,
                    borderSkipped: false,
                    barPercentage: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#15192B',
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return ` Engagement: ${context.parsed.y}%`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(20,30,60,0.04)' },
                        ticks: { color: '#9AA3B2', font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#6B7280', font: { size: 11, weight: '500' } }
                    }
                }
            }
        });

        // --- Status Distribution Doughnut Chart ---
        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Belum Mulai', 'Scripting', 'Video', 'Selesai'],
                datasets: [{
                    data: [{{ $statusStats['assigned'] }}, {{ $statusStats['scripting'] }}, {{ $statusStats['video'] }}, {{ $statusStats['published'] }}],
                    backgroundColor: [
                        '#9AA3B2', // assigned (muted)
                        '#F59E0B', // scripting (orange)
                        '#3B82F6', // video (blue)
                        '#10B981'  // published (green)
                    ],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#15192B',
                        padding: 10,
                        cornerRadius: 8
                    }
                }
            }
        });
    });
</script>
@endsection