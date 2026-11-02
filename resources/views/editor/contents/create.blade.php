@extends('layouts.editor.app')

@section('title', 'Kerjakan Konten')

@section('content')



<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1 fw-bold text-dark">Kerjakan Konten</h4>
        <p class="text-muted small mb-0">Lihat instruksi detail dari Leader dan lengkapi hasil pekerjaan Anda di form bawah ini.</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        
        {{-- ASSIGNMENT DARI LEADER --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent py-3">
                <h5 class="card-title mb-0 fw-bold text-dark">Detail Assignment dari Leader</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-secondary small">Content Pillar</label>
                        <input class="form-control bg-light" value="{{ $content->pillar }}" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-secondary small">Topik Utama</label>
                        <input class="form-control bg-light" value="{{ $content->topic }}" readonly>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold text-secondary small">Asset Project</label>
                        @if ($content->asset && $content->asset->gdrive_link)
                            <a href="{{ $content->asset->gdrive_link }}" target="_blank" class="form-control text-primary text-decoration-none bg-light d-flex justify-content-between align-items-center">
                                <span>{{ $content->asset->nama_client }} - {{ $content->asset->jenis_project }}</span>
                                <i class="mdi mdi-open-in-new"></i>
                            </a>
                        @else
                            <input class="form-control bg-light text-danger" value="Asset belum memiliki link drive" readonly>
                        @endif
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold text-secondary small">Notes / Instruksi Leader</label>
                        <textarea class="form-control bg-light" rows="3" readonly>{{ $content->notes_for_creator }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- CATATAN REVISI DARI LEADER (tampil hanya saat revisi) --}}
        @if(in_array($content->status, ['revision', 'video_revision']) && ($content->revision_notes || $content->video_revision_notes))
        <div class="card border-0 shadow-sm mb-4 border-start border-danger border-4">
            <div class="card-header bg-danger bg-opacity-10 py-3">
                <h5 class="card-title mb-0 fw-bold text-danger">
                    <i class="mdi mdi-alert-circle-outline me-1"></i> Catatan Revisi dari Leader
                </h5>
            </div>
            <div class="card-body p-4">
                @if($content->revision_notes)
                <div class="mb-3">
                    <label class="form-label fw-semibold text-danger small">Revisi Script / Konten:</label>
                    <div class="p-3 bg-danger bg-opacity-10 rounded border-start border-danger border-4">
                        <p class="mb-0 text-dark fw-bold">{{ $content->revision_notes }}</p>
                    </div>
                </div>
                @endif
                @if($content->video_revision_notes)
                <div>
                    <label class="form-label fw-semibold text-danger small">Revisi Video:</label>
                    <div class="p-3 bg-danger bg-opacity-10 rounded border-start border-danger border-4">
                        <p class="mb-0 text-dark fw-bold">{{ $content->video_revision_notes }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- FORM KERJA EDITOR --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent py-3">
                <h5 class="card-title mb-0 fw-bold text-dark">Formulir Hasil Kerja Editor</h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('editor.contents.store', $content->id) }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-secondary small">Post Type</label>
                            <select name="post_type" class="form-select form-control" required>
                                <option value="" disabled {{ old('post_type', $editorContent->post_type ?? '') == '' ? 'selected' : '' }}>Pilih Tipe...</option>
                                <option value="reels" {{ old('post_type', $editorContent->post_type ?? '') == 'reels' ? 'selected' : '' }}>Reels</option>
                                <option value="carousel" {{ old('post_type', $editorContent->post_type ?? '') == 'carousel' ? 'selected' : '' }}>Carousel</option>
                                <option value="feed" {{ old('post_type', $editorContent->post_type ?? '') == 'feed' ? 'selected' : '' }}>Feed</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-secondary small">Talent</label>
                            <input name="talent" class="form-control" placeholder="Nama talent/aktor (opsional)" value="{{ old('talent', $editorContent->talent ?? '') }}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold text-secondary small">Content Title</label>
                            <input type="text" name="content_title" class="form-control" placeholder="Masukkan judul konten yang menarik..." value="{{ old('content_title', $editorContent->content_title ?? '') }}" required>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold text-secondary small">Hook (Pancingan Perhatian)</label>
                            <textarea name="hook" class="form-control" rows="2" placeholder="Tulis script hook di sini..." required>{{ old('hook', $hook ?? '') }}</textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold text-secondary small">Body (Isi Utama)</label>
                            <textarea name="body" class="form-control" rows="4" placeholder="Tulis script isi konten di sini..." required>{{ old('body', $body ?? '') }}</textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold text-secondary small">Closing / Call to Action (CTA)</label>
                            <textarea name="closing" class="form-control" rows="2" placeholder="Tulis script penutup di sini..." required>{{ old('closing', $closing ?? '') }}</textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold text-secondary small">Caption</label>
                            <textarea name="caption" class="form-control" rows="3" placeholder="Tulis caption sosial media..." required>{{ old('caption', $editorContent->caption ?? '') }}</textarea>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-secondary small">Hashtag</label>
                            <input name="hashtag" class="form-control" placeholder="#contoh #hashtag" value="{{ old('hashtag', $editorContent->hashtag ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-secondary small">Reference Link</label>
                            <input type="text" name="reference" class="form-control" placeholder="Link referensi konten (opsional)" value="{{ old('reference', $editorContent->reference ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-secondary small">Nama Editor</label>
                            <input name="editor_name" class="form-control bg-light" value="{{ auth()->user()->name }}" readonly required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-secondary small">Preview Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                            <small class="text-muted d-block mt-1">Upload gambar thumbnail jika ada.</small>
                        </div>
                    </div>

                    <div class="text-right mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-light px-4 shadow-sm mr-2">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">Kirim Hasil Konten</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>



@endsection