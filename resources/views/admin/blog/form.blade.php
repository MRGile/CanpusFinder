@extends('layouts.dashboard')

@php($editing = $article->exists)
@section('title', ($editing ? 'Edit' : 'Tambah').' Artikel - CampusFinder')

@section('content')
<div class="mb-4"><a href="{{ route('admin.blog.index') }}" class="text-decoration-none small"><i class="bi bi-arrow-left me-1"></i>Kembali ke daftar artikel</a><h1 class="h3 fw-bold text-dark mt-2 mb-1">{{ $editing ? 'Edit artikel' : 'Tambah artikel' }}</h1><p class="text-secondary mb-0">Atur judul, kategori, dan tanggal artikel yang ditampilkan di halaman Blog.</p></div>

@if($errors->any())<div class="alert alert-danger"><div class="fw-semibold mb-1">Periksa kembali isian berikut:</div><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

<form method="POST" enctype="multipart/form-data" action="{{ $editing ? route('admin.blog.update', $article) : route('admin.blog.store') }}">
    @csrf
    @if($editing)@method('PUT')@endif
    <div class="card border-0 shadow-sm mb-4"><div class="card-header bg-white border-0 pt-4 px-4"><h2 class="h6 fw-bold mb-1">Informasi artikel</h2><p class="small text-secondary mb-0">Isi informasi yang tampil pada kartu artikel.</p></div>
        <div class="card-body p-4"><div class="row g-3">
            <div class="col-md-8"><label class="form-label" for="title">Judul artikel <span class="text-danger">*</span></label><input class="form-control" id="title" name="title" value="{{ old('title', $article->title) }}" required maxlength="255"></div>
            <div class="col-md-4"><label class="form-label" for="category">Kategori <span class="text-danger">*</span></label><input class="form-control" id="category" name="category" value="{{ old('category', $article->category) }}" required maxlength="255" placeholder="Contoh: Tips Kuliah"></div>
            <div class="col-md-6"><label class="form-label" for="published_at">Tanggal terbit <span class="text-danger">*</span></label><input class="form-control" type="date" id="published_at" name="published_at" value="{{ old('published_at', $article->published_at?->format('Y-m-d')) }}" required></div>
            <div class="col-12"><label class="form-label" for="image">Gambar artikel</label><input class="form-control" type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp"><div class="form-text">Format JPG, PNG, atau WebP. Maksimal 5 MB.</div>
                @if($editing && $article->image_path)<div class="mt-3"><img src="{{ asset('storage/'.$article->image_path) }}" alt="Gambar {{ $article->title }}" style="width:220px;height:130px;object-fit:cover;border-radius:10px;"><div class="form-check mt-2"><input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1"><label class="form-check-label text-danger" for="remove_image">Hapus gambar saat disimpan</label></div></div>@endif
            </div>
        </div></div>
    </div>
    <div class="d-flex justify-content-end gap-2"><a href="{{ route('admin.blog.index') }}" class="btn btn-light border">Batal</a><button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i>{{ $editing ? 'Simpan perubahan' : 'Tambah artikel' }}</button></div>
</form>
@endsection
