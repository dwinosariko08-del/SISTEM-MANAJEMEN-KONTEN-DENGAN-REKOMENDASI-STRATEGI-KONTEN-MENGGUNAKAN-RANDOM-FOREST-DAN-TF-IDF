@extends('layouts.editor.app')

@section('title', 'Daftar Tugas Editor')

@section('content')

<style>
    /* Corporate Design System - Standardized Font Size */
    .main-content {
        font-size: 15px; /* Ukuran font standar corporate */
    }
    .card { border-radius: 8px; }

    /* Badge Standarisasi */
    .badge {
        font-size: 13px; /* Disamakan */
        font-weight: 500;
        padding: 0.4em 0.7em;
        border-radius: 4px;
    }

    /* Tombol Standarisasi */
    .btn-sm {
        font-size: 15px; /* Disamakan */
        padding: 0.4rem 0.8rem;
    }

    /* Soften the badges */
    .bg-soft-primary { background-color: #e0e7ff; color: #4338ca; }
    .bg-soft-success { background-color: #dcfce7; color: #15803d; }
    .bg-soft-warning { background-color: #fef9c3; color: #a16207; }
    .bg-soft-danger { background-color: #fee2e2; color: #b91c1c; }
    .bg-soft-info { background-color: #e0f2fe; color: #0369a1; }
    .bg-soft-secondary { background-color: #f3f4f6; color: #374151; }

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
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 13px; /* Disesuaikan agar muat */
        letter-spacing: 0.04em;
        font-weight: 700;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
        border-top: none;
        padding: 15px 12px 10px;
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
        font-size: 15px; /* Disamakan */
        padding: 15px 12px;
        color: #495057;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }
    #myTable tbody tr:hover td { background: #eef4ff !important; }

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



          <div class="row align-items-center mb-4">
                <div class="col-md-6">
                    <h3 class="fw-bold text-dark mb-1">Daftar Tugas Konten</h3>
                    <p class="text-muted mb-0">Kelola dan kerjakan Tugas konten yang telah tersedia.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
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

                        <div class="card-body p-0">
                            
                            <div class="table-responsive">
                                <table id="myTable" class="table table-hover align-middle mb-0 w-100">
                                    <thead>
                                        <tr class="header-row">
                                            <th class="ps-4 no-sort" width="60">No</th>
                                            <th class="th-idle" data-col="1">Posting Date</th>
                                            <th class="th-idle" data-col="2">Pillar</th>
                                            <th class="th-idle" data-col="3">Topic</th>
                                            <th class="th-idle" data-col="4">Asset</th>
                                            <th class="th-idle" data-col="5">Status</th>
                                            <th width="200" class="text-center pe-4 no-sort">Aksi</th>
                                        </tr>
                                        <tr class="filter-row">
                                            <th></th>
                                            <th><input type="text" id="f-date" placeholder="Filter tanggal…"></th>
                                            <th><input type="text" id="f-pillar" placeholder="Filter pillar…"></th>
                                            <th><input type="text" id="f-topic" placeholder="Filter topic…"></th>
                                            <th><input type="text" id="f-asset" placeholder="Filter asset…"></th>
                                            <th>
                                                <select id="f-status">
                                                    <option value="">Semua Status</option>
                                                    <option>Belum Dikerjakan</option>
                                                    <option>Menunggu Leader Review Script</option>
                                                    <option>Revisi Script</option>
                                                    <option>Approved</option>
                                                    <option>Menunggu Leader Review Video</option>
                                                    <option>Revisi Konten</option>
                                                    <option>Published</option>
                                                </select>
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTbody">
                                        @forelse ($contents as $content)
                                        <tr>
                                            {{-- NO --}}
                                            <td class="ps-4 text-muted">
                                                {{ $loop->iteration }}
                                            </td>

                                            {{-- POSTING DATE --}}
                                            <td class="fw-medium">
                                                {{ \Carbon\Carbon::parse($content->posting_date)->format('d M Y') }}
                                            </td>

                                            {{-- PILLAR --}}
                                            <td>
                                                {{ $content->pillar }}
                                            </td>

                                            {{-- TOPIC --}}
                                            <td class="fw-medium text-dark">
                                                {{ $content->topic }}
                                            </td>

                                            {{-- ASSET --}}
                                            <td>
                                                @if($content->asset)
                                                    <span class="badge bg-soft-info">
                                                        {{ $content->asset->nama_client }} - {{ $content->asset->jenis_project }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            {{-- STATUS --}}
                                            <td>
                                                @switch($content->status)
                                                    @case('assigned')
                                                        <span class="badge bg-soft-secondary">Belum Dikerjakan</span> @break
                                                    @case('on_progress')
                                                        <span class="badge bg-soft-warning">Menunggu Leader Review Script</span> @break
                                                    @case('revision')
                                                        <span class="badge bg-soft-danger">Revisi Script</span> @break
                                                    @case('done')
                                                        <span class="badge bg-soft-success">Approved</span> @break
                                                    @case('video_uploaded')
                                                        <span class="badge bg-soft-info">Menunggu Leader Review Video</span> @break
                                                    @case('video_revision')
                                                        <span class="badge bg-soft-danger">Revisi Konten</span> @break
                                                    @case('published')
                                                        <span class="badge bg-soft-primary">Published</span> @break
                                                    @default
                                                        <span class="badge bg-soft-dark text-white">{{ $content->status }}</span>
                                                @endswitch
                                            </td>

                                            {{-- AKSI --}}
                                            <td class="text-center pe-4">
                                                @if(in_array($content->status, ['assigned', 'revision']))
                                                    <a href="{{ route('editor.contents.create', $content->id) }}" class="btn btn-sm btn-primary px-3">
                                                        Kerjakan
                                                    </a>

                                                @elseif($content->status === 'on_progress' || $content->status === 'video_uploaded')
                                                    <span class="text-muted">Menunggu Review</span>

                                                @elseif($content->status === 'done')
                                                    @if(!$content->producedVideo)
                                                        <a href="{{ route('editor.videos.create', $content->id) }}" class="btn btn-sm btn-success text-white px-3">
                                                            Upload Video
                                                        </a>
                                                    @else
                                                        <span class="text-success fw-medium">Video Tersedia</span>
                                                    @endif

                                                @elseif($content->status === 'video_revision')
                                                    <a href="{{ route('editor.videos.create', $content->id) }}" class="btn btn-sm btn-danger px-3">
                                                        Revisi Video
                                                    </a>

                                                @elseif($content->status === 'published')
                                                    <span class="text-primary fw-bold">Selesai</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr id="empty-original">
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                Tidak ada assignment untuk editor
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        {{-- FOOTER --}}
                        <div id="dt-footer">
                            <div id="dt-info">Memuat…</div>
                            <div id="dt-paging"></div>
                        </div>

                    </div>
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
    var sortCol  = 1; // Default sorting by Posting Date
    var sortDir  = 'desc';
    var filtered = allRows.slice();

    function cell(row, i) {
        var td = row.querySelectorAll('td')[i];
        return td ? td.innerText.trim() : '';
    }

    function parseDate(s) {
        var mo = {Jan:0,Feb:1,Mar:2,Apr:3,Mei:4,Jun:5,Jul:6,Agu:7,Sep:8,Okt:9,Nov:10,Des:11};
        var p = s.split(' ');
        if(p.length < 3) return new Date(0);
        return new Date(+p[2], mo[p[1]] !== undefined ? mo[p[1]] : 0, +p[0]);
    }

    function doFilter() {
        var gs = document.getElementById('dt-search').value.toLowerCase();
        var fd = document.getElementById('f-date').value.toLowerCase();
        var fp = document.getElementById('f-pillar').value.toLowerCase();
        var ft = document.getElementById('f-topic').value.toLowerCase();
        var fa = document.getElementById('f-asset').value.toLowerCase();
        var fs = document.getElementById('f-status').value.toLowerCase();

        filtered = allRows.filter(function(row) {
            var tds  = row.querySelectorAll('td');
            var date = (tds[1]||{innerText:''}).innerText.toLowerCase();
            var pil  = (tds[2]||{innerText:''}).innerText.toLowerCase();
            var top  = (tds[3]||{innerText:''}).innerText.toLowerCase();
            var ast  = (tds[4]||{innerText:''}).innerText.toLowerCase();
            var sta  = (tds[5]||{innerText:''}).innerText.toLowerCase();

            if (fd && date.indexOf(fd) < 0) return false;
            if (fp && pil.indexOf(fp)  < 0) return false;
            if (ft && top.indexOf(ft)  < 0) return false;
            if (fa && ast.indexOf(fa)  < 0) return false;
            if (fs && sta.indexOf(fs)  < 0) return false;

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
            if (sortCol === 1) { // Sort by Date
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
                emptyCustom.innerHTML = '<td colspan="7" class="text-center py-5 text-muted">'
                    + '<i class="bx bx-search d-block fs-1 opacity-25 mb-2"></i>'
                    + 'Tidak ditemukan data yang cocok.</td>';
                tbody.appendChild(emptyCustom);
            }
            emptyCustom.style.display = '';
        } else {
            if (emptyRow)    emptyRow.style.display = 'none';
            if (emptyCustom) emptyCustom.style.display = 'none';
            
            var displayRows = filtered.slice(start, end);
            displayRows.forEach(function(r, idx){ 
                r.style.display = ''; 
                var noTd = r.querySelector('td');
                if(noTd) noTd.innerHTML = (start + idx + 1);
            });
        }

        document.getElementById('dt-info').textContent = total === 0
            ? 'Tidak ada data yang cocok'
            : 'Menampilkan ' + (start + 1) + ' \u2013 ' + end + ' dari ' + total + ' data';

        renderPaging(pages);

        document.querySelectorAll('#myTable thead tr.header-row th').forEach(function(th) {
            th.classList.remove('th-idle','th-asc','th-desc');
            if (th.classList.contains('no-sort')) return;
            var colIdx = parseInt(th.getAttribute('data-col'));
            if (isNaN(colIdx)) return;
            th.classList.add(colIdx === sortCol ? (sortDir === 'asc' ? 'th-asc' : 'th-desc') : 'th-idle');
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
    document.querySelectorAll('#myTable thead tr.header-row th').forEach(function(th) {
        if (th.classList.contains('no-sort')) return;
        var colIdx = parseInt(th.getAttribute('data-col'));
        if (isNaN(colIdx)) return;
        
        th.addEventListener('click', function() {
            if (th.classList.contains('th-asc'))       { sortDir = 'desc'; }
            else if (th.classList.contains('th-desc')) { sortDir = 'asc'; }
            else { sortCol = colIdx; sortDir = 'asc'; }
            sortCol = colIdx;
            doSort();
        });
    });

    ['dt-search','f-date','f-pillar','f-topic','f-asset'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('input', doFilter);
    });
    ['f-status'].forEach(function(id) {
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