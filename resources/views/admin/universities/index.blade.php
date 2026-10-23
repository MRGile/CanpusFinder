@extends('layouts.dashboard')

@section('title', 'Kelola Universitas - CampusFinder')
@php($activeMenu = 'admin')

@section('content')
<div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
    <div><span class="small text-uppercase text-primary fw-bold">Administrasi katalog</span><h1 class="h3 fw-bold text-dark mt-1 mb-1">Universitas</h1><p class="text-secondary mb-0">Atur profil universitas dan fakultas yang tampil di katalog.</p></div>
    <a href="{{ route('admin.universitas.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah Universitas</a>
</div>

@if(session('status'))<div class="alert alert-success" role="status"><i class="bi bi-check-circle me-2"></i>{{ session('status') }}</div>@endif

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-4 px-4"><h2 class="h6 fw-bold mb-1">Daftar universitas</h2><p class="small text-secondary mb-0">{{ $campuses->total() }} data terdaftar</p></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr><th class="px-4 py-3">Universitas</th><th class="py-3">Lokasi</th><th class="py-3">Jenis</th><th class="py-3">Akademik</th><th class="py-3 text-center">Fakultas</th><th class="py-3 text-end px-4">Aksi</th></tr></thead>
                <tbody>
                    @forelse($campuses as $campus)
                    <tr>
                        <td class="px-4"><div class="d-flex align-items-center gap-3">@if($campus->logo_path)<img src="{{ asset('storage/'.$campus->logo_path) }}" alt="Logo {{ $campus->name }}" class="rounded-3 border bg-white p-1" style="width:48px;height:42px;object-fit:contain;">@elseif($campus->image_path)<img src="{{ asset('storage/'.$campus->image_path) }}" alt="" class="rounded-3 border" style="width:48px;height:42px;object-fit:cover;">@else<span class="d-inline-flex align-items-center justify-content-center rounded-3 bg-primary-subtle text-primary fw-bold" style="width:48px;height:42px;">{{ $campus->abbreviation }}</span>@endif<div><div class="fw-semibold text-dark">{{ $campus->name }}</div><div class="small text-secondary">{{ $campus->program_count }} program studi</div></div></div></td>
                        <td>{{ $campus->city }}{{ $campus->province ? ', '.$campus->province : '' }}</td>
                        <td><span class="badge rounded-pill text-bg-light border">{{ $campus->type }}</span></td>
                        <td><div class="small"><span class="fw-semibold">{{ $campus->accreditation }}</span> akreditasi</div><div class="small text-secondary">{{ $campus->founded_year ?: 'Tahun berdiri belum diisi' }}</div></td>
                        <td class="text-center"><span class="badge rounded-pill text-bg-primary">{{ $campus->faculties_count }}</span></td>
                        <td class="text-end px-4"><div class="dropdown"><button class="btn btn-sm btn-light border" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Aksi untuk {{ $campus->name }}"><i class="bi bi-three-dots"></i></button><ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="{{ route('admin.universitas.konten.index', $campus) }}"><i class="bi bi-card-list me-2"></i>Kelola detail</a></li><li><a class="dropdown-item" href="{{ route('admin.universitas.fakultas.index', $campus) }}"><i class="bi bi-diagram-3 me-2"></i>Kelola fakultas</a></li><li><a class="dropdown-item" href="{{ route('admin.universitas.edit', $campus) }}"><i class="bi bi-pencil me-2"></i>Edit universitas</a></li><li><hr class="dropdown-divider"></li><li><form method="POST" action="{{ route('admin.universitas.destroy', $campus) }}" onsubmit="return confirm('Hapus universitas ini beserta daftar fakultasnya?')">@csrf @method('DELETE')<button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Hapus</button></form></li></ul></div></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-5"><div class="text-secondary mb-3"><i class="bi bi-building fs-2"></i></div><h3 class="h6 fw-bold">Belum ada universitas</h3><p class="small text-secondary mb-3">Tambahkan universitas untuk mulai melengkapi katalog.</p><a href="{{ route('admin.universitas.create') }}" class="btn btn-sm btn-primary">Tambah universitas</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($campuses->hasPages())<div class="card-footer bg-white border-0 px-4 py-3">{{ $campuses->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
