@extends('layouts.editor.app')

@section('title', 'Editor Dashboard')

@section('content')

<style>
    /* ============================================================
       Soft Light Theme — Clean Cards / Pastel Icons (selaras dengan Leader Dashboard)
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

        --corp-font-body: "Segoe UI", -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* =========================
       GLOBAL DASHBOARD FIX
    ========================= */
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

    .transition-hover {
        transition: all .2s ease;
    }

    .transition-hover:hover {
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
        flex-shrink: 0;
    }
    .corp-icon-blue   { background: var(--corp-blue-bg); color: var(--corp-blue); }
    .corp-icon-orange { background: var(--corp-orange-bg); color: var(--corp-orange); }
    .corp-icon-red    { background: var(--corp-red-bg); color: var(--corp-red); }
    .corp-icon-green  { background: var(--corp-green-bg); color: var(--corp-green); }

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
    .corp-tag {
        background: var(--corp-bg);
        border: 1px solid var(--corp-border);
        color: var(--corp-text-secondary);
        font-size: 11px;
        padding: 4px 9px;
        border-radius: 6px;
        font-weight: 600;
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
    .corp-table-date {
        color: var(--corp-text-muted);
        font-size: 12px;
    }
    .corp-empty {
        color: var(--corp-text-muted);
        font-size: 13.5px;
    }

    .corp-status-pill {
        display: inline-block;
        background: var(--corp-blue-bg);
        color: var(--corp-blue);
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        text-transform: capitalize;
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
        border-color: var(--corp-blue);
        color: var(--corp-blue);
    }

    .corp-btn-primary {
        background: var(--corp-blue);
        border: 1px solid var(--corp-blue);
        color: #FFFFFF;
        font-size: 12px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.15s ease;
    }
    .corp-btn-primary:hover {
        filter: brightness(1.05);
        color: #FFFFFF;
    }

    .corp-btn-success {
        background: var(--corp-green);
        border: 1px solid var(--corp-green);
        color: #FFFFFF;
        font-size: 12px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.15s ease;
    }
    .corp-btn-success:hover {
        filter: brightness(1.05);
        color: #FFFFFF;
    }
</style>

<div class="pc-container">
    <div class="pc-content">

        {{-- ================= HERO ================= --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 overflow-hidden corp-header">
                    <div class="card-body p-4 position-relative">
                        <div class="row align-items-center position-relative" style="z-index:1;">
                            <div class="col-md-8">
                                <h2 class="mb-2 corp-header-title">
                                    Selamat Datang, {{ Auth::user()->name }}
                                </h2>

                                <p class="mb-0 corp-header-sub">
                                    <span class="corp-badge-gold me-2">Editor Konten</span>
                                    <span class="d-block d-md-inline mt-1 mt-md-0">Fokus script, editing & optimasi konten.</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= STATS ================= --}}
        <div class="row mb-2">

            @php
                $statsCards = [
                    ['icon'=>'mdi-filmstrip','color'=>'blue','title'=>'Total Konten','value'=>$stats['total_tasks'],'caption'=>'Seluruh tugas aktif'],
                    ['icon'=>'mdi-lead-pencil','color'=>'orange','title'=>'Tugas Baru','value'=>$stats['new_tasks'],'caption'=>'Menunggu dikerjakan'],
                    ['icon'=>'mdi-alert-circle','color'=>'red','title'=>'Revisi Konten','value'=>$stats['needs_revision'],'caption'=>'Perlu perbaikan'],
                    ['icon'=>'mdi-check-circle','color'=>'green','title'=>'Konten Selesai','value'=>$stats['done_published'],'caption'=>'Published / Done'],
                ];
            @endphp

            @foreach($statsCards as $card)
            <div class="col-md-6 col-xxl-3 mb-4">
                <div class="card h-100 transition-hover corp-card">
                    <div class="card-body">

                        <div class="d-flex align-items-center">
                            <div class="corp-icon corp-icon-{{ $card['color'] }}">
                                <i class="mdi {{ $card['icon'] }}"></i>
                            </div>

                            <div class="ms-3">
                                <h6 class="mb-0 corp-label">
                                    {{ $card['title'] }}
                                </h6>
                            </div>
                        </div>

                        <div class="corp-stat-box mt-3">
                            <h3 class="mb-1 corp-stat-number">{{ $card['value'] }}</h3>
                            <span class="corp-stat-caption">{{ $card['caption'] }}</span>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach

        </div>

        {{-- ================= CHART ================= --}}
        <div class="row">

            <div class="col-lg-8 mb-4">
                <div class="card h-100 corp-card">
                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="mb-0 corp-section-title">Engagement Rate per Jam Posting</h5>
                            <span class="corp-tag">Per Jam</span>
                        </div>

                        <div style="height:300px;">
                            <canvas id="hourChart"></canvas>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card h-100 corp-card">
                    <div class="card-body">

                        <h5 class="mb-3 corp-section-title">Tipe Konten Terbaik</h5>

                        <div style="height:220px;">
                            <canvas id="postTypeChart"></canvas>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        {{-- ================= PRIORITY TASK ================= --}}
        <div class="row">

            <div class="col-12 mb-4">
                <div class="card corp-card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 corp-section-title">Daftar Tugas</h5>

                            <a href="{{ route('editor.contents.index') }}"
                               class="corp-btn-outline">
                                Semua Tugas
                            </a>
                        </div>

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0 corp-table">

                                <thead>
                                    <tr>
                                        <th class="px-3 py-3">Topik</th>
                                        <th class="py-3">Schedule</th>
                                        <th class="py-3">Status</th>
                                        <th class="px-3 py-3 text-end">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>

                                @forelse($priorityTasks as $task)
                                    <tr>

                                        <td class="px-3 py-3">
                                            <div class="corp-table-primary">{{ $task->topic }}</div>
                                            <div class="corp-table-secondary">
                                                {{ $task->pillar }}
                                            </div>
                                        </td>

                                        <td class="py-3 corp-table-date">
                                            {{ \Carbon\Carbon::parse($task->posting_date)->format('d M Y') }}
                                        </td>

                                        <td class="py-3">
                                            <span class="corp-status-pill">
                                                {{ $task->status }}
                                            </span>
                                        </td>

                                        <td class="px-3 py-3 text-end">

                                            @if(in_array($task->status, ['assigned','revision']))
                                                <a href="{{ route('editor.contents.create', $task->id) }}"
                                                   class="corp-btn-primary">
                                                   Kerjakan Tugas
                                                </a>
                                            @else
                                                <a href="{{ route('editor.videos.create', $task->id) }}"
                                                   class="corp-btn-success">
                                                    Upload Video
                                                </a>
                                            @endif

                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 corp-empty">
                                            <i class="mdi mdi-clipboard-text-off-outline d-block mb-2" style="font-size: 32px; opacity: 0.35;"></i>
                                            Tidak ada tugas prioritas
                                        </td>
                                    </tr>
                                @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

{{-- ================= CHART JS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const ctx1 = document.getElementById('hourChart').getContext('2d');

    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: {!! json_encode($peakHoursChart['labels']) !!},
            datasets: [{
                data: {!! json_encode($peakHoursChart['data']) !!},
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.08)',
                tension: 0.4,
                fill: true,
                pointRadius: 3,
                pointBackgroundColor: '#3B82F6'
            }]
        },
        options: {
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#15192B',
                    padding: 10,
                    cornerRadius: 8
                }
            },
            responsive: true,
            maintainAspectRatio: false,
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

    const ctx2 = document.getElementById('postTypeChart').getContext('2d');

    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($postTypeChart['labels']) !!},
            datasets: [{
                data: {!! json_encode($postTypeChart['data']) !!},
                backgroundColor: ['#3B82F6', '#F59E0B', '#10B981', '#EF4444'],
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
                legend: {
                    position: 'bottom',
                    labels: { color: '#6B7280', font: { size: 11 }, boxWidth: 10, padding: 12 }
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