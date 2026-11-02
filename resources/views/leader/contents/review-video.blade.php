@extends('layouts.leader.app')

@section('title', 'Review Video')

@section('content')

<style>
    :root {
        --fa-navy: #1a233a;
        --fa-accent: #556ee6;
        --fa-border: #e2e8f0;
        --fa-bg-light: #f4f7fa;
        --fa-success: #34c38f;
        --fa-danger: #f46a6a;
    }

    .main-content { background-color: #f8f9fa; min-height: 100vh; }
    
    .card-pro {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.07);
        margin-bottom: 1.5rem;
        background: #fff;
    }

    .card-pro .card-header {
        background-color: #fff;
        border-bottom: 2px solid var(--fa-bg-light);
        padding: 1.25rem;
    }

    .card-pro .card-header h5 {
        font-weight: 800;
        color: var(--fa-navy);
        font-size: 16px;
        margin: 0;
        text-transform: uppercase;
    }

    .label-custom {
        font-size: 11px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 5px;
        display: block;
    }

    .value-custom { font-weight: 700; color: #1e293b; margin-bottom: 0; font-size: 15px; }

    /* LIVE PREVIEW VIDEO CARD */
    .video-showcase {
        position: relative;
        width: 100%;
        max-width: 350px; /* Ukuran lebar yang pas untuk vertikal video */
        border-radius: 16px;
        overflow: hidden;
        background: #000;
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        cursor: pointer;
        transition: transform 0.3s ease;
        margin: 0 auto; /* Ratakan tengah */
    }

    .video-showcase:hover { transform: translateY(-5px); }

    .video-thumbnail-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 9 / 16; /* Portrait 9:16 untuk video Tiktok/Reels */
        overflow: hidden;
        background: #000;
    }

    /* Ini pengganti gambar thumbnail statis */
    .video-thumbnail-live {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.8;
        transition: 0.4s;
    }

    .video-showcase:hover .video-thumbnail-live { opacity: 0.6; transform: scale(1.05); }

    .play-icon-overlay {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 70px;
        height: 70px;
        background: rgba(85, 110, 230, 0.2);
        backdrop-filter: blur(4px);
        border: 2px solid #fff;
        color: white;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 35px;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .video-showcase:hover .play-icon-overlay {
        background: var(--fa-accent);
        border-color: var(--fa-accent);
        transform: translate(-50%, -50%) scale(1.1);
    }

    .badge-live-preview {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--fa-danger);
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        z-index: 2;
        letter-spacing: 0.5px;
    }

    /* DOWNLOAD BAR BELOW VIDEO */
    .video-action-bar {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 10px;
        padding: 15px 20px;
        background: #ffffff;
        border-top: 1px solid var(--fa-border);
    }

    .file-type-badge {
        background: #f1f5f9;
        color: #475569;
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 12px;
        margin-right: 15px;
    }

    /* MODAL VIDEO COMPACT */
    .modal-video-container { max-width: 450px; margin: auto; }

    /* DECISION BUTTONS */
    .decision-group { display: flex; gap: 10px; margin-bottom: 20px; }
    .decision-item { flex: 1; position: relative; }
    .decision-item input { position: absolute; opacity: 0; }
    .decision-label {
        display: block; padding: 12px; text-align: center;
        border: 2px solid var(--fa-border); border-radius: 10px;
        cursor: pointer; font-weight: 700; transition: all 0.3s; color: #64748b;
    }
    .decision-item input:checked + .label-approve { border-color: var(--fa-success); background-color: #f0fdf4; color: var(--fa-success); }
    .decision-item input:checked + .label-revision { border-color: var(--fa-danger); background-color: #fef2f2; color: var(--fa-danger); }
</style>



            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-pro">
                        <div class="card-header d-flex align-items-center">
                            <i class="bx bx-info-circle text-primary fs-4 me-2"></i>
                            <h5>Informasi Konten Produksi</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <span class="label-custom">Topic</span>
                                    <p class="value-custom text-primary text-uppercase">{{ $content->topic }}</p>
                                </div>
                                <div class="col-md-6 border-start">
                                    <span class="label-custom">Pillar</span>
                                    <p class="value-custom">{{ $content->pillar }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-pro overflow-hidden">
                        <div class="card-header d-flex align-items-center">
                            <i class="bx bx-play-circle text-primary fs-4 me-2"></i>
                            <h5>Hasil Produksi Video</h5>
                        </div>
                        <div class="card-body bg-light-soft p-4">
                            <span class="label-custom mb-3">Live Preview (Cuplikan Video)</span>
                            
                            <div class="video-showcase mb-3" onclick="openPlayer()">
                                <div class="video-thumbnail-wrapper">
                                    <span class="badge-live-preview">Live Cuplikan</span>
                                    <video class="video-thumbnail-live" autoplay muted loop playsinline>
                                        <source src="{{ asset('storage/' . $content->producedVideo->video_path) }}" type="video/mp4">
                                    </video>
                                    
                                    <div class="play-icon-overlay">
                                        <i class="bx bx-play"></i>
                                    </div>
                                </div>
                                <div class="video-action-bar" onclick="event.stopPropagation()">
                                    <div class="w-100">
                                        <p class="mb-1 fw-bold text-dark" style="font-size: 14px; line-height: 1.2;">{{ $content->topic }}</p>
                                        <small class="text-muted d-block mb-2">Klik area video untuk review layar penuh</small>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <span class="file-type-badge m-0">MP4</span>
                                        <a href="{{ asset('storage/' . $content->producedVideo->video_path) }}" download class="btn btn-primary btn-sm px-3 rounded-pill fw-bold">
                                            <i class="bx bx-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-pro sticky-top shadow-lg border-0" style="top:1rem; border-top: 5px solid var(--fa-accent) !important;">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bx bx-check-shield me-2 text-primary"></i>Final Review Video</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('leader.contents.review-video', $content->id) }}">
                                @csrf
                                <label class="label-custom text-dark mb-2">Pilih Keputusan:</label>
                                <div class="decision-group">
                                    <div class="decision-item">
                                        <input type="radio" name="approved" value="1" id="approve_v" required>
                                        <label for="approve_v" class="decision-label label-approve">
                                            <i class="bx bx-check-circle d-block fs-3"></i> APPROVE
                                        </label>
                                    </div>
                                    <div class="decision-item">
                                        <input type="radio" name="approved" value="0" id="revisi_v">
                                        <label for="revisi_v" class="decision-label label-revision">
                                            <i class="bx bx-revision d-block fs-3"></i> REVISI
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="label-custom text-dark">Catatan Revisi Video:</label>
                                    <textarea name="video_revision_notes" class="form-control @error('video_revision_notes') is-invalid @enderror" rows="6" placeholder="Berikan instruksi jelas jika ada revisi...">{{ old('video_revision_notes') }}</textarea>
                                    @error('video_revision_notes')
                                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary w-100 fw-bold py-3 shadow">
                                    SIMPAN HASIL REVIEW
                                </button>
                                <a href="{{ route('leader.contents.index') }}" class="btn btn-link w-100 mt-2 text-muted text-decoration-none small">
                                    <i class="bx bx-arrow-back"></i> Kembali ke Dashboard
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


<div class="modal fade" id="vPlayerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-video-container">
        <div class="modal-content bg-dark border-0 rounded-4 overflow-hidden shadow-lg">
            <div class="modal-header border-0 text-white p-3">
                <p class="modal-title small fw-bold"><i class="bx bx-play-circle me-2"></i> Review: {{ $content->topic }}</p>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="closePlayer()"></button>
            </div>
            <div class="modal-body p-0">
                <video id="vPlayer" width="100%" height="auto" controls preload="auto">
                    <source src="{{ asset('storage/' . $content->producedVideo->video_path) }}" type="video/mp4">
                    Browser tidak mendukung player.
                </video>
            </div>
        </div>
    </div>
</div>

<script>
    function openPlayer() {
        var modal = new bootstrap.Modal(document.getElementById('vPlayerModal'));
        modal.show();
        var video = document.getElementById('vPlayer');
        video.load(); 
        video.play();
    }
    function closePlayer() {
        var video = document.getElementById('vPlayer');
        video.pause();
    }
    document.getElementById('vPlayerModal').addEventListener('hidden.bs.modal', function () {
        closePlayer();
    });
</script>

@endsection