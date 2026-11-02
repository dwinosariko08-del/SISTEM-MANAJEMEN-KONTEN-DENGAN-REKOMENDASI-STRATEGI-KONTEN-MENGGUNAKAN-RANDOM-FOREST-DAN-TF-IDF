@extends('layouts.lapangan.app')

@section('title', 'Asset Library')

@section('content')

<style>
    /* Corporate Design System - Standardized Font Size */
    .main-content {
        font-size: 15px; /* Ukuran font standar */
    }
    .card { border-radius: 8px; }

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
        font-size: 13px; /* Disesuaikan sedikit lebih kecil dari td */
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

    /* Tombol Standarisasi */
    .btn { font-size: 15px; }
    .btn-sm { font-size: 12px; padding: 0.4rem 0.8rem; }

    /* Link Style */
    .btn-outline-info {
        color: #0369a1;
        border-color: #0369a1;
    }
    .btn-outline-info:hover {
        background-color: #0369a1;
        color: #fff;
    }
</style>


            {{-- Alert Success --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bx bx-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- Page Title & Action --}}
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 fw-bold text-dark">Asset Library</h4>
                    </div>
                    @if(auth()->user()->role === 'lapangan')
                    <a href="{{ route('assets.create') }}" class="btn btn-primary px-4 shadow-sm">
                        <i class="bx bx-plus me-1"></i> Upload Asset
                    </a>
                    @endif
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

                        <div class="table-responsive">
                            <table id="myTable" class="table table-hover align-middle mb-0 w-100">
                                <thead>
                                    <tr class="header-row">
                                        <th class="ps-4 th-idle" data-col="0">Client</th>
                                        <th class="th-idle" data-col="1">Project</th>
                                        <th class="th-idle" data-col="2">Lokasi</th>
                                        <th class="no-sort">Google Drive</th>
                                        <th class="th-idle" data-col="4">Keterangan</th>
                                    </tr>
                                    <tr class="filter-row">
                                        <th class="ps-4"><input type="text" id="f-client" placeholder="Filter client…"></th>
                                        <th><input type="text" id="f-project" placeholder="Filter project…"></th>
                                        <th><input type="text" id="f-lokasi" placeholder="Filter lokasi…"></th>
                                        <th></th>
                                        <th><input type="text" id="f-keterangan" placeholder="Filter keterangan…"></th>
                                    </tr>
                                </thead>
                                <tbody id="myTbody">
                                    @forelse($assets as $asset)
                                    <tr>
                                        <td class="ps-4">
                                            <span class="fw-bold text-dark">{{ $asset->nama_client }}</span>
                                        </td>
                                        <td class="fw-medium">
                                            {{ $asset->jenis_project }}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-medium text-dark">{{ $asset->lokasi }}</span>
                                                <span class="text-muted" style="font-size: 12px;">{{ $asset->alamat }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ $asset->gdrive_link }}" target="_blank" class="btn btn-sm btn-outline-info px-3">
                                                <i class="bx bxl-google-drive me-1"></i> Lihat Folder
                                            </a>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $asset->keterangan ?: '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr id="empty-original">
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="bx bx-folder-open d-block fs-1 opacity-25"></i>
                                            <p class="mt-2 mb-0">Belum ada asset yang diunggah</p>
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
    var sortDir  = 'asc';
    var filtered = allRows.slice();

    function cell(row, i) {
        var td = row.querySelectorAll('td')[i];
        return td ? td.innerText.trim() : '';
    }

    function doFilter() {
        var gs = document.getElementById('dt-search').value.toLowerCase();
        var fc = document.getElementById('f-client').value.toLowerCase();
        var fp = document.getElementById('f-project').value.toLowerCase();
        var fl = document.getElementById('f-lokasi').value.toLowerCase();
        var fk = document.getElementById('f-keterangan').value.toLowerCase();

        filtered = allRows.filter(function(row) {
            var tds  = row.querySelectorAll('td');
            var client = (tds[0]||{innerText:''}).innerText.toLowerCase();
            var project  = (tds[1]||{innerText:''}).innerText.toLowerCase();
            var lokasi  = (tds[2]||{innerText:''}).innerText.toLowerCase();
            var ket  = (tds[4]||{innerText:''}).innerText.toLowerCase();

            if (fc && client.indexOf(fc) < 0) return false;
            if (fp && project.indexOf(fp)  < 0) return false;
            if (fl && lokasi.indexOf(fl)  < 0) return false;
            if (fk && ket.indexOf(fk)  < 0) return false;

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
                emptyCustom.innerHTML = '<td colspan="5" class="text-center py-5 text-muted">'
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

    ['dt-search','f-client','f-project','f-lokasi','f-keterangan'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('input', doFilter);
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