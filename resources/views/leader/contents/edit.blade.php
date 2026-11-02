@extends('layouts.leader.app')

@section('title', 'Edit Assignment Konten')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1 fw-bold text-dark">Perbarui Assignment Konten</h4>
        <p class="text-muted small mb-0">Perbarui formulir berikut untuk mengubah penugasan konten ke editor.</p>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <form action="{{ route('leader.contents.update', $content->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-secondary small">Tanggal Posting</label>
                    <input type="date" name="posting_date" class="form-control @error('posting_date') is-invalid @enderror" value="{{ old('posting_date', $content->posting_date) }}" required>
                    @error('posting_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-secondary small">Content Pillar</label>
                    <input type="text" name="pillar" class="form-control @error('pillar') is-invalid @enderror" placeholder="Edukasi, Hiburan, dll" value="{{ old('pillar', $content->pillar) }}" required>
                    @error('pillar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold text-secondary small">Topik Utama</label>
                    <input type="text" name="topic" class="form-control @error('topic') is-invalid @enderror" placeholder="Judul atau tema konten..." value="{{ old('topic', $content->topic) }}" required>
                    @error('topic')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold text-secondary small">Pilih Asset</label>
                    <select name="asset_id" class="form-select form-control @error('asset_id') is-invalid @enderror" required>
                        <option value="" disabled>Pilih asset project...</option>
                        @foreach($assets as $asset)
                            <option value="{{ $asset->id }}" {{ $content->asset_id == $asset->id ? 'selected' : '' }}>
                                {{ $asset->nama_client }} — {{ $asset->jenis_project }}
                            </option>
                        @endforeach
                    </select>
                    @error('asset_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold text-secondary small">Instruksi Detail</label>
                    <textarea name="notes_for_creator" class="form-control @error('notes_for_creator') is-invalid @enderror" 
                        placeholder="Tuliskan brief detail di sini..." 
                        style="height: 120px; resize: none;">{{ old('notes_for_creator', $content->notes_for_creator) }}</textarea>
                    @error('notes_for_creator')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="text-right mt-3">
                <a href="{{ route('leader.contents.index') }}" class="btn btn-light px-4 shadow-sm mr-2">Batal</a>
                <button type="submit" class="btn btn-primary px-4 shadow-sm">Perbarui Assignment</button>
            </div>

        </form>
    </div>
</div>

@endsection