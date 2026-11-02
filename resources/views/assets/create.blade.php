@extends('layouts.lapangan.app')

@section('title', 'Upload Asset Baru')

@section('content')


<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1 fw-bold text-dark">Upload Asset Baru</h4>
        <p class="text-muted small mb-0">Isi formulir berikut untuk mengunggah asset dari lapangan.</p>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <form action="{{ route('assets.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-secondary small">Nama Client</label>
                    <input type="text" name="nama_client" class="form-control @error('nama_client') is-invalid @enderror" placeholder="Nama Client" value="{{ old('nama_client') }}" required>
                    @error('nama_client')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-secondary small">Jenis Project</label>
                    <input type="text" name="jenis_project" class="form-control @error('jenis_project') is-invalid @enderror" placeholder="Contoh: Photoshoot" value="{{ old('jenis_project') }}" required>
                    @error('jenis_project')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold text-secondary small">Nama Lokasi / Gedung</label>
                    <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" placeholder="Nama Gedung / Tempat" value="{{ old('lokasi') }}" required>
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold text-secondary small">Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat lengkap lokasi" style="height: 80px; resize: none;">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold text-secondary small">Google Drive Link</label>
                    <input type="url" name="gdrive_link" class="form-control @error('gdrive_link') is-invalid @enderror" placeholder="https://drive.google.com/..." value="{{ old('gdrive_link') }}" required>
                    @error('gdrive_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold text-secondary small">Keterangan</label>
                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Catatan tambahan..." style="height: 100px; resize: none;">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="text-right mt-3">
                <a href="{{ route('assets.index') }}" class="btn btn-light px-4 shadow-sm mr-2">Batal</a>
                <button type="submit" class="btn btn-primary px-4 shadow-sm"><i class="bx bx-cloud-upload me-1"></i> Simpan Asset</button>
            </div>
        </form>
    </div>
</div>


@endsection