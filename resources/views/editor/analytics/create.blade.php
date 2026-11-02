@extends('layouts.editor.app')

@section('title', 'Input Analytics')

@section('content')



{{-- HEADER --}}
<div class="row mb-4">
<div class="col-12">

<div class="card shadow-sm border-0">
<div class="card-body">

<h4 class="mb-2">
<i class="bx bx-line-chart me-2"></i>
Input Content Analytics
</h4>

<p class="text-muted mb-0">
Masukkan performa konten setelah dipublish untuk menghitung
<strong>Engagement Rate (ERP)</strong>.
</p>

</div>
</div>

</div>
</div>


{{-- INFO CONTENT --}}
<div class="row mb-4">

<div class="col-12">

<div class="card border-0 shadow-sm">
<div class="card-body">

<h5 class="mb-3">Informasi Konten</h5>

<div class="row">

<div class="col-md-4">
<strong>Pillar</strong>
<p>{{ $content->pillar }}</p>
</div>

<div class="col-md-4">
<strong>Topic</strong>
<p>{{ $content->topic }}</p>
</div>

<div class="col-md-4">
<strong>Posting Date</strong>
<p>
{{ \Carbon\Carbon::parse($content->posting_date)->format('d M Y') }}
</p>
</div>

</div>

</div>
</div>

</div>

</div>


<form action="{{ route('editor.analytics.store', $content->id) }}" method="POST">
@csrf

<div class="row">

{{-- LEFT FORM --}}
<div class="col-lg-8">

<div class="card shadow-sm border-0">
<div class="card-body">

<h5 class="mb-4">Data Engagement</h5>

<div class="row g-3">

<div class="col-md-6">
<label class="form-label">Platform</label>
<input type="hidden" name="platform" value="instagram">
<input type="text" class="form-control" value="Instagram" readonly>
</div>

<div class="col-md-6">
<label class="form-label">Jam Posting</label>
<input type="number"
name="posting_hour"
class="form-control @error('posting_hour') is-invalid @enderror"
min="0"
max="23"
placeholder="Contoh: 19"
value="{{ old('posting_hour') }}"
required>
@error('posting_hour')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

<div class="col-md-6">
<label class="form-label">Hari Posting</label>
<select name="posting_day" class="form-select" required>

<option value="">Pilih Hari</option>
<option>Monday</option>
<option>Tuesday</option>
<option>Wednesday</option>
<option>Thursday</option>
<option>Friday</option>
<option>Saturday</option>
<option>Sunday</option>

</select>
</div>

<div class="col-md-6">
<label class="form-label">Caption Length</label>
<input type="number"
name="caption_length"
class="form-control"
placeholder="Jumlah karakter caption">
</div>

<div class="col-md-6">
<label class="form-label">Jumlah Hashtag</label>
<input type="number"
name="hashtag_count"
class="form-control"
placeholder="Jumlah hashtag">
</div>

</div>

<hr class="my-4">

<h5 class="mb-4">Performance Metrics</h5>

<div class="row g-3">

<div class="col-md-6">
<label class="form-label">Views</label>
<input type="number"
name="views"
id="views"
class="form-control @error('views') is-invalid @enderror"
value="{{ old('views') }}"
required>
@error('views')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

<div class="col-md-6">
<label class="form-label">Likes</label>
<input type="number"
name="likes"
id="likes"
class="form-control"
required>
</div>

<div class="col-md-6">
<label class="form-label">Comments</label>
<input type="number"
name="comments"
id="comments"
class="form-control"
required>
</div>

<div class="col-md-6">
<label class="form-label">Shares</label>
<input type="number"
name="shares"
id="shares"
class="form-control"
required>
</div>

</div>

</div>
</div>

</div>


{{-- RIGHT PANEL --}}
<div class="col-lg-4">

<div class="card border-0 shadow-sm">

<div class="card-body">

<h5 class="mb-3">
Engagement Preview
</h5>

<div class="text-center">

<h2 class="text-primary" id="erPreview">
0%
</h2>

<p class="text-muted">
Estimated Engagement Rate
</p>

</div>

<hr>

<p class="small text-muted">
Engagement Rate dihitung menggunakan rumus:
</p>

<code>
(likes + comments + shares) / views × 100
</code>

<div class="d-grid mt-4">

<button class="btn btn-primary btn-lg">

<i class="bx bx-save me-1"></i>
Simpan Analytics

</button>

</div>

</div>

</div>

</div>

</div>

</form>



@endsection


@section('scripts')

<script>

function calculateER() {

let views = parseFloat(document.getElementById('views').value) || 0;
let likes = parseFloat(document.getElementById('likes').value) || 0;
let comments = parseFloat(document.getElementById('comments').value) || 0;
let shares = parseFloat(document.getElementById('shares').value) || 0;

if(views > 0){

let er = ((likes + comments + shares) / views) * 100;

document.getElementById('erPreview').innerText = er.toFixed(2) + "%";

}

}

document.querySelectorAll('#views,#likes,#comments,#shares').forEach(input => {

input.addEventListener('keyup', calculateER);

});

</script>

@endsection