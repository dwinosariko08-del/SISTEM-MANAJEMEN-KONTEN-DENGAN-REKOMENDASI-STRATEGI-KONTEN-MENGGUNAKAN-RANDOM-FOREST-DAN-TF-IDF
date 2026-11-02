@extends('layouts.leader.app')

@section('title', 'Dashboard Assignment Konten')

@section('content')

<style>
    .bg-soft-primary   { background-color: #e0e7ff; color: #4338ca; }
    .bg-soft-success   { background-color: #dcfce7; color: #15803d; }
    .bg-soft-warning   { background-color: #fef9c3; color: #a16207; }
    .bg-soft-danger    { background-color: #fee2e2; color: #b91c1c; }
    .bg-soft-info      { background-color: #e0f2fe; color: #0369a1; }
    .bg-soft-secondary { background-color: #f3f4f6; color: #374151; }

    .badge-custom {
        font-size: 12px;
        font-weight: 500;
        padding: 0.35em 0.75em;
        border-radius: 4px;
        display: inline-block;
    }

    /* ── Toolbar ── */
    #dt-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px 12px;
        flex-wrap: wrap;
        gap: 10px;
    }
    .dt-length-wrap,
    .dt-search-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #6c757d;
    }
    .dt-length-wrap select,
    .dt-search-wrap input {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 14px;
        color: #495057;
        background: #fff;
    }
    .dt-search-wrap input { width: 220px; }
    .dt-search-wrap input:focus,
    .dt-length-wrap select:focus { outline: none; border-color: #86b7fe; }

    /* ── Table Header ── */
    #myTable thead tr.header-row th {
        background: #f8f9fa;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #6c757d;
        padding: 12px 12px 8px;
        border-bottom: 2px solid #dee2e6;
        border-top: none;
        cursor: pointer;
        user-select: none;
        white-space: nowrap;
    }
    #myTable thead tr.header-row th:hover { background: #e9ecef; }
    #myTable thead tr.header-row th.no-sort { cursor: default; }
    #myTable thead tr.header-row th.th-asc::after  { content: ' ↑'; color: #0d6efd; }
    #myTable thead tr.header-row th.th-desc::after { content: ' ↓'; color: #0d6efd; }
    #myTable thead tr.header-row th.th-idle::after { content: ' ⇅'; opacity: .35; }

    /* ── Filter Row ── */
    #myTable thead tr.filter-row th {
        background: #f8f9fa;
        padding: 5px 12px 10px;
        border-bottom: 2px solid #dee2e6;
    }
    #myTable thead tr.filter-row th input,
    #myTable thead tr.filter-row th select {
        width: 100%;
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 5px 8px;
        font-size: 13px;
        color: #495057;
        background: #fff;
    }
    #myTable thead tr.filter-row th input:focus,
    #myTable thead tr.filter-row th select:focus {
        outline: none; border-color: #86b7fe;
    }
    #myTable thead tr.filter-row th input::placeholder { color: #bbb; }

    /* ── Body ── */
    #myTable tbody td {
        font-size: 14px;
        padding: 12px;
        color: #495057;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }
    #myTable tbody tr:hover td { background: #eef4ff !important; }

    /* ── Action buttons ── */
    .action-wrap {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 5px;
    }
    .action-wrap .btn { font-size: 13px; padding: 5px 10px; }

    /* ── Footer ── */
    #dt-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 20px 16px;
        flex-wrap: wrap;
        gap: 10px;
        border-top: 1px solid #f0f0f0;
    }
    #dt-info { font-size: 13px; color: #6c757d; }
    #dt-paging { display: flex; gap: 4px; align-items: center; }
    #dt-paging button {
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 5px 11px;
        font-size: 13px;
        color: #0d6efd;
        background: #fff;
        cursor: pointer;
        line-height: 1.4;
        transition: background .12s;
    }
    #dt-paging button:hover:not(.pg-active):not([disabled]) { background: #e9ecef; }
    #dt-paging button.pg-active {
        background: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
        font-weight: 600;
    }
    #dt-paging button[disabled] { opacity: .38; cursor: not-allowed; }
</style>

{{-- ══ Tidak ada wrapper tambahan di sini ══
     Layout sudah handle: layout-page > content-wrapper > container-xxl
     Langsung mulai konten dari sini --}}

{{-- Page Title --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold text-dark">Daftar Assignment Konten</h4>
    <a href="{{ route('leader.contents.create') }}" class="btn btn-primary px-4 shadow-sm">
        <i class="bx bx-plus me-1"></i> Buat Assignment
    </a>
</div>

{{-- Card --}}
<div class="card shadow-sm border-0">

    {{-- TOOLBAR --}}
    <div id="dt-toolbar">
        <div class="dt-length-wrap">
            <span>Tampilkan</span>
            <select id="dt-length">
                <option value="10" selected>10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span>data per halaman</span>
        </div>
        <div class="dt-search-wrap">
            <label for="dt-search" class="mb-0">Cari:</label>
            <input type="text" id="dt-search" placeholder="Ketik untuk mencari…">
        </div>
    </div>

    {{-- TABLE --}}
    <div class="table-responsive">
        <table id="myTable" class="table table-hover mb-0 w-100">
            <thead>
                <tr class="header-row">
                    <th class="ps-3 th-idle" data-col="0">Posting Date</th>
                    <th class="th-idle" data-col="1">Topic</th>
                    <th class="th-idle" data-col="2">Pillar</th>
                    <th class="th-idle" data-col="3">Status Konten</th>
                    <th class="th-idle" data-col="4">Status Video</th>
                    <th class="no-sort text-end pe-3">Aksi</th>
                </tr>
                <tr class="filter-row">
                    <th class="ps-3"><input type="text" id="f-date"   placeholder="Filter tanggal…"></th>
                    <th><input type="text" id="f-topic"  placeholder="Filter topic…"></th>
                    <th><input type="text" id="f-pillar" placeholder="Filter pillar…"></th>
                    <th>
                        <select id="f-status">
                            <option value="">Semua Status</option>
                            <option>Assigned</option>
                            <option>Review Konten</option>
                            <option>Revisi Script</option>
                            <option>Approved</option>
                            <option>Review Video</option>
                            <option>Revisi Video</option>
                            <option>Published</option>
                        </select>
                    </th>
                    <th>
                        <select id="f-video">
                            <option value="">Semua</option>
                            <option>Tersedia</option>
                            <option>Kosong</option>
                        </select>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="myTbody">
                @forelse ($contents as $content)
                <tr>
                    <td class="ps-3 fw-medium text-dark">
                        {{ \Carbon\Carbon::parse($content->posting_date)->format('d M Y') }}
                    </td>
                    <td class="fw-medium text-dark">{{ $content->topic }}</td>
                    <td class="text-muted">{{ $content->pillar }}</td>
                    <td>
                        @switch($content->status)
                            @case('assigned')
                                <span class="badge-custom bg-soft-secondary">Assigned</span> @break
                            @case('on_progress')
                                <span class="badge-custom bg-soft-warning">Review Konten</span> @break
                            @case('revision')
                                <span class="badge-custom bg-soft-danger">Revisi Script</span> @break
                            @case('done')
                                <span class="badge-custom bg-soft-success">Approved</span> @break
                            @case('video_uploaded')
                                <span class="badge-custom bg-soft-info">Review Video</span> @break
                            @case('video_revision')
                                <span class="badge-custom bg-soft-danger">Revisi Video</span> @break
                            @case('published')
                                <span class="badge-custom bg-soft-primary">Published</span> @break
                            @default
                                <span class="badge-custom bg-dark text-white">Unknown</span>
                        @endswitch
                    </td>
                    <td>
                        @if($content->producedVideo)
                            <span class="text-success fw-medium">
                                <i class="bx bxs-check-circle me-1"></i>Tersedia
                            </span>
                        @else
                            <span class="text-muted">
                                <i class="bx bx-minus me-1"></i>Kosong
                            </span>
                        @endif
                    </td>
                    <td class="pe-3">
                        <div class="action-wrap">
                            @if($content->status === 'on_progress')
                                <a href="{{ route('leader.contents.review.form', $content->id) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="fa-solid fa-check"></i> Review
                                </a>
                            @elseif($content->status === 'video_uploaded')
                                <a href="{{ route('leader.contents.review-video.form', $content->id) }}"
                                   class="btn btn-sm btn-info text-white">
                                    <i class="fa-solid fa-video"></i> Video
                                </a>
                            @else
                                <a href="{{ route('leader.contents.show', $content->id) }}"
                                   class="btn btn-sm btn-light border">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </a>
                            @endif
                            <a href="{{ route('leader.contents.edit', $content->id) }}"
                               class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('leader.contents.destroy', $content->id) }}"
                                  method="POST" style="display:inline;margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin ingin menghapus assignment ini?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr id="empty-original">
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bx bx-folder-open d-block fs-1 opacity-25 mb-2"></i>
                        Belum ada data assignment untuk saat ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- FOOTER --}}
    <div id="dt-footer">
        <div id="dt-info">Memuat…</div>
        <div id="dt-paging"></div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    var tbody   = document.getElementById('myTbody');
    var allRows = Array.from(tbody.querySelectorAll('tr')).filter(function(r) {
        return !r.querySelector('td[colspan]') && r.id !== 'empty-original';
    });

    var pageLen  = 10;
    var curPage  = 1;
    var sortCol  = 0;
    var sortDir  = 'desc';
    var filtered = allRows.slice();

    function cell(row, i) {
        var td = row.querySelectorAll('td')[i];
        return td ? td.innerText.trim() : '';
    }

    function parseDate(s) {
        var mo = {Jan:0,Feb:1,Mar:2,Apr:3,Mei:4,Jun:5,Jul:6,Agu:7,Sep:8,Okt:9,Nov:10,Des:11};
        var p = s.split(' ');
        return new Date(+p[2], mo[p[1]] !== undefined ? mo[p[1]] : 0, +p[0]);
    }

    function doFilter() {
        var gs = document.getElementById('dt-search').value.toLowerCase();
        var fd = document.getElementById('f-date').value.toLowerCase();
        var ft = document.getElementById('f-topic').value.toLowerCase();
        var fp = document.getElementById('f-pillar').value.toLowerCase();
        var fs = document.getElementById('f-status').value.toLowerCase();
        var fv = document.getElementById('f-video').value.toLowerCase();

        filtered = allRows.filter(function(row) {
            var tds  = row.querySelectorAll('td');
            var date = (tds[0]||{innerText:''}).innerText.toLowerCase();
            var top  = (tds[1]||{innerText:''}).innerText.toLowerCase();
            var pil  = (tds[2]||{innerText:''}).innerText.toLowerCase();
            var sta  = (tds[3]||{innerText:''}).innerText.toLowerCase();
            var vid  = (tds[4]||{innerText:''}).innerText.toLowerCase();

            if (fd && date.indexOf(fd) < 0) return false;
            if (ft && top.indexOf(ft)  < 0) return false;
            if (fp && pil.indexOf(fp)  < 0) return false;
            if (fs && sta.indexOf(fs)  < 0) return false;
            if (fv && vid.indexOf(fv)  < 0) return false;

            if (gs) {
                var all = Array.from(tds).map(function(td){ return td.innerText; }).join(' ').toLowerCase();
                if (all.indexOf(gs) < 0) return false;
            }
            return true;
        });

        curPage = 1;
        doSort();
    }

    function doSort() {
        filtered.sort(function(a, b) {
            var va = cell(a, sortCol);
            var vb = cell(b, sortCol);
            if (sortCol === 0) {
                va = parseDate(va); vb = parseDate(vb);
                return sortDir === 'asc' ? va - vb : vb - va;
            }
            return sortDir === 'asc'
                ? va.localeCompare(vb, 'id')
                : vb.localeCompare(va, 'id');
        });
        doRender();
    }

    function doRender() {
        var total = filtered.length;
        var pages = Math.max(1, Math.ceil(total / pageLen));
        if (curPage > pages) curPage = pages;

        var start = (curPage - 1) * pageLen;
        var end   = Math.min(start + pageLen, total);

        allRows.forEach(function(r){ r.style.display = 'none'; });

        var emptyRow = document.getElementById('empty-original');
        var emptyCustom = document.getElementById('dt-empty-custom');

        if (total === 0) {
            if (emptyRow) emptyRow.style.display = 'none';
            if (!emptyCustom) {
                emptyCustom = document.createElement('tr');
                emptyCustom.id = 'dt-empty-custom';
                emptyCustom.innerHTML = '<td colspan="6" class="text-center py-5 text-muted">'
                    + '<i class="bx bx-search d-block fs-1 opacity-25 mb-2"></i>'
                    + 'Tidak ditemukan data yang cocok.</td>';
                tbody.appendChild(emptyCustom);
            }
            emptyCustom.style.display = '';
        } else {
            if (emptyRow)    emptyRow.style.display = 'none';
            if (emptyCustom) emptyCustom.style.display = 'none';
            filtered.slice(start, end).forEach(function(r){ r.style.display = ''; });
        }

        document.getElementById('dt-info').textContent = total === 0
            ? 'Tidak ada data yang cocok'
            : 'Menampilkan ' + (start + 1) + ' \u2013 ' + end + ' dari ' + total + ' data';

        renderPaging(pages);

        document.querySelectorAll('#myTable thead tr.header-row th').forEach(function(th, i) {
            th.classList.remove('th-idle','th-asc','th-desc');
            if (th.classList.contains('no-sort')) return;
            th.classList.add(i === sortCol ? (sortDir === 'asc' ? 'th-asc' : 'th-desc') : 'th-idle');
        });
    }

    function renderPaging(pages) {
        var wrap = document.getElementById('dt-paging');
        wrap.innerHTML = '';

        function makeBtn(label, page, active, disabled) {
            var b = document.createElement('button');
            b.innerHTML = label;
            if (active)   b.classList.add('pg-active');
            if (disabled) b.disabled = true;
            if (!disabled && !active) {
                b.addEventListener('click', function(){ curPage = page; doRender(); });
            }
            wrap.appendChild(b);
        }

        makeBtn('&laquo;', 1, false, curPage === 1);
        makeBtn('&lsaquo;', curPage - 1, false, curPage === 1);

        var s = Math.max(1, curPage - 3);
        var e = Math.min(pages, s + 6);
        if (e - s < 6) s = Math.max(1, e - 6);

        for (var p = s; p <= e; p++) {
            makeBtn(p, p, p === curPage, false);
        }

        makeBtn('&rsaquo;', curPage + 1, false, curPage === pages);
        makeBtn('&raquo;', pages, false, curPage === pages);
    }

    /* ── Event Listeners ── */
    document.querySelectorAll('#myTable thead tr.header-row th').forEach(function(th, i) {
        if (th.classList.contains('no-sort')) return;
        th.addEventListener('click', function() {
            sortCol = (sortCol === i) ? sortCol : i;
            sortDir = (sortCol === i && i === sortCol) ? (sortDir === 'asc' ? 'desc' : 'asc') : 'asc';
            if (i !== sortCol) { sortCol = i; sortDir = 'asc'; }
            /* fix: logic sederhana */
            if (th.classList.contains('th-asc'))  { sortDir = 'desc'; }
            else if (th.classList.contains('th-desc')) { sortDir = 'asc'; }
            else { sortCol = i; sortDir = 'asc'; }
            doSort();
        });
    });

    ['dt-search','f-date','f-topic','f-pillar'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('input', doFilter);
    });
    ['f-status','f-video'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('change', doFilter);
    });
    document.getElementById('dt-length').addEventListener('change', function() {
        pageLen = parseInt(this.value, 10);
        curPage = 1;
        doRender();
    });

    doSort();
});
</script>

@endsection