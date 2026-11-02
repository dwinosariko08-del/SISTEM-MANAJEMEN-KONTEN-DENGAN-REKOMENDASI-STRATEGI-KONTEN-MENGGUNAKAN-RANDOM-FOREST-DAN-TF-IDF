@extends('layouts.editor.app')

@section('title', 'Analytics Konten')

@section('content')



<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1 fw-bold text-dark">Content Analytics</h4>
        <p class="text-muted small mb-0">Statistik performa konten setelah dipublish.</p>
    </div>
</div>

{{-- INFO CONTENT --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent py-3">
                <h5 class="card-title mb-0 fw-bold text-dark">Informasi Konten</h5>
            </div>
            <div class="card-body p-4">
                <div class="row text-center text-md-start">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <span class="d-block text-secondary small fw-semibold">Pillar</span>
                        <span class="text-dark fw-bold">{{ $content->pillar }}</span>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <span class="d-block text-secondary small fw-semibold">Topic</span>
                        <span class="text-dark fw-bold">{{ $content->topic }}</span>
                    </div>
                    <div class="col-md-4">
                        <span class="d-block text-secondary small fw-semibold">Posting Date</span>
                        <span class="text-dark fw-bold">{{ \Carbon\Carbon::parse($content->posting_date)->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- METRIC CARDS --}}
<div class="row mb-4">
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card shadow-sm border-0 text-center h-100">
            <div class="card-body p-4">
                <h6 class="text-muted fw-semibold small mb-2">Views</h6>
                <h3 class="fw-bold mb-0 text-dark">{{ number_format($analytics->views) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card shadow-sm border-0 text-center h-100">
            <div class="card-body p-4">
                <h6 class="text-muted fw-semibold small mb-2">Likes</h6>
                <h3 class="fw-bold mb-0 text-dark">{{ number_format($analytics->likes) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card shadow-sm border-0 text-center h-100">
            <div class="card-body p-4">
                <h6 class="text-muted fw-semibold small mb-2">Comments</h6>
                <h3 class="fw-bold mb-0 text-dark">{{ number_format($analytics->comments) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 text-center h-100">
            <div class="card-body p-4">
                <h6 class="text-muted fw-semibold small mb-2">Shares</h6>
                <h3 class="fw-bold mb-0 text-dark">{{ number_format($analytics->shares) }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- ENGAGEMENT RATE + SCORE --}}
<div class="row mb-4">
    <div class="col-md-6 mb-3 mb-md-0">
        <div class="card shadow-sm border-0 text-center h-100">
            <div class="card-body p-4 d-flex flex-column justify-content-center">
                <h6 class="text-muted fw-semibold small mb-2">Engagement Rate</h6>
                <h1 class="display-5 fw-bold text-primary mb-0">{{ number_format($analytics->engagement_rate, 2) }}%</h1>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0 text-center h-100">
            <div class="card-body p-4 d-flex flex-column justify-content-center">
                <h6 class="text-muted fw-semibold small mb-2">Engagement Score</h6>
                <h1 class="display-5 fw-bold text-success mb-0">{{ number_format($analytics->engagement_score) }}</h1>
            </div>
        </div>
    </div>
</div>

{{-- CHART --}}
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-transparent py-3">
                <h5 class="card-title mb-0 fw-bold text-dark">Engagement Breakdown</h5>
            </div>
            <div class="card-body p-4">
                <div style="position: relative; height: 350px; width: 100%;">
                    <canvas id="engagementChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('engagementChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Views', 'Likes', 'Comments', 'Shares', 'ER (%)'],
        datasets: [{
            label: 'Jumlah / Nilai',
            data: [
                {{ $analytics->views }},
                {{ $analytics->likes }},
                {{ $analytics->comments }},
                {{ $analytics->shares }},
                {{ $analytics->engagement_rate }}
            ],
            backgroundColor: ['#ff9f43', '#0d6efd', '#0dcaf0', '#198754', '#ea5455'],
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

@endsection