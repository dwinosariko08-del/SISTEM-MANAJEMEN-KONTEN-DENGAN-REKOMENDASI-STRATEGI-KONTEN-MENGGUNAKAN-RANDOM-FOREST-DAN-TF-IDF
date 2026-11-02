@extends('layouts.editor.app')

@section('title', 'Upload Video Produksi')

@section('content')



<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1 fw-bold text-dark">Upload Video Produksi</h4>
        <p class="text-muted small mb-0">Silakan unggah hasil video akhir (final) untuk assignment ini.</p>
    </div>
</div>

{{-- CATATAN REVISI DARI LEADER (tampil hanya saat revisi video) --}}
@if($content->status === 'video_revision' && $content->video_revision_notes)
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm border-start border-danger border-4">
            <div class="card-header bg-danger bg-opacity-10 py-3">
                <h5 class="card-title mb-0 fw-bold text-danger">
                    <i class="mdi mdi-alert-circle-outline me-1"></i> Catatan Revisi Video dari Leader
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="p-3 bg-danger bg-opacity-10 rounded border-start border-danger border-4">
                    <p class="mb-0 text-dark fw-bold">{{ $content->video_revision_notes }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

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

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent py-3">
                <h5 class="card-title mb-0 fw-bold text-dark">Formulir Upload Video</h5>
            </div>
            <div class="card-body p-4">
                <div id="js-alert-container"></div>
                <form method="POST" action="{{ route('editor.videos.store', $content->id) }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small">Pilih File Video</label>
                        <input type="file" name="video" id="video-input" class="form-control @error('video') is-invalid @enderror" accept="video/*" required>
                        <small class="text-muted d-block mt-1">Pastikan video memiliki format yang didukung (MP4, MOV, dll). Maksimal ukuran file: <strong>50MB</strong>.</small>
                        @error('video')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <!-- Video Preview Container -->
                        <div class="mt-3 text-center">
                            <video id="video-preview" controls class="w-100 d-none rounded shadow-sm border" style="max-height: 400px; background: #000;"></video>
                        </div>
                    </div>

                    <div class="text-right mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-light px-4 shadow-sm mr-2">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">Upload Video</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('video-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('video-preview');
        const alertContainer = document.getElementById('js-alert-container');
        
        if (file) {
            // Client-side validation: Maksimal 50MB
            const maxSize = 50 * 1024 * 1024; 
            if (file.size > maxSize) {
                alertContainer.innerHTML = `
                    <div class="alert alert-danger alert-dismissible d-flex align-items-center fade show shadow-sm" role="alert">
                        <i class="bx bxs-error-circle" style="font-size: 1.5em; line-height: 1;"></i>
                        <div class="mx-2 flex-grow-1">
                            <strong>Error!</strong> Ukuran video Anda melebihi batas maksimal 50MB.
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="background: transparent; border: none; font-size: 1.5rem; line-height: 1; padding: 0; opacity: .5; margin-left: auto;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `;
                
                // Reset input
                event.target.value = '';
                preview.src = '';
                preview.classList.add('d-none');
                return;
            } else {
                alertContainer.innerHTML = '';
            }

            const fileURL = URL.createObjectURL(file);
            preview.src = fileURL;
            preview.classList.remove('d-none');
        } else {
            alertContainer.innerHTML = '';
            preview.src = '';
            preview.classList.add('d-none');
        }
    });
</script>



@endsection