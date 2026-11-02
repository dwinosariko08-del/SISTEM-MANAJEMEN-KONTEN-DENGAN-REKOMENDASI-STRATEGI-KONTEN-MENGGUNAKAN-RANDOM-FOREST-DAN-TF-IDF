@extends('layouts.leader.app')

@section('title', 'Review Konten')

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

    /* SCRIPT HIGHLIGHT */
    .block-script {
        background: #ffffff;
        border: 2px solid var(--fa-bg-light);
        border-radius: 12px;
        padding: 1.5rem;
        height: 100%;
    }

    .script-text {
        font-size: 18px; 
        font-weight: 600;
        color: #334155;
        line-height: 1.6;
    }

    .tag-script {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 900;
        margin-bottom: 12px;
    }

    .tag-hook { background: #ffe4e6; color: #be123c; }
    .tag-body { background: #fef3c7; color: #b45309; }
    .tag-closing { background: #dcfce7; color: #15803d; }

    /* CUSTOM DECISION BUTTONS (RADIO CARDS) */
    .decision-group {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .decision-item { flex: 1; position: relative; }

    .decision-item input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .decision-label {
        display: block;
        padding: 12px;
        text-align: center;
        border: 2px solid var(--fa-border);
        border-radius: 10px;
        cursor: pointer;
        font-weight: 700;
        transition: all 0.3s;
        color: #64748b;
    }

    .decision-item input:checked + .label-approve {
        border-color: var(--fa-success);
        background-color: #f0fdf4;
        color: var(--fa-success);
    }

    .decision-item input:checked + .label-revision {
        border-color: var(--fa-danger);
        background-color: #fef2f2;
        color: var(--fa-danger);
    }

    /* THUMBNAIL PREVIEW */
    .thumbnail-box {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--fa-border);
        background: #000;
        cursor: pointer;
        transition: transform 0.3s;
    }
    
    .thumbnail-box:hover { transform: scale(1.02); }
    .thumbnail-img { width: 100%; height: auto; display: block; }
    
    .zoom-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.3);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: 0.3s;
    }
    .thumbnail-box:hover .zoom-overlay { opacity: 1; }

</style>



            <div class="row">
                <div class="col-lg-8">

                    <div class="card card-pro">
                        <div class="card-header d-flex align-items-center">
                            <i class="bx bx-info-circle text-primary fs-4 me-2"></i>
                            <h5>Informasi Konten</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <span class="label-custom">Posting Date</span>
                                    <p class="value-custom text-dark">{{ \Carbon\Carbon::parse($content->posting_date)->format('d F Y') }}</p>
                                </div>
                                <div class="col-md-4 border-start">
                                    <span class="label-custom">Pillar</span>
                                    <p class="value-custom">{{ $content->pillar }}</p>
                                </div>
                                <div class="col-md-4 border-start">
                                    <span class="label-custom">Topic</span>
                                    <p class="value-custom text-primary">{{ $content->topic }}</p>
                                </div>
                                <div class="col-12 mt-4">
                                    <div class="p-3 bg-light rounded-3 border-start border-primary border-4">
                                        <span class="label-custom text-primary">Notes untuk Editor</span>
                                        <p class="mb-0 fw-medium text-dark italic">"{{ $content->notes_for_creator ?? '-' }}"</p>
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
                                <span class="badge bg-info px-3 py-2">
                                    {{ strtoupper($content->editorContent->post_type ?? '-') }}
                                </span>
                            @endif
                        </div>

                        <div class="card-body">
                            @if($content->editorContent)
                                @php 
                                    $editor = $content->editorContent; 
                                    $script = $editor->script_brief ?? '';
                                    preg_match('/HOOK:(.*?)BODY:/is', $script, $hookMatch);
                                    preg_match('/BODY:(.*?)CLOSING:/is', $script, $bodyMatch);
                                    preg_match('/CLOSING:(.*)/is', $script, $closingMatch);
                                    $hook = trim($hookMatch[1] ?? '');
                                    $body = trim($bodyMatch[1] ?? '');
                                    $closing = trim($closingMatch[1] ?? '');
                                @endphp

                                <div class="row g-3 mb-4">
                                    <div class="col-md-8">
                                        <span class="label-custom">Judul Konten</span>
                                        <h4 class="fw-extrabold text-dark mb-0">{{ $editor->content_title ?? '-' }}</h4>
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
                                    <div class="col-12">
                                        <div class="block-script border-top border-danger border-4 shadow-sm">
                                            <span class="tag-script tag-hook"># HOOK</span>
                                            <div class="script-text">{!! nl2br(e($hook ?: '-')) !!}</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="block-script border-top border-warning border-4 shadow-sm">
                                            <span class="tag-script tag-body"># BODY</span>
                                            <div class="script-text">{!! nl2br(e($body ?: '-')) !!}</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="block-script border-top border-success border-4 shadow-sm">
                                            <span class="tag-script tag-closing"># CLOSING</span>
                                            <div class="script-text">{!! nl2br(e($closing ?: '-')) !!}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-12">
                                        <span class="label-custom">Reference Link</span>
                                        <div class="p-3 bg-light rounded-3 border">
                                            <a href="{{ $editor->reference ?? '#' }}" target="_blank" class="text-primary fw-bold">
                                                <i class="bx bx-link-external me-1"></i> {{ $editor->reference ?? '-' }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <span class="label-custom">Social Media Caption</span>
                                        <div class="p-3 bg-light border rounded-3 text-dark" style="white-space: pre-wrap; font-size: 14px;">{{ $editor->caption ?? '-' }}</div>
                                    </div>
                                    <div class="col-12">
                                        <span class="label-custom text-primary">Hashtags</span>
                                        <div class="p-3 bg-white border-dashed border-2 rounded-3">
                                            <code class="text-primary fw-bold" style="font-size: 14px;">{{ $editor->hashtag ?? '-' }}</code>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <span class="label-custom">Preview Thumbnail</span>
                                    @if($editor->preview_thumbnail)
                                        <div class="thumbnail-box shadow-sm" style="max-width: 450px;" data-bs-toggle="modal" data-bs-target="#imageFullModal">
                                            <img src="{{ asset('storage/' . $editor->preview_thumbnail) }}" class="thumbnail-img">
                                            <div class="zoom-overlay">
                                                <i class="bx bx-zoom-in text-white fs-1"></i>
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-muted italic">Thumbnail belum diupload</p>
                                    @endif
                                </div>

                            @else
                                <p class="text-muted text-center py-5">Editor belum mengisi konten</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-pro sticky-top shadow-lg border-0" style="top:1rem; border-top: 5px solid var(--fa-accent) !important;">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bx bx-check-shield me-2 text-primary"></i>Final Review</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('leader.contents.review', $content->id) }}">
                                @csrf
                                
                                <label class="label-custom text-dark mb-2">Pilih Keputusan:</label>
                                <div class="decision-group">
                                    <div class="decision-item">
                                        <input type="radio" name="approved" value="1" id="approve" required>
                                        <label for="approve" class="decision-label label-approve">
                                            <i class="bx bx-check-circle d-block fs-3"></i> APPROVE
                                        </label>
                                    </div>
                                    <div class="decision-item">
                                        <input type="radio" name="approved" value="0" id="revisi">
                                        <label for="revisi" class="decision-label label-revision">
                                            <i class="bx bx-revision d-block fs-3"></i> REVISI
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="label-custom text-dark">Catatan Reviewer:</label>
                                    <textarea name="revision_notes" class="form-control @error('revision_notes') is-invalid @enderror" rows="6" placeholder="Berikan instruksi jelas jika ada perubahan...">{{ old('revision_notes') }}</textarea>
                                    @error('revision_notes')
                                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100 fw-bold py-3 shadow">
                                    SUBMIT REVIEW SEKARANG
                                </button>

                                <a href="{{ route('leader.contents.index') }}" class="btn btn-link w-100 mt-2 text-muted text-decoration-none small">
                                    <i class="bx bx-arrow-back"></i> Kembali ke Dashboard
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


<div class="modal fade" id="imageFullModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 text-center">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
                @if($content->editorContent && $content->editorContent->preview_thumbnail)
                    <img src="{{ asset('storage/' . $content->editorContent->preview_thumbnail) }}" class="img-fluid rounded shadow-lg">
                @endif
            </div>
        </div>
    </div>
</div>

@endsection