@extends('layouts.editor.app')

@section('title', 'Detail Task Editor')

@section('content')

<style>
    :root {
        --fa-navy: #1a233a;
        --fa-accent: #556ee6;
        --fa-border: #e2e8f0;
        --fa-bg-light: #f4f7fa;
    }

    .main-content { background-color: #f8f9fa; min-height: 100vh; }
    
    .card-pro {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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

    /* HIGHLIGHT SCRIPT BOX - TEKS BESAR */
    .block-script {
        background: #ffffff;
        border: 2px solid var(--fa-bg-light);
        border-radius: 12px;
        padding: 1.25rem;
        height: 100%;
    }

    .script-text {
        font-size: 18px; /* Teks Hook/Body/Closing Besar */
        font-weight: 600;
        color: #334155;
        line-height: 1.6;
    }

    .tag-script {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 900;
        margin-bottom: 10px;
    }

    .tag-hook { background: #ffe4e6; color: #be123c; }
    .tag-body { background: #fef3c7; color: #b45309; }
    .tag-closing { background: #dcfce7; color: #15803d; }

    .copy-box {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 15px;
        font-size: 14px;
        color: #334155;
    }

    /* MEDIA SECTION */
    .media-card {
        background: #fff;
        border: 1px solid var(--fa-border);
        border-radius: 12px;
        overflow: hidden;
    }

    .media-display {
        background: #000;
        aspect-ratio: 16 / 9;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .img-preview { width: 100%; height: 100%; object-fit: cover; cursor: zoom-in; }

    .media-footer {
        padding: 10px 15px;
        background: #fff;
        border-top: 1px solid var(--fa-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-download-pro {
        background: var(--fa-navy);
        color: #fff;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
    }
</style>



            {{-- HEADER STATUS --}}
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h4 class="fw-bold text-dark mb-0">Detail Task Editor</h4>
                </div>
                <div class="col-md-6 text-md-end">
                    @php
                        $statusColor = match($content->status ?? '') {
                            'assigned' => 'secondary', 'on_progress' => 'warning', 'revision' => 'danger',
                            'done' => 'success', 'video_uploaded' => 'info', 'video_revision' => 'danger',
                            'published' => 'primary', default => 'dark'
                        };
                    @endphp
                    <span class="badge bg-{{ $statusColor }} shadow-sm px-3 py-2">
                        {{ strtoupper($content->status ?? 'UNKNOWN') }}
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    
                    {{-- INFORMASI ASSIGNMENT --}}
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
                                <div class="col-12 mt-4">
                                    <div class="p-3 bg-light rounded-3 border-start border-primary border-4">
                                        <span class="label-custom text-primary">Notes dari Leader</span>
                                        <p class="mb-0 fw-medium text-dark">"{{ $content->notes_for_creator ?? '-' }}"</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- HASIL PEKERJAAN EDITOR --}}
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
                                        <div class="block-script border-top border-danger border-4">
                                            <span class="tag-script tag-hook">HOOK</span>
                                            <div class="script-text">{{ trim($hookMatch[1] ?? '-') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="block-script border-top border-warning border-4">
                                            <span class="tag-script tag-body">BODY</span>
                                            <div class="script-text">{{ trim($bodyMatch[1] ?? '-') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="block-script border-top border-success border-4">
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
                                        <span class="label-custom text-primary">Hashtags</span>
                                        <div class="copy-box bg-white border-dashed">
                                            <code class="text-primary fw-bold">{{ $editor->hashtag ?? '-' }}</code>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-light rounded-2 border">
                                    <span class="label-custom">Reference Link</span>
                                    @if(isset($editor->reference) && $editor->reference && $editor->reference != '-')
                                        <a href="{{ $editor->reference }}" target="_blank" class="text-primary fw-bold small">
                                            <i class="bx bx-link-external me-1"></i> {{ $editor->reference }}
                                        </a>
                                    @else
                                        <span class="text-muted small italic">Tidak ada link referensi</span>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-5 text-muted small italic">Kamu belum mengupload hasil pekerjaan.</div>
                            @endif
                        </div>
                    </div>

                    {{-- PREVIEW MEDIA SECTION --}}
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
                                    @if($content->producedVideo && $content->producedVideo->video_path)
                                        <video controls class="w-100 h-100">
                                            <source src="{{ asset('storage/' . $content->producedVideo->video_path) }}" type="video/mp4">
                                        </video>
                                    @else
                                        <span class="text-white opacity-25 small italic">No Video</span>
                                    @endif
                                </div>
                                <div class="media-footer">
                                    <span class="small fw-bold text-muted">VIDEO MP4</span>
                                    @if($content->producedVideo && $content->producedVideo->video_path)
                                        <a href="{{ asset('storage/' . $content->producedVideo->video_path) }}" download class="btn-download-pro">
                                            <i class="bx bx-download"></i> Download
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SIDEBAR: STATUS REVIEW LEADER & NAVIGATION --}}
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 1rem;">
                        
                        <div class="card card-pro shadow-sm">
                            <div class="card-header">
                                <h5>Review Leader</h5>
                            </div>
                            <div class="card-body">
                                @if(is_null($content->approved))
                                    <div class="p-3 bg-soft-secondary rounded-2 border border-secondary text-center">
                                        <span class="fw-bold text-secondary">
                                            <i class="bx bx-time-five me-1"></i> Menunggu Review Leader
                                        </span>
                                    </div>
                                @elseif($content->approved)
                                    <div class="p-3 bg-soft-success rounded-2 border border-success text-center">
                                        <span class="fw-bold text-success">
                                            <i class="bx bx-check-circle me-1"></i> Konten Disetujui
                                        </span>
                                    </div>
                                @else
                                    <div class="p-3 bg-soft-danger rounded-2 border border-danger mb-3 text-center">
                                        <span class="fw-bold text-danger">
                                            <i class="bx bx-error-circle me-1"></i> Perlu Revisi
                                        </span>
                                    </div>
                                    <span class="label-custom text-danger">Catatan Revisi:</span>
                                    <div class="p-3 bg-light border-start border-danger border-4 rounded fw-medium text-dark small">
                                        {{ $content->revision_notes }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card card-pro shadow-sm">
                            <div class="card-body p-2">
                                <a href="{{ route('editor.tasks.history') }}" class="btn btn-white w-100 border text-muted fw-bold">
                                    <i class="bx bx-arrow-back me-1"></i> ← Kembali ke Riwayat
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>



{{-- MODAL PREVIEW IMAGE --}}
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