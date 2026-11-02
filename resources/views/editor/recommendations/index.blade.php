@extends('layouts.editor.app')

@section('title', 'Rekomendasi Konten')

@section('content')

<style>
    .card {
        border-radius: 12px;
    }
</style>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h3 class="fw-bold text-dark mb-1">Rekomendasi Strategi Konten Selanjutnya</h3>
                    <p class="text-muted mb-0">Analisis performa konten dan rekomendasi ide konten berikutnya</p>
                </div>
            </div>

</div>

@if(!$recommendation)

<div class="alert alert-warning">

    Belum ada data analytics yang dapat dianalisis.

</div>

@else

<div class="mb-3">

    <a href="{{ route('editor.analytics.export') }}"
       class="btn btn-primary">

        Export Dataset ML

    </a>

</div>

{{-- ===================================================== --}}
{{-- NEXT CONTENT RECOMMENDATION --}}
{{-- ===================================================== --}}

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-dark">
            Next Content Recommendation
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <small class="text-muted fw-semibold">Platform</small>
                <h6 class="fw-bold text-dark mt-1">{{ $recommendation['platform'] }}</h6>
            </div>
            <div class="col-md-4 mb-3">
                <small class="text-muted fw-semibold">Jam Posting</small>
                <h6 class="fw-bold text-dark mt-1">{{ $recommendation['hour'] }}</h6>
            </div>
            <div class="col-md-4 mb-3">
                <small class="text-muted fw-semibold">Pillar</small>
                <h6 class="fw-bold text-dark mt-1">{{ $recommendation['pillar'] }}</h6>
            </div>

            <div class="col-md-4 mb-3">
                <small class="text-muted fw-semibold">Topic</small>
                <h6 class="fw-bold text-dark mt-1">{{ $recommendation['topic'] }}</h6>
            </div>
            <div class="col-md-4 mb-3">
                <small class="text-muted fw-semibold">Target Judul (Title)</small>
                <h6 class="fw-bold text-dark mt-1">{{ $recommendation['title'] }}</h6>
            </div>
            <div class="col-md-4 mb-3">
                <small class="text-muted fw-semibold">Hashtag Ideal</small>
                <h6 class="fw-bold text-dark mt-1">{{ $recommendation['hashtag'] ?? '-' }}</h6>
            </div>

            <div class="col-md-12 mb-3">
                <small class="text-muted fw-semibold">Referensi Naskah (Script)</small>
                <div class="p-3 bg-light rounded mt-1" style="max-height: 250px; overflow-y: auto; font-size: 14px; border: 1px solid #e2e8f0;">
                    {!! nl2br(e($recommendation['script'] ?: 'Tidak ada referensi naskah khusus.')) !!}
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <small class="text-muted fw-semibold">Prediksi Potensi</small>
                <div class="mt-1">
                    <h3 class="fw-bold text-dark mb-2">{{ $recommendation['potential'] }}%</h3>
                    @if($recommendation['potential'] >= 80)
                        <span class="badge bg-success px-3 py-2">HIGH POTENTIAL</span>
                    @elseif($recommendation['potential'] >= 60)
                        <span class="badge bg-warning text-dark px-3 py-2">MEDIUM POTENTIAL</span>
                    @else
                        <span class="badge bg-danger px-3 py-2">LOW POTENTIAL</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===================================================== --}}
{{-- AI REASONING --}}
{{-- ===================================================== --}}

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-dark">
            Analisis Sistem
        </h5>
    </div>

    <div class="card-body">

        <p class="mb-0">

            Sistem menganalisis seluruh performa konten yang telah dipublikasikan.

            Berdasarkan pola engagement tertinggi,
            konten dengan pillar

            <strong>{{ $recommendation['pillar'] }}</strong>

            pada platform

            <strong>{{ $recommendation['platform'] }}</strong>

            menunjukkan performa terbaik ketika diposting pada

            <strong>{{ $recommendation['hour'] }}</strong>.

            Oleh karena itu sistem merekomendasikan topik:

            <strong>{{ $recommendation['topic'] }}</strong>

            sebagai ide konten berikutnya.

        </p>

    </div>

</div>

{{-- ===================================================== --}}
{{-- INSIGHT --}}
{{-- ===================================================== --}}

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-dark">
            Insight Analytics
        </h5>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3">

                <small class="text-muted">
                    Platform Terbaik
                </small>

                <h5>
                    {{ $insight['platform'] }}
                </h5>

            </div>

            <div class="col-md-3">

                <small class="text-muted">
                    Pillar Terbaik
                </small>

                <h5>
                    {{ $insight['pillar'] }}
                </h5>

            </div>

            <div class="col-md-3">

                <small class="text-muted">
                    Jam Terbaik
                </small>

                <h5>
                    {{ $insight['hour'] }}
                </h5>

            </div>

            <div class="col-md-3">

                <small class="text-muted">
                    Avg ER
                </small>

                <h5 class="text-success">
                    {{ $insight['avg_er'] }}%
                </h5>

            </div>

        </div>

    </div>

</div>

{{-- ===================================================== --}}
{{-- TOP CONTENT --}}
{{-- ===================================================== --}}

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="fw-bold text-dark mb-0">
            Top Performing Content
        </h5>
    </div>

    <div class="table-responsive">

        <table class="table table-hover mb-0">

            <thead>

                <tr>

                    <th>#</th>
                    <th>Platform</th>
                    <th>Pillar</th>
                    <th>Topic</th>
                    <th class="text-center">ER (%)</th>

                </tr>

            </thead>

            <tbody>

            @forelse($top as $index => $t)

                <tr>

                    <td>
                        {{ $index + 1 }}
                    </td>

                    <td>

                        <span class="badge bg-soft-info">

                            {{ strtoupper($t['platform']) }}

                        </span>

                    </td>

                    <td>

                        {{ $t['pillar'] }}

                    </td>

                    <td>

                        {{ $t['topic'] }}

                    </td>

                    <td class="text-center">

                        @if($t['er'] >= 5)

                            <span class="badge bg-success">

                        @elseif($t['er'] >= 3)

                            <span class="badge bg-warning text-dark">

                        @else

                            <span class="badge bg-danger">

                        @endif

                            {{ number_format($t['er'],2) }}%

                        </span>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5"
                        class="text-center text-muted py-3">

                        Tidak ada data

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endif



@endsection