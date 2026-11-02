@extends('layouts.' . auth()->user()->role . '.app')

@section('title', 'Chat')

@section('content')

<style>
    /* Mengatur jarak agar tidak menempel ke pinggir layout admin */
    .page-content {
        padding: 20px !important;
        background-color: #f8f9fa;
    }

    /* Card Styling - Tinggi dinamis agar sama dengan halaman daftar */
    .chat-card {
        height: calc(100vh - 210px); 
        display: flex;
        flex-direction: column;
        border-radius: 15px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05) !important;
        border: none;
    }

    .card-header-custom {
        background: #fff;
        padding: 20px 25px;
        border-bottom: 1px solid #f1f1f1;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Search Bar Area */
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
    }

    /* User List & Chat Scroll Area */
    .scroll-area {
        flex: 1;
        overflow-y: auto;
    }

    .chat-box-area {
        flex: 1;
        overflow-y: auto;
        padding: 25px;
        background: #f9fbfc; /* Sedikit kontras agar chat lebih fokus */
        display: flex;
        flex-direction: column;
    }

    /* User Item Styling */
    .user-item {
        padding: 15px 25px;
        border-bottom: 1px solid #fcfcfc;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        text-decoration: none !important;
        color: inherit !important;
    }

    .user-item:hover { background: #f8faff; }
    .user-item.active { 
        background: #f0f4ff; 
        border-left: 4px solid #4e73df;
    }

    /* Avatar & Badge */
    .avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
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
        padding: 3px 10px;
        border-radius: 20px;
        background-color: #f0f3ff;
        color: #4e73df;
        font-weight: 800;
        display: inline-block;
    }

    /* Chat Bubbles */
    .msg-bubble {
        margin-bottom: 15px;
        max-width: 75%;
        padding: 12px 18px;
        border-radius: 15px;
        font-size: 14px;
    }

    .msg-me {
        background: #4e73df;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 2px;
    }

    .msg-other {
        background: #ffffff;
        color: #333;
        align-self: flex-start;
        border-bottom-left-radius: 2px;
        border: 1px solid #eef0f2;
    }

    /* Footer Input */
    .chat-footer {
        padding: 15px 25px;
        border-top: 1px solid #f1f1f1;
        background: #fff;
    }

    .input-pill {
        background: #f4f7f6 !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 10px 15px !important;
    }

    /* Scrollbar minimalis */
    .scroll-area::-webkit-scrollbar, .chat-box-area::-webkit-scrollbar { width: 4px; }
    .scroll-area::-webkit-scrollbar-thumb, .chat-box-area::-webkit-scrollbar-thumb { 
        background: #e2e8f0; border-radius: 10px; 
    }
</style>

            <div class="row mb-4">
                <div class="col-12 text- Indonesian">
                    <div class="d-flex align-items-center">
                        <div class="p-2 bg-white shadow-sm rounded-3 me-3">
                            <span style="font-size: 20px;">💬</span>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0">Pesan Tim</h4>
                            <p class="text-muted mb-0 small">Diskusi aktif</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                
                <div class="col-lg-4 col-md-5">
                    <div class="card chat-card">
                        <div class="card-header-custom">
                            <span class="fw-bold text-dark">Daftar Pengguna</span>
                            <span class="badge bg-light text-primary rounded-pill" style="font-size: 11px;">{{ count($users) }} Orang</span>
                        </div>

                        <div class="search-box">
                            <input type="text" id="userSearch" class="form-control" placeholder="Cari rekan tim...">
                        </div>

                        <div class="scroll-area" id="userContainer">
                            @foreach($users as $u)
                            <a href="/chat/{{$u->id}}" class="user-item {{ request()->segment(2) == $u->id ? 'active' : '' }}">
                                <div class="avatar">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                               <div class="overflow-hidden flex-grow-1">

<div class="d-flex justify-content-between align-items-center">

<div class="fw-bold text-dark text-truncate" style="font-size:14px;">
{{ $u->name }}
</div>

@if($u->unread > 0)
<span class="badge bg-danger rounded-pill" style="font-size:10px;">
{{ $u->unread }}
</span>
@endif

</div>

<div class="text-muted text-truncate" style="font-size:12px;">

@if($u->last_message)
{{ \Illuminate\Support\Str::limit($u->last_message,40) }}
@else
<span style="opacity:.6">Belum ada pesan</span>
@endif

</div>

</div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-7">
                    <div class="card chat-card">
                        <div class="card-header-custom">
                            <div class="d-flex align-items-center">
                                <div class="avatar" style="width: 36px; height: 36px; font-size: 13px; margin-right: 12px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 15px; line-height: 1.2;">{{ $user->name }}</div>
                                    <small class="text-success fw-bold" style="font-size: 10px;">● ONLINE</small>
                                </div>
                            </div>
                        </div>

                        <div id="chat-box" class="chat-box-area">
                            </div>

                        <div class="chat-footer">
                            <form id="chat-form">
                                <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                                <div class="input-group gap-2">
                                    <input type="text" name="message" id="msg-input" class="form-control input-pill" placeholder="Tulis pesan..." autocomplete="off">
                                    <input type="file" name="file" id="file-upload" class="d-none">
                                    <button type="button" class="btn btn-light border-0" onclick="document.getElementById('file-upload').click()">📎</button>
                                    <button type="submit" class="btn btn-primary px-4 fw-bold" style="border-radius: 10px;">Kirim</button>
                                </div>
                                <div id="file-name-preview" class="small mt-2 text-primary fw-bold" style="display:none; font-size: 10px;"></div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let conversation = {{ $conversation->id }};
    let currentUser = {{ auth()->id() }};

    function loadMessages() {
        $.get('/chat/fetch/' + conversation, function(data) {
            let html = '';
            data.forEach(msg => {
                let isMe = msg.sender_id == currentUser;
                let cls = isMe ? 'msg-me' : 'msg-other';
                let senderName = isMe ? 'Anda' : msg.user.name;
                html += `
                    <div class="msg-bubble ${cls}">
                        <b style="font-size: 10px; display: block; opacity: 0.8; margin-bottom: 4px;">${senderName}</b>
                        <div>${msg.message ?? ''}</div>
                        ${msg.file ? `<a href="/chat_files/${msg.file}" target="_blank" style="color:inherit; font-size:12px; display:block; margin-top:5px; text-decoration:underline;">📄 File</a>` : ''}
                    </div>
                `;
            });
            $('#chat-box').html(html);
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
        });
    }

    loadMessages();
    setInterval(loadMessages, 3000);

    // Fitur Search
    document.getElementById('userSearch').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let items = document.querySelectorAll('.user-item');
        items.forEach(function(item) {
            let text = item.textContent.toLowerCase();
            item.style.display = text.includes(filter) ? 'flex' : 'none';
        });
    });

    $('#file-upload').change(function() {
        let fileName = $(this).val().split('\\').pop();
        if(fileName) $('#file-name-preview').text('📎 ' + fileName).show();
    });

    $('#chat-form').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let msgInput = $('#msg-input');
        if (msgInput.val().trim() === "" && $('#file-upload').val() === "") return;
        $.ajax({
            url: '/chat/send',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function() {
                msgInput.val('');
                $('#file-upload').val('');
                $('#file-name-preview').hide();
                loadMessages();
            }
        });
    });
</script>

@endsection