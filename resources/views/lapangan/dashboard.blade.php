@extends('layouts.lapangan.app')

@section('title', 'Lapangan Dashboard')

@section('content')

<style>
    /* ============================================================
       Soft Light Theme — Clean Cards / Pastel Icons (selaras dengan Leader & Editor Dashboard)
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

        /* Aksen khusus role Tim Lapangan, dipakai terbatas hanya pada CTA upload */
        --corp-teal:    #0D9488;
        --corp-teal-bg: #E7F8F5;

        --corp-font-body: "Segoe UI", -apple-system, BlinkMacSystemFont, sans-serif;
    }


    .corp-transition-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .corp-transition-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(20, 30, 60, 0.06);
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
    .corp-header-icon {
        color: var(--corp-blue);
        opacity: 0.5;
        font-size: 56px;
    }

    /* ---------- Cards ---------- */
    .corp-card {
        background: var(--corp-surface);
        border: 1px solid var(--corp-border);
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(20, 30, 60, 0.04);
    }

    .corp-stat-label {
        color: var(--corp-text-secondary);
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.6px;
        font-weight: 700;
    }
    .corp-stat-number {
        font-weight: 800;
        color: var(--corp-text-primary);
        font-size: 26px;
        letter-spacing: -0.3px;
    }

    .corp-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }
    .corp-icon-blue   { background: var(--corp-blue-bg); color: var(--corp-blue); }
    .corp-icon-orange { background: var(--corp-orange-bg); color: var(--corp-orange); }
    .corp-icon-green  { background: var(--corp-green-bg); color: var(--corp-green); }

    .corp-section-title {
        font-weight: 700;
        color: var(--corp-text-primary);
        font-size: 16px;
        letter-spacing: -0.1px;
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
    }
    .corp-table-date {
        color: var(--corp-text-muted);
        font-size: 12px;
    }
    .corp-empty {
        color: var(--corp-text-muted);
        font-size: 13.5px;
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
        display: inline-block;
    }
    .corp-btn-outline:hover {
        border-color: var(--corp-teal);
        color: var(--corp-teal);
    }

    /* ---------- Upload CTA ---------- */
    .corp-cta-card {
        background: var(--corp-surface);
        border: 1.5px dashed var(--corp-teal);
        border-radius: 14px;
    }
    .corp-cta-icon-wrap {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: var(--corp-teal-bg);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .corp-cta-icon-wrap i {
        font-size: 32px;
        color: var(--corp-teal);
    }
    .corp-cta-title {
        font-weight: 700;
        color: var(--corp-text-primary);
        font-size: 16px;
    }
    .corp-cta-desc {
        color: var(--corp-text-secondary);
        font-size: 13px;
        line-height: 1.6;
    }
    .corp-btn-teal {
        background: var(--corp-teal);
        border: 1px solid var(--corp-teal);
        color: #FFFFFF;
        font-weight: 700;
        font-size: 14px;
        padding: 12px 20px;
        border-radius: 10px;
        text-decoration: none;
        display: block;
        width: 100%;
        transition: all 0.15s ease;
    }
    .corp-btn-teal:hover {
        filter: brightness(1.05);
        color: #FFFFFF;
    }
</style>

    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 corp-header">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-2 corp-header-title">Selamat Datang, {{ Auth::user()->name }}</h2>
                        <p class="mb-0 corp-header-sub">
                            <span class="corp-badge-gold me-2">Tim Lapangan</span>
                            <span class="d-block d-md-inline mt-1 mt-md-0">Dokumentasikan event, upload asset mentah (raw footage) berkualitas tinggi, dan kembangkan bank asset Media Informatika.</span>
                        </p>
                    </div>
                    <div class="d-none d-md-block">
                        <i class="mdi mdi-camera corp-header-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="row">
        <!-- Card 1: Total Asset Saya -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-0 h-100 corp-card corp-transition-hover">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 corp-stat-label">Asset Diupload</p>
                            <h3 class="mb-0 corp-stat-number">{{ $stats['my_assets'] }} Asset</h3>
                        </div>
                        <div class="corp-icon corp-icon-blue">
                            <i class="mdi mdi-folder-video"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Klien Diliput -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-0 h-100 corp-card corp-transition-hover">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 corp-stat-label">Klien / Brand</p>
                            <h3 class="mb-0 corp-stat-number">{{ $stats['my_clients'] }} Klien</h3>
                        </div>
                        <div class="corp-icon corp-icon-orange">
                            <i class="mdi mdi-handshake"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Lokasi Dikunjungi -->
        <div class="col-xl-4 col-md-12 mb-4">
            <div class="card border-0 h-100 corp-card corp-transition-hover">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 corp-stat-label">Lokasi Project</p>
                            <h3 class="mb-0 corp-stat-number">{{ $stats['my_locations'] }} Kota / Lokasi</h3>
                        </div>
                        <div class="corp-icon corp-icon-green">
                            <i class="mdi mdi-map-marker-radius"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <!-- Bar Chart: Monthly Upload Activities -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 h-100 corp-card">
                <div class="card-body">
                    <h5 class="mb-4 corp-section-title">Aktivitas Upload Asset Anda (Tahun Ini)</h5>
                    <div style="height: 300px;">
                        <canvas id="monthlyUploadsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Doughnut Chart: Project Type Distribution -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 h-100 corp-card">
                <div class="card-body">
                    <h5 class="mb-4 corp-section-title">Tipe Project Liputan</h5>
                    <div style="height: 220px; position: relative;">
                        <canvas id="projectTypeChart"></canvas>
                    </div>
                    <div class="mt-4 text-center">
                        <small class="corp-table-secondary d-block">Distribusi jenis project yang Anda unggah.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload CTA & Recent Upload List -->
    <div class="row">
        <!-- List: Recent Assets Uploaded by This User -->
        <div class="col-xl-8 mb-4">
            <div class="card border-0 h-100 corp-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0 corp-section-title">Asset Terakhir yang Anda Upload</h5>
                        <a href="{{ route('assets.index') }}" class="corp-btn-outline">Lihat Riwayat</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-centered mb-0 align-middle corp-table">
                            <thead>
                                <tr>
                                    <th class="px-3 py-3">Client / Project</th>
                                    <th class="py-3">Lokasi</th>
                                    <th class="py-3">Link Drive</th>
                                    <th class="py-3">Keterangan</th>
                                    <th class="px-3 py-3">Tanggal Upload</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($myRecentAssets as $asset)
                                    <tr>
                                        <td class="px-3 py-3">
                                            <div class="corp-table-primary">{{ $asset->nama_client }}</div>
                                            <small class="corp-table-secondary">{{ $asset->jenis_project }}</small>
                                        </td>
                                        <td class="py-3">{{ $asset->lokasi }}</td>
                                        <td class="py-3">
                                            <a href="{{ $asset->gdrive_link }}" target="_blank" class="corp-btn-drive">
                                                <i class="fab fa-google-drive"></i> Drive Link
                                            </a>
                                        </td>
                                        <td class="py-3">
                                            <span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $asset->keterangan ?? '-' }}">
                                                {{ $asset->keterangan ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-3 corp-table-date">{{ \Carbon\Carbon::parse($asset->created_at)->format('d M Y, H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 corp-empty">
                                            <i class="mdi mdi-folder-open-outline d-block mb-2" style="font-size: 32px; opacity: 0.35;"></i>
                                            Anda belum pernah mengunggah asset. Mulai unggah sekarang!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Big Upload CTA Card -->
        <div class="col-xl-4 mb-4">
            <div class="card border-0 h-100 text-center corp-cta-card">
                <div class="card-body d-flex flex-column justify-content-center align-items-center p-4">
                    <div class="mb-4 corp-cta-icon-wrap">
                        <i class="mdi mdi-cloud-upload"></i>
                    </div>
                    <h5 class="mb-2 corp-cta-title">Punya Raw Asset Baru?</h5>
                    <p class="mb-4 corp-cta-desc">Pastikan video/foto di Google Drive disetel ke <b>"Anyone with the link can view/download"</b> agar tim Editor bisa mengambil asset dengan lancar.</p>

                    <a href="{{ route('assets.create') }}" class="corp-btn-teal">
                        <i class="mdi mdi-plus me-1"></i> Upload Asset Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
<!-- Load Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // --- Monthly Upload Activity Bar Chart ---
        const ctxMonthly = document.getElementById('monthlyUploadsChart').getContext('2d');

        new Chart(ctxMonthly, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthlyChart['labels']) !!},
                datasets: [{
                    label: 'Jumlah Asset Terupload',
                    data: {!! json_encode($monthlyChart['data']) !!},
                    backgroundColor: '#3B82F6',
                    borderColor: '#3B82F6',
                    borderWidth: 1,
                    borderRadius: 6,
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
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(20,30,60,0.04)' },
                        ticks: {
                            stepSize: 1,
                            color: '#9AA3B2',
                            font: { size: 11 }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#6B7280',
                            font: { size: 11, weight: '500' }
                        }
                    }
                }
            }
        });

        // --- Project Type Distribution Doughnut Chart ---
        const ctxProject = document.getElementById('projectTypeChart').getContext('2d');
        new Chart(ctxProject, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($projectTypeChart['labels']) !!},
                datasets: [{
                    data: {!! json_encode($projectTypeChart['data']) !!},
                    backgroundColor: [
                        '#3B82F6', // Blue
                        '#F59E0B', // Orange
                        '#10B981', // Green
                        '#EF4444', // Red
                        '#0D9488'  // Teal (variasi tambahan jika tipe project > 4)
                    ],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            color: '#6B7280',
                            font: { size: 11 },
                            padding: 12
                        }
                    },
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