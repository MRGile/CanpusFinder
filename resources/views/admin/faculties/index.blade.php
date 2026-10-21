@extends('layouts.dashboard')

@section('title', 'Fakultas '.$campus->name.' - CampusFinder')
@php($activeMenu = 'admin')

@section('content')
<div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
    <div><a href="{{ route('admin.universitas.index') }}" class="text-decoration-none small fw-semibold"><i class="bi bi-arrow-left me-1"></i>Semua universitas</a><h1 class="h3 fw-bold text-dark mt-2 mb-1">Fakultas</h1><p class="text-secondary mb-0">{{ $campus->name }}{{ $campus->province ? ' · '.$campus->province : ' · '.$campus->city }}</p></div>
    <a href="{{ route('admin.universitas.fakultas.create', $campus) }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah Fakultas</a>
</div>
@if(session('status'))<div class="alert alert-success" role="status"><i class="bi bi-check-circle me-2"></i>{{ session('status') }}</div>@endif
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-4 px-4"><h2 class="h6 fw-bold mb-1">Fakultas di {{ $campus->abbreviation }}</h2><p class="small text-secondary mb-0">{{ $faculties->total() }} fakultas terdaftar</p></div>
    <div class="card-body p-0"><div class="table-responsive"><table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th class="px-4 py-3">Nama Fakultas</th><th class="py-3">Dekan</th><th class="py-3">Kontak</th><th class="py-3">Deskripsi</th><th class="py-3 text-end px-4">Aksi</th></tr></thead>
        <tbody>@forelse($faculties as $faculty)<tr><td class="px-4 fw-semibold">{{ $faculty->name }}</td><td>{{ $faculty->dean ?: '—' }}</td><td><div class="small">{{ $faculty->email ?: '—' }}</div>@if($faculty->website)<a class="small text-decoration-none" href="{{ $faculty->website }}" target="_blank" rel="noopener">Situs web <i class="bi bi-box-arrow-up-right ms-1"></i></a>@endif</td><td class="text-secondary small" style="max-width:280px;">{{ $faculty->description ? Str::limit($faculty->description, 100) : '—' }}</td><td class="text-end px-4"><div class="d-inline-flex gap-2"><a href="{{ route('admin.universitas.fakultas.edit', [$campus, $faculty]) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Edit</a><form method="POST" action="{{ route('admin.universitas.fakultas.destroy', [$campus, $faculty]) }}" onsubmit="return confirm('Hapus fakultas ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Hapus {{ $faculty->name }}"><i class="bi bi-trash"></i></button></form></div></td></tr>
        @empty<tr><td colspan="5" class="text-center py-5"><div class="text-secondary mb-3"><i class="bi bi-diagram-3 fs-2"></i></div><h3 class="h6 fw-bold">Belum ada fakultas</h3><p class="small text-secondary mb-3">Tambahkan fakultas di universitas ini.</p><a href="{{ route('admin.universitas.fakultas.create', $campus) }}" class="btn btn-sm btn-primary">Tambah fakultas</a></td></tr>@endforelse</tbody>
    </table></div></div>
    @if($faculties->hasPages())<div class="card-footer bg-white border-0 px-4 py-3">{{ $faculties->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
