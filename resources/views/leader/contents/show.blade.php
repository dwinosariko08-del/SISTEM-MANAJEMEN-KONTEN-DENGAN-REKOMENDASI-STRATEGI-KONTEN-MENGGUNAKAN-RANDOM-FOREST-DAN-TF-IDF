@extends('layouts.leader.app')

@section('title', 'Detail Assignment Konten')

@section('content')

<style>
    :root {
        --fa-border: #e2e8f0;
    }

    .card-pro {
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.03);
        margin-bottom: 1.5rem;
        background: #fff;
    }

    .card-pro .card-header {
        background-color: #fff;
        border-bottom: 1px solid #f1f5f9;
        padding: 1.25rem 1.5rem;
    }

    .card-pro .card-header h5 {
        font-weight: 600;
        color: #334155;
        font-size: 15px;
        margin: 0;
    }

    .label-custom {
        font-size: 11px;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
        display: block;
    }

    .value-custom { font-weight: 500; color: #475569; margin-bottom: 0; font-size: 14px; }

    /* HIGHLIGHT SCRIPT BOX - TEKS BESAR */
    .block-script {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 10px;
        padding: 1.25rem;
        height: 100%;
    }

    .script-text {
        font-size: 15px;
        font-weight: 500;
        color: #475569;
        line-height: 1.6;
    }

    .tag-script {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 12px;
        letter-spacing: 0.03em;
    }

    .tag-hook { background: #fef2f2; color: #ef4444; border: 1px solid #fee2e2; }
    .tag-body { background: #fffbeb; color: #f59e0b; border: 1px solid #fef3c7; }
    .tag-closing { background: #f0fdf4; color: #22c55e; border: 1px solid #dcfce7; }

    .copy-box {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 10px;
        padding: 15px;
        font-size: 14px;
        color: #475569;
    }

    /* MEDIA SECTION */
    .media-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        overflow: hidden;
        max-width: 320px;
        box-shadow: 0 4px 15px -3px rgba(0,0,0,0.03);
    }

    .media-display {
        background: #1e293b;
        aspect-ratio: 9 / 16;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .img-preview { width: 100%; height: 100%; object-fit: cover; cursor: zoom-in; opacity: 0.95; }
    
    .media-display video {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .media-footer {
        padding: 12px 15px;
        background: #fff;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-download-pro {
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .btn-download-pro:hover {
        background: #f1f5f9;
        color: #475569;
    }
</style>

<div class="py-3">
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h4 class="fw-bold text-dark mb-0">Review Detail Assignment</h4>
                </div>
                <div class="col-md-6 text-md-end">
                    @php
                        $statusColor = match($content->status) {
                            'assigned' => 'secondary', 'on_progress' => 'warning', 'revision' => 'danger',
                            'done' => 'success', 'video_uploaded' => 'info', 'video_revision' => 'danger',
                            'published' => 'primary', default => 'dark'
                        };
                    @endphp
                    <span class="badge bg-soft-{{ $statusColor }} text-{{ $statusColor }} shadow-none border border-{{ $statusColor }} px-3 py-2" style="font-weight: 600;">
                        {{ strtoupper($content->status) }}
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    
                    <div class="card card-pro">
                        <div class="card-header d-flex align-items-center">
                            <i class="bx bx-list-check text-primary fs-4 me-2"></i>
                            <h5>Informasi Assignment</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <span class="label-custom">Posting Date</span>
                                    <p class="value-custom">{{ \Carbon\Carbon::parse($content->posting_date)->format('d F Y') }}</p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <span class="label-custom">Asset / Client</span>
                                    <p class="value-custom text-primary text-uppercase">{{ $content->asset->nama_client ?? '-' }}</p>
                                </div>
                                <div class="col-md-6 border-top pt-3">
                                    <span class="label-custom">Pillar</span>
                                    <p class="value-custom">{{ $content->pillar }}</p>
                                </div>
                                <div class="col-md-6 border-top pt-3 text-md-end">
                                    <span class="label-custom">Topic</span>
                                    <p class="value-custom">{{ $content->topic }}</p>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="p-3 rounded-3" style="background-color: #f8fafc; border: 1px solid #f1f5f9;">
                                        <span class="label-custom" style="color: #64748b;">Notes dari Leader</span>
                                        <p class="mb-0 fw-medium text-secondary" style="font-style: italic;">"{{ $content->notes_for_creator ?? '-' }}"</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-pro">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-edit-alt text-primary fs-4 me-2"></i>
                                <h5>Hasil Pekerjaan Editor</h5>
                            </div>
                            @if($content->editorContent)
                                <span class="badge bg-soft-info text-info border border-info px-2 py-1" style="font-size: 10px;">
                                    {{ strtoupper($content->editorContent->post_type ?? '-') }}
                                </span>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($content->editorContent)
                                @php 
                                    $editor = $content->editorContent;
                                    $script = $editor->script_brief ?? '';
                                    preg_match('/HOOK:(.*?)BODY:/s', $script, $hookMatch);
                                    preg_match('/BODY:(.*?)CLOSING:/s', $script, $bodyMatch);
                                    preg_match('/CLOSING:(.*)/s', $script, $closingMatch);
                                @endphp

                                <div class="row g-3 mb-4">
                                    <div class="col-md-8">
                                        <span class="label-custom">Judul Konten</span>
                                        <h4 class="fw-extrabold text-dark">{{ $editor->content_title ?? '-' }}</h4>
                                    </div>
                                    <div class="col-md-2 border-start">
                                        <span class="label-custom">Editor</span>
                                        <p class="small fw-bold text-dark">{{ $editor->editor_name ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-2 border-start">
                                        <span class="label-custom">Talent</span>
                                        <p class="small fw-bold text-dark">{{ $editor->talent ?? '-' }}</p>
                                    </div>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-4">
                                        <div class="block-script">
                                            <span class="tag-script tag-hook">HOOK</span>
                                            <div class="script-text">{{ trim($hookMatch[1] ?? '-') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="block-script">
                                            <span class="tag-script tag-body">BODY</span>
                                            <div class="script-text">{{ trim($bodyMatch[1] ?? '-') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="block-script">
                                            <span class="tag-script tag-closing">CLOSING</span>
                                            <div class="script-text">{{ trim($closingMatch[1] ?? '-') }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-12">
                                        <span class="label-custom">Caption</span>
                                        <div class="copy-box"><div style="white-space: pre-wrap;">{{ $editor->caption ?? '-' }}</div></div>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="label-custom">Hashtags</span>
                                        <div class="copy-box bg-white" style="border: 1px dashed #cbd5e1;">
                                            <span style="color: #475569; font-weight: 500;">{{ $editor->hashtag ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-light rounded-2 border">
                                    <span class="label-custom">Reference Link</span>
                                    @if($editor->reference && $editor->reference != '-')
                                        <a href="{{ $editor->reference }}" target="_blank" class="text-primary fw-bold small">
                                            <i class="bx bx-link-external me-1"></i> {{ $editor->reference }}
                                        </a>
                                    @else
                                        <span class="text-muted small italic">Tidak ada link referensi</span>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-5 text-muted small italic">Menunggu data dari editor...</div>
                            @endif
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <span class="label-custom ms-1">Thumbnail Preview</span>
                            <div class="media-card">
                                <div class="media-display">
                                    @if($content->editorContent && $content->editorContent->preview_thumbnail)
                                        <img src="{{ asset('storage/' . $content->editorContent->preview_thumbnail) }}" 
                                             class="img-preview" data-bs-toggle="modal" data-bs-target="#imgModal">
                                    @else
                                        <span class="text-white opacity-25 small italic">No Thumbnail</span>
                                    @endif
                                </div>
                                <div class="media-footer">
                                    <span class="small fw-bold text-muted">PREVIEW IMG</span>
                                    @if($content->editorContent && $content->editorContent->preview_thumbnail)
                                        <a href="{{ asset('storage/' . $content->editorContent->preview_thumbnail) }}" download class="btn-download-pro">
                                            <i class="bx bx-download"></i> Download
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <span class="label-custom ms-1">Video Output</span>
                            <div class="media-card">
                                <div class="media-display">
                                    @if($content->producedVideo)
                                        <video controls class="w-100 h-100">
                                            <source src="{{ asset('storage/' . $content->producedVideo->video_path) }}" type="video/mp4">
                                        </video>
                                    @else
                                        <span class="text-white opacity-25 small italic">No Video</span>
                                    @endif
                                </div>
                                <div class="media-footer">
                                    <span class="small fw-bold text-muted">VIDEO MP4</span>
                                    @if($content->producedVideo)
                                        <a href="{{ asset('storage/' . $content->producedVideo->video_path) }}" download class="btn-download-pro">
                                            <i class="bx bx-download"></i> Download
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 1rem;">
                        @if($content->status === 'video_uploaded')
                            <div class="card card-pro border-top border-4 border-primary shadow">
                                <div class="card-header"><h5>Quality Control</h5></div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('leader.contents.review-video', $content->id) }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="label-custom">Keputusan Review</label>
                                            <select name="approved" class="form-select border-primary" required>
                                                <option value="">-- Pilih --</option>
                                                <option value="1">✓ Approve Video</option>
                                                <option value="0">⚠ Minta Revisi</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="label-custom">Catatan Revisi</label>
                                            <textarea name="video_revision_notes" class="form-control" rows="5" placeholder="Tulis catatan jika ada revisi..."></textarea>
                                        </div>
                                        <button class="btn btn-primary w-100 fw-bold py-2">SIMPAN STATUS</button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <div class="card card-pro shadow-sm">
                            <div class="card-body p-2">
                                <a href="{{ route('leader.contents.index') }}" class="btn btn-white w-100 border text-muted">
                                    <i class="bx bx-arrow-back me-1"></i> Kembali ke Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>

<div class="modal fade" id="imgModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 text-center">
                @if($content->editorContent && $content->editorContent->preview_thumbnail)
                    <img src="{{ asset('storage/' . $content->editorContent->preview_thumbnail) }}" class="img-fluid rounded shadow-lg">
                @endif
            </div>
        </div>
    </div>
</div>

@endsection