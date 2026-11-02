@extends('layouts.' . auth()->user()->role . '.app')

@section('title', 'Daftar Chat')

@section('content')

<style>
    /* Mengatur jarak agar tidak menempel ke pinggir layout admin */
    .page-content {
        padding: 20px !important;
        background-color: #f8f9fa;
    }

    /* Card Styling - Tinggi dinamis agar tidak nabrak footer */
    .chat-card {
        /* 210px adalah estimasi tinggi Navbar + Footer + Padding */
        height: calc(100vh - 210px); 
        display: flex;
        flex-direction: column;
        border-radius: 15px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05) !important;
    }

    .card-header {
        background: #fff;
        padding: 20px 25px;
        border-bottom: 1px solid #f1f1f1;
    }

    /* Search Bar Modern */
    .search-box {
        padding: 15px 25px;
        background: #fff;
        border-bottom: 1px solid #f1f1f1;
    }

    .search-box input {
        border-radius: 10px;
        background: #f4f7f6;
        border: 1px solid #eee;
        padding: 10px 15px;
        font-size: 13px;
        transition: all 0.3s;
    }

    .search-box input:focus {
        background: #fff;
        border-color: #4e73df;
        box-shadow: none;
    }

    /* User List Scroll Area */
    .user-list {
        flex: 1;
        overflow-y: auto;
    }

    .user-item {
        padding: 15px 25px;
        border-bottom: 1px solid #fcfcfc;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        text-decoration: none !important;
        color: inherit !important;
    }

    .user-item:hover {
        background: #f8faff;
    }

    /* Avatar & Info */
    .avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px; /* Gaya kotak tumpul lebih modern */
        background: #4e73df;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .role-badge {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 3px 10px;
        border-radius: 20px;
        background-color: #f0f3ff;
        color: #4e73df;
        font-weight: 800;
        display: inline-block;
        margin-top: 4px;
    }

    .user-name {
        font-size: 14px;
        font-weight: 700;
        color: #333;
        margin-bottom: 0px;
    }

    /* Scrollbar minimalis */
    .user-list::-webkit-scrollbar { width: 4px; }
    .user-list::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <div class="p-2 bg-white shadow-sm rounded-3 me-3">
                            <span style="font-size: 20px;">💬</span>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0">Pesan Tim</h4>
                            <p class="text-muted mb-0 small">Manajemen komunikasi internal</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-5">
                    <div class="card chat-card border-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark">Daftar Pengguna</span>
                            <span class="badge bg-soft-primary text-primary rounded-pill" style="font-size: 11px;">{{ count($users) }} Orang</span>
                        </div>

                        <div class="search-box">
                            <input type="text" id="userSearch" class="form-control" placeholder="Cari rekan tim...">
                        </div>

                        <div class="user-list" id="userContainer">
                            @foreach($users as $user)
                                <a href="{{ route('chat.open', $user->id) }}" class="user-item">
                                    <div class="avatar">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>

                                    <div class="user-info overflow-hidden flex-grow-1">

<div class="d-flex justify-content-between align-items-center">

<div class="user-name text-truncate">
{{ $user->name }}
</div>

@if($user->unread > 0)
<span class="badge bg-danger rounded-pill">
{{ $user->unread }}
</span>
@endif

</div>

<div class="text-muted text-truncate" style="font-size:12px">

@if($user->last_message)
{{ $user->last_message }}
@else
<span style="opacity:.6">Belum ada pesan</span>
@endif

</div>

</div>

                                    <div class="ms-auto">
                                        <i class="fa fa-chevron-right text-light" style="font-size: 10px;"></i>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-7 d-none d-md-block">
                    <div class="card chat-card border-0 d-flex align-items-center justify-content-center text-center bg-white shadow-sm">
                        <div class="p-5">
                            <div class="mb-4" style="filter: grayscale(0.5);">
                                <img src="https://cdn-icons-png.flaticon.com/512/4080/4080901.png" width="120" alt="Chat Illustration">
                            </div>
                            <h5 class="fw-bold text-dark">Ruang Obrolan Tim</h5>
                            <p class="text-muted mx-auto" style="max-width: 300px;">
                                Pilih salah satu anggota tim di sebelah kiri untuk mulai berdiskusi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>


<script>
    // Fitur Search Sederhana
    document.getElementById('userSearch').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let items = document.querySelectorAll('.user-item');
        
        items.forEach(function(item) {
            let text = item.textContent.toLowerCase();
            if(text.includes(filter)) {
                item.style.setProperty('display', 'flex', 'important');
            } else {
                item.style.setProperty('display', 'none', 'important');
            }
        });
    });
</script>

@endsection