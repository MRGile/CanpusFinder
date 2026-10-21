@extends('layouts.dashboard')

@section('title', ($faculty->exists ? 'Edit' : 'Tambah').' Fakultas - CampusFinder')
@php($activeMenu = 'admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.universitas.fakultas.index', $campus) }}" class="text-decoration-none small fw-semibold"><i class="bi bi-arrow-left me-1"></i>Kembali ke daftar fakultas</a>
    <h1 class="h3 fw-bold text-dark mt-2 mb-1">{{ $faculty->exists ? 'Edit Fakultas' : 'Tambah Fakultas' }}</h1>
    <p class="text-secondary mb-0">Informasi fakultas di <strong>{{ $campus->name }}</strong></p>
</div>

<form method="POST" action="{{ $faculty->exists ? route('admin.universitas.fakultas.update', [$campus, $faculty]) : route('admin.universitas.fakultas.store', $campus) }}">
    @csrf @if($faculty->exists) @method('PUT') @endif
    @if($errors->any())<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}</div>@endif
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom py-3"><h2 class="h6 fw-bold mb-1"><i class="bi bi-diagram-3 me-2 text-primary"></i>Informasi fakultas</h2><p class="small text-secondary mb-0">Nama, pimpinan, kontak, dan ringkasan fakultas.</p></div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-8"><label for="name" class="form-label">Nama fakultas <span class="text-danger">*</span></label><input id="name" name="name" class="form-control" value="{{ old('name', $faculty->name) }}" required maxlength="255" placeholder="Fakultas Teknik"></div>
                <div class="col-md-4"><label for="dean" class="form-label">Dekan</label><input id="dean" name="dean" class="form-control" value="{{ old('dean', $faculty->dean) }}" maxlength="255" placeholder="Nama dekan"></div>
                <div class="col-md-6"><label for="email" class="form-label">Email fakultas</label><input id="email" name="email" type="email" class="form-control" value="{{ old('email', $faculty->email) }}" maxlength="255" placeholder="sekretariat@universitas.ac.id"></div>
                <div class="col-md-6"><label for="phone" class="form-label">Telepon</label><input id="phone" name="phone" type="tel" class="form-control" value="{{ old('phone', $faculty->phone) }}" maxlength="40" placeholder="(021) 12345678"></div>
                <div class="col-12"><label for="website" class="form-label">Situs web fakultas</label><input id="website" name="website" type="url" class="form-control" value="{{ old('website', $faculty->website) }}" maxlength="255" placeholder="https://teknik.universitas.ac.id"></div>
                <div class="col-12"><label for="description" class="form-label">Deskripsi</label><textarea id="description" name="description" class="form-control" rows="5" maxlength="2000" placeholder="Gambaran fakultas dan bidang yang dinaungi">{{ old('description', $faculty->description) }}</textarea><div class="form-text">Maksimal 2.000 karakter.</div></div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end gap-2 mb-4"><a href="{{ route('admin.universitas.fakultas.index', $campus) }}" class="btn btn-outline-secondary">Batal</a><button type="submit" class="btn btn-primary px-4"><i class="bi bi-check2-circle me-2"></i>Simpan Fakultas</button></div>
</form>
@endsection
