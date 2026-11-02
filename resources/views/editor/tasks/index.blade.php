@extends('layouts.editor.app')

@section('title', 'Riwayat Tugas Editor')

@section('content')

<style>
    /* Global Style Fixes */
    .main-content {
        font-size: 14px; /* Standar UI Modern */
        color: #334155;
        background-color: #fbfbfb;
    }
    
    /* Luxury Card Design */
    .card-custom {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        background: #ffffff;
        overflow: hidden;
    }

    /* Symmetric Badges */
    .badge-premium {
        display: inline-block;
        min-width: 100px; /* Membuat badge simetris lebarnya */
        padding: 6px 12px;
        font-weight: 600;
        font-size: 11px;
        border-radius: 8px;
        text-align: center;
    }

    /* Soft Badge Colors */
    .bg-soft-primary { background-color: #eff6ff; color: #2563eb; }
    .bg-soft-success { background-color: #f0fdf4; color: #16a34a; }
    .bg-soft-warning { background-color: #fffbeb; color: #d97706; }
    .bg-soft-danger { background-color: #fef2f2; color: #dc2626; }
    .bg-soft-info { background-color: #f0f9ff; color: #0891b2; }
    .bg-soft-secondary { background-color: #f1f5f9; color: #475569; }

    /* Button Styling */
    .btn-action {
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        padding: 8px 16px;
        transition: 0.3s;
        border: none;
    }
    
    .btn-view { background-color: #f1f5f9; color: #475569; }
    .btn-view:hover { background-color: #e2e8f0; }

    /* Empty State */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    /* Luxury Text Button Styling */
    .btn-action-text {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 85px; /* Lebar minimal agar simetris */
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        transition: all 0.2s ease;
        border: none;
        text-decoration: none !important;
    }
    
    /* Warna Tombol yang Soft & Mewah */
    .btn-view-lux { 
        background-color: #f1f5f9; 
        color: #475569; 
    }
    .btn-view-lux:hover { 
        background-color: #e2e8f0; 
        transform: translateY(-1px);
    }

    .btn-stats-lux { 
        background-color: #eff6ff; 
        color: #2563eb; 
    }
    .btn-stats-lux:hover { 
        background-color: #dbeafe; 
        transform: translateY(-1px);
    }

    .btn-data-lux { 
        background-color: #f0fdf4; 
        color: #16a34a; 
    }
    .btn-data-lux:hover { 
        background-color: #dcfce7; 
        transform: translateY(-1px);
    }

    /* Container tombol agar sejajar di tengah */
    .action-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
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
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.05em;
        color: #64748b;
        padding: 1.25rem 1rem;
        border-bottom: 2px solid #f1f5f9;
        border-top: none;
        cursor: pointer;
        user-select: none;
        white-space: nowrap;
    }
    #myTable thead tr.header-row th:hover { background: #f1f5f9; }
    #myTable thead tr.header-row th.no-sort { cursor: default; }
    #myTable thead tr.header-row th.th-asc::after  { content: ' ↑'; color: #0d6efd; }
    #myTable thead tr.header-row th.th-desc::after { content: ' ↓'; color: #0d6efd; }
    #myTable thead tr.header-row th.th-idle::after { content: ' ⇅'; opacity: .35; }

    /* ── Filter Row ── */
    #myTable thead tr.filter-row th {
        background-color: #f8fafc;
        padding: 5px 1rem 10px;
        border-bottom: 2px solid #f1f5f9;
    }
    #myTable thead tr.filter-row th input,
    #myTable thead tr.filter-row th select {
        width: 100%;
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 5px 8px;
        font-size: 12px;
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
        padding: 1.1rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s;
    }
    #myTable tbody tr:hover td { background-color: #f8fafc; }

    /* ── Footer ── */
    #dt-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 20px 16px;
        flex-wrap: wrap;
        gap: 10px;
        border-top: 1px solid #f1f5f9;
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



            {{-- Header Section --}}
            <div class="row align-items-center mb-4">
                <div class="col-md-6">
                    <h3 class="fw-bold text-dark mb-1">Daftar Riwayat Tugas</h3>
                    <p class="text-muted mb-0">Kelola dan pantau performa konten yang sudah selesai.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-custom">

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
                            <div class="dt-search-wrap" style="display: flex; gap: 8px; align-items: center;">
                                <label for="dt-search" class="mb-0">Cari:</label>
                                <input type="text" id="dt-search" placeholder="Ketik untuk mencari…">
                                <button type="button" class="btn btn-primary ms-2 shadow-sm" data-toggle="modal" data-target="#printModal" data-bs-toggle="modal" data-bs-target="#printModal" onclick="openPrintModalFallback()" style="border-radius: 6px; font-weight: 600; font-size: 13px; padding: 6px 14px; height: 35px; border: none; display: flex; align-items: center; gap: 6px; cursor: pointer;">
                                    <i class="bx bx-printer"></i> Cetak Laporan
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            
                            <div class="table-responsive">
                                <table id="myTable" class="table table-custom mb-0 w-100">
                                    <thead>
                                        <tr class="header-row">
                                            <th class="ps-4 text-center no-sort" width="70">No</th>
                                            <th class="th-idle" data-col="1">Posting Date</th>
                                            <th class="th-idle" data-col="2">Content Detail</th>
                                            <th class="text-center th-idle" data-col="3">Status Task</th>
                                            <th class="text-center th-idle" data-col="4">Review</th>
                                            <th class="text-center pe-4 no-sort">Aksi</th>
                                        </tr>
                                        <tr class="filter-row">
                                            <th></th>
                                            <th><input type="text" id="f-date" placeholder="Filter tanggal…"></th>
                                            <th><input type="text" id="f-detail" placeholder="Filter detail…"></th>
                                            <th>
                                                <select id="f-status">
                                                    <option value="">Semua Status</option>
                                                    <option>ON PROGRESS</option>
                                                    <option>REVISION</option>
                                                    <option>DONE</option>
                                                    <option>PUBLISHED</option>
                                                </select>
                                            </th>
                                            <th>
                                                <select id="f-review">
                                                    <option value="">Semua</option>
                                                    <option>PENDING</option>
                                                    <option>APPROVED</option>
                                                    <option>REVISION</option>
                                                </select>
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTbody">
                                        @forelse($tasks as $task)
                                        @php
                                            $statusClass = match($task->status) {
                                                'on_progress' => 'bg-soft-warning',
                                                'revision' => 'bg-soft-danger',
                                                'done' => 'bg-soft-info',
                                                'published' => 'bg-soft-success',
                                                default => 'bg-soft-secondary'
                                            };
                                        @endphp
                                        <tr>
                                            <td class="text-center ps-4 text-muted fw-bold">
                                                {{ $loop->iteration }}
                                            </td>

                                            <td class="fw-medium text-dark">
                                                <i class="bx bx-calendar me-1 text-muted"></i>
                                                {{ \Carbon\Carbon::parse($task->posting_date)->format('d M, Y') }}
                                            </td>

                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold text-dark mb-1">{{ $task->topic }}</span>
                                                    <span class="text-muted small">{{ $task->pillar }}</span>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge-premium {{ $statusClass }}">
                                                    {{ strtoupper(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                @if(is_null($task->approved))
                                                    <span class="badge-premium bg-soft-secondary">PENDING</span>
                                                @elseif($task->approved)
                                                    <span class="badge-premium bg-soft-success">APPROVED</span>
                                                @else
                                                    <span class="badge-premium bg-soft-danger">REVISION</span>
                                                @endif
                                            </td>

                                            <td class="text-center pe-4">
                                                <div class="action-container">
                                                    {{-- Tombol Detail --}}
                                                    <a href="{{ route('editor.tasks.show', $task->id) }}" 
                                                       class="btn-action-text btn-view-lux">
                                                       DETAIL 
                                                    </a>
                                            
                                                    @if($task->status == 'published')
                                                        @if(!$task->analytics)
                                                            {{-- Tombol Input Stats --}}
                                                            <a href="{{ route('editor.analytics.create', $task->id) }}" 
                                                               class="btn-action-text btn-stats-lux">
                                                               Input 
                                                            </a>
                                                        @else
                                                            {{-- Tombol View Data --}}
                                                            <a href="{{ route('editor.analytics.show', $task->id) }}" 
                                                               class="btn-action-text btn-data-lux">
                                                               Analytics
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr id="empty-original">
                                            <td colspan="6">
                                                <div class="empty-state">
                                                    <i class="bx bx-box text-muted mb-3" style="font-size: 3rem;"></i>
                                                    <h6 class="text-dark fw-bold">Belum Ada Data</h6>
                                                    <p class="text-muted mx-auto" style="max-width: 300px;">
                                                        Data riwayat tugas Anda akan muncul di sini setelah tugas diselesaikan.
                                                    </p>
                                                </div>
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



<!-- Print Modal -->
<div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog modal-dialog-centered" style="z-index: 10000;">
    <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold text-dark" id="printModalLabel">Cetak Laporan Mingguan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('editor.tasks.report') }}" method="GET" target="_blank">
          <div class="modal-body py-4">
              <p class="text-muted small mb-4">Pilih rentang tanggal publish konten untuk mencetak laporan engagement.</p>
              <div class="mb-3">
                  <label for="start_date" class="form-label fw-semibold text-secondary small">Tanggal Mulai (Start Date)</label>
                  <input type="date" class="form-control" id="start_date" name="start_date" required style="border-radius: 8px;">
              </div>
              <div class="mb-2">
                  <label for="end_date" class="form-label fw-semibold text-secondary small">Tanggal Akhir (End Date)</label>
                  <input type="date" class="form-control" id="end_date" name="end_date" required style="border-radius: 8px;">
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Batal</button>
            <button type="submit" class="btn btn-primary px-4" style="border-radius: 8px; font-weight: 600;">
                <i class="bx bx-printer me-1"></i> Cetak PDF
            </button>
          </div>
      </form>
    </div>
  </div>
</div>

<script>
function openPrintModalFallback() {
    try {
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            var myModal = new bootstrap.Modal(document.getElementById('printModal'));
            myModal.show();
        } else if (typeof $ !== 'undefined') {
            $('#printModal').modal('show');
        }
    } catch(e) {
        console.error("Modal error:", e);
    }
}

document.addEventListener('DOMContentLoaded', function () {

    var tbody   = document.getElementById('myTbody');
    var allRows = Array.from(tbody.querySelectorAll('tr')).filter(function(r) {
        return !r.querySelector('td[colspan]') && r.id !== 'empty-original';
    });

    var pageLen  = 10;
    var curPage  = 1;
    var sortCol  = 1; // Default sort by date
    var sortDir  = 'desc';
    var filtered = allRows.slice();

    function cell(row, i) {
        var td = row.querySelectorAll('td')[i];
        return td ? td.innerText.trim() : '';
    }

    function parseDate(s) {
        // Hapus teks tambahan seperti icon jika ada
        var dateStr = s.replace('bx bx-calendar me-1 text-muted', '').trim();
        var mo = {Jan:0,Feb:1,Mar:2,Apr:3,Mei:4,Jun:5,Jul:6,Agu:7,Sep:8,Okt:9,Nov:10,Des:11};
        var p = dateStr.replace(',', '').split(' '); 
        // format: 04 Mar 2026
        return new Date(+p[2], mo[p[1]] !== undefined ? mo[p[1]] : 0, +p[0]);
    }

    function doFilter() {
        var gs = document.getElementById('dt-search').value.toLowerCase();
        var fd = document.getElementById('f-date').value.toLowerCase();
        var fdt = document.getElementById('f-detail').value.toLowerCase();
        var fs = document.getElementById('f-status').value.toLowerCase();
        var fr = document.getElementById('f-review').value.toLowerCase();

        filtered = allRows.filter(function(row) {
            var tds  = row.querySelectorAll('td');
            var date = (tds[1]||{innerText:''}).innerText.toLowerCase();
            var detail  = (tds[2]||{innerText:''}).innerText.toLowerCase();
            var sta  = (tds[3]||{innerText:''}).innerText.toLowerCase();
            var rev  = (tds[4]||{innerText:''}).innerText.toLowerCase();

            if (fd && date.indexOf(fd) < 0) return false;
            if (fdt && detail.indexOf(fdt)  < 0) return false;
            if (fs && sta.indexOf(fs)  < 0) return false;
            if (fr && rev.indexOf(fr)  < 0) return false;

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
            if (sortCol === 1) { // Posting Date
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
                emptyCustom.innerHTML = '<td colspan="6">'
                    + '<div class="empty-state"><i class="bx bx-search text-muted mb-3" style="font-size: 3rem;"></i>'
                    + '<h6 class="text-dark fw-bold">Tidak ditemukan data yang cocok</h6></div></td>';
                tbody.appendChild(emptyCustom);
            }
            emptyCustom.style.display = '';
        } else {
            if (emptyRow)    emptyRow.style.display = 'none';
            if (emptyCustom) emptyCustom.style.display = 'none';
            
            // Render visible rows and update index numbers
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

    ['dt-search','f-date','f-detail'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('input', doFilter);
    });
    ['f-status', 'f-review'].forEach(function(id) {
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