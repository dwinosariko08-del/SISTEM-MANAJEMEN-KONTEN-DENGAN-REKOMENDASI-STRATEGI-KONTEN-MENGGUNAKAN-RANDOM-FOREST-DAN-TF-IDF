<div class="kanban-card">
    <div class="d-flex justify-content-between align-items-start">
        <span class="card-pillar">{{ $content->pillar }}</span>
        <div class="dropdown">
            <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="{{ route('leader.contents.show', $content->id) }}">Detail</a>
                <a class="dropdown-item" href="#">Edit</a>
            </div>
        </div>
    </div>
    
    <a href="{{ route('leader.contents.show', $content->id) }}" class="card-topic">
        {{ Str::limit($content->topic, 60) }}
    </a>

    @if($content->asset)
    <a href="{{ $content->asset->gdrive_link }}" target="_blank" class="card-asset-badge mb-2">
        <i class="bx bxl-google-cloud me-1"></i> {{ $content->asset->nama_client }}
    </a>
    @endif

    <div class="card-footer-info">
        <div class="card-date">
            <i class="bx bx-calendar me-1"></i>
            {{ \Carbon\Carbon::parse($content->posting_date)->format('d M') }}
        </div>
        <div class="editor-status">
            @if($content->editorContent)
                <span class="badge badge-dot bg-success" title="Editor Done"></span>
            @else
                <span class="badge badge-dot bg-warning" title="Waiting Editor"></span>
            @endif
        </div>
    </div>
</div>