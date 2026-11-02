@if ($errors->any())
    <div class="alert alert-danger alert-dismissible d-flex align-items-center fade show shadow-sm" role="alert">
        <i class="bx bxs-error-circle" style="font-size: 1.5em; line-height: 1;"></i>
        <div class="mx-2 flex-grow-1">
            <strong>Validasi Gagal!</strong><br>
            {!! implode('<br>', $errors->all()) !!}
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="background: transparent; border: none; font-size: 1.5rem; line-height: 1; padding: 0; opacity: .5; margin-left: auto;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible d-flex align-items-center fade show shadow-sm" role="alert">
        <i class="bx bxs-check-circle" style="font-size: 1.5em; line-height: 1;"></i>
        <div class="mx-2 flex-grow-1">
            <strong>Berhasil!</strong> {!! session('success') !!}
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="background: transparent; border: none; font-size: 1.5rem; line-height: 1; padding: 0; opacity: .5; margin-left: auto;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible d-flex align-items-center fade show shadow-sm" role="alert">
        <i class="bx bxs-error-circle" style="font-size: 1.5em; line-height: 1;"></i>
        <div class="mx-2 flex-grow-1">
            <strong>Error!</strong> {!! session('error') !!}
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="background: transparent; border: none; font-size: 1.5rem; line-height: 1; padding: 0; opacity: .5; margin-left: auto;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning alert-dismissible d-flex align-items-center fade show shadow-sm" role="alert">
        <i class="bx bxs-error" style="font-size: 1.5em; line-height: 1;"></i>
        <div class="mx-2 flex-grow-1">
            <strong>Peringatan!</strong> {!! session('warning') !!}
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="background: transparent; border: none; font-size: 1.5rem; line-height: 1; padding: 0; opacity: .5; margin-left: auto;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info alert-dismissible d-flex align-items-center fade show shadow-sm" role="alert">
        <i class="bx bxs-info-circle" style="font-size: 1.5em; line-height: 1;"></i>
        <div class="mx-2 flex-grow-1">
            <strong>Info!</strong> {!! session('info') !!}
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="background: transparent; border: none; font-size: 1.5rem; line-height: 1; padding: 0; opacity: .5; margin-left: auto;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
