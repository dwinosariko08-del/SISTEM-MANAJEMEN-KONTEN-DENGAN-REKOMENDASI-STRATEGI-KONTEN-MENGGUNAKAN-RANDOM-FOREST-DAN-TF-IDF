{{-- Trik Dynamic Layout: Otomatis memanggil layouts.leader.app, layouts.editor.app, atau layouts.lapangan.app tergantung role --}}
@extends('layouts.' . auth()->user()->role . '.app')

@section('title', 'Profil Saya')

@section('content')
<style>
    /* Integrasi Aksen Tema Warna Biru NSA */
    :root {
        --primary-color: #0D6EFD;
        --primary-hover: #0b5ed7;
        --primary-light: rgba(13, 110, 253, 0.15);
    }

    .profile-avatar-box {
        background: linear-gradient(135deg, #212529 0%, #000000 100%);
        border: 2px solid var(--primary-color);
        overflow: hidden;
        object-fit: cover;
    }

    .nsa-card-header {
        border-bottom: 2px solid var(--primary-light) !important;
    }

    /* Kustomisasi Tombol Utama agar Senada dengan Tema NSA */
    .btn-nsa-primary {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: #000000 !important;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-nsa-primary:hover {
        background-color: #ffffff !important;
        border-color: #ffffff !important;
        color: #000000 !important;
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }

    /* Icon Detail Profil */
    .profile-icon-bg {
        background-color: var(--primary-light) !important;
        color: var(--primary-color) !important;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-weight: bold;
    }

    /* Kustomisasi Tombol Pilih Foto Ringkas */
    .btn-upload-avatar {
        cursor: pointer;
        padding: 4px 12px;
        font-size: 11px;
        font-weight: bold;
        border-radius: 20px;
        background: #212529;
        color: var(--primary-color);
        border: 1px solid var(--primary-color);
        transition: all 0.2s;
    }
    .btn-upload-avatar:hover {
        background: var(--primary-color);
        color: #000;
    }
</style>

            <div class="row mb-4">
                <div class="col-12">
                    <h4 class="mb-1 fw-bold text-dark">Informasi Akun</h4>
                    <p class="text-muted small mb-0">Pantau detail profil, ganti foto, dan perbarui pengaturan keamanan akun Anda.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="row">
                    {{-- Kiri: Card Ringkasan Profil "Tentang Saya" & Input File --}}
                    <div class="col-xl-4 col-lg-5 mb-4">
                        <div class="card border-0 shadow-sm text-center p-2">
                            <div class="card-body">
                                
                                <div class="position-relative d-inline-block mx-auto mb-2">
                                    @if($user->avatar)
                                        <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" 
                                             class="profile-avatar-box rounded-circle shadow" 
                                             style="width: 100px; height: 100px;">
                                    @else
                                        <div id="avatar-placeholder" class="profile-avatar-box text-white rounded-circle d-flex align-items-center justify-content-center shadow" 
                                             style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: 700;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <img id="avatar-preview" src="" class="profile-avatar-box rounded-circle shadow d-none" style="width: 100px; height: 100px;">
                                    @endif
                                    <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-2 border-white rounded-circle" title="Online"></span>
                                </div>

                                <div class="mb-3">
                                    <label for="avatar-input" class="btn-upload-avatar shadow-sm">
                                        📷 Ganti Foto
                                    </label>
                                    <input type="file" id="avatar-input" name="avatar" class="d-none" accept="image/*">
                                    @error('avatar')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <h5 class="fw-bold mb-1 text-dark">{{ $user->name }}</h5>
                                <p class="text-muted small mb-3">{{ $user->email }}</p>

                                @if($user->role === 'leader')
                                    <span class="badge bg-danger text-white px-3 py-2 rounded-pill fw-semibold small shadow-sm">
                                        👑 Tim Leader
                                    </span>
                                @elseif($user->role === 'editor')
                                    <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-semibold small shadow-sm">
                                        🎬 Content Editor
                                    </span>
                                @else
                                    <span class="badge bg-dark text-warning px-3 py-2 rounded-pill fw-semibold small shadow-sm border border-warning">
                                        📸 Tim Lapangan
                                    </span>
                                @endif

                                <hr class="my-4 text-muted opacity-25">

                                <div class="text-start px-2">
                                    <h6 class="text-uppercase font-size-12 text-muted fw-bold mb-3 tracking-wider" style="letter-spacing: 1px;">Tentang Saya</h6>
                                    
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3"><div class="profile-icon-bg">👤</div></div>
                                        <div>
                                            <p class="text-muted mb-0 small">Nama Pengguna</p>
                                            <h6 class="mb-0 text-dark font-size-14 small fw-semibold">{{ $user->name }}</h6>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3"><div class="profile-icon-bg">✉️</div></div>
                                        <div>
                                            <p class="text-muted mb-0 small">Email Terdaftar</p>
                                            <h6 class="mb-0 text-dark font-size-14 small fw-semibold text-break">{{ $user->email }}</h6>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <div class="me-3"><div class="profile-icon-bg">📅</div></div>
                                        <div>
                                            <p class="text-muted mb-0 small">Bergabung Sejak</p>
                                            <h6 class="mb-0 text-dark font-size-14 small fw-semibold">
                                                {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Kanan: Form Data Profil Pengguna --}}
                    <div class="col-xl-8 col-lg-7">
                        
                        {{-- Alert Notifikasi Sukses --}}
                        @if (session('status') === 'profile-updated')
                            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 4px solid #198754 !important;">
                                <strong>Sukses!</strong> Informasi profil dan foto Anda telah berhasil diperbarui.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 4px solid #198754 !important;">
                                <strong>Sukses!</strong> Kredensial keamanan password berhasil diubah.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-transparent nsa-card-header py-3">
                                <h5 class="card-title mb-0 fw-bold text-dark">Ubah Informasi Profil</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold text-secondary small">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                               value="{{ old('name', $user->name) }}" required autocomplete="name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold text-secondary small">Alamat Email</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                               value="{{ old('email', $user->email) }}" required autocomplete="username">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary small">Otoritas Akses (Role)</label>
                                    <input type="text" class="form-control bg-light text-muted" value="{{ ucfirst($user->role) }}" readonly disabled style="cursor: not-allowed;">
                                </div>

                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-nsa-primary px-4 shadow-sm">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>
            </form>

                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-transparent nsa-card-header py-3">
                                <h5 class="card-title mb-0 fw-bold text-dark">Keamanan & Perbarui Password</h5>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    @method('put')

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-secondary small">Password Saat Ini</label>
                                        <input type="password" name="current_password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" required autocomplete="current-password">
                                        @error('current_password', 'updatePassword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold text-secondary small">Password Baru</label>
                                            <input type="password" name="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" required autocomplete="new-password">
                                            @error('password', 'updatePassword')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold text-secondary small">Konfirmasi Password Baru</label>
                                            <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="text-end mt-3">
                                        <button type="submit" class="btn btn-nsa-primary px-4 shadow-sm">Perbarui Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm border-start border-danger border-3 mb-4">
                            <div class="card-body d-flex align-items-center justify-content-between p-4">
                                <div>
                                    <h6 class="fw-bold text-danger mb-1">Hapus Akun Permanen</h6>
                                    <p class="text-muted small mb-0">Tindakan ini tidak dapat dibatalkan. Seluruh data penugasan Anda akan dibersihkan secara permanen.</p>
                                </div>
                                <button type="button" class="btn btn-outline-danger btn-sm px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                                    Hapus Akun
                                </button>
                            </div>
                        </div>

                    </div>
                </div>


{{-- Bootstrap Modal untuk Konfirmasi Hapus Akun --}}
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="{{ route('profile.destroy') }}" class="modal-content border-0 shadow">
            @csrf
            @method('delete')
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger" id="deleteUserModalLabel">Hapus Akun?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <p class="text-muted small">Apakah Anda benar-benar yakin? Mohon konfirmasi kembali dengan memasukkan sandi akun aktif Anda saat ini.</p>
                <div class="mb-2">
                    <input type="password" name="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="Kata Sandi Akun" required>
                    @error('password', 'userDeletion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger btn-sm px-3 fw-bold">Ya, Hapus Akun</button>
            </div>
        </form>
    </div>
</div>

{{-- Script Ringkas untuk Fitur Live Preview Gambar Sebelum Di-save --}}
<script>
    document.getElementById('avatar-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('avatar-preview');
                const placeholderDiv = document.getElementById('avatar-placeholder');
                
                previewImg.src = e.target.result;
                previewImg.classList.remove('d-none');
                
                if (placeholderDiv) {
                    placeholderDiv.classList.add('d-none');
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection