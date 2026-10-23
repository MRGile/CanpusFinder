@extends('layouts.dashboard')

@section('title', 'Kelola Beasiswa - CampusFinder')

@section('content')
<div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
    <div><span class="small text-uppercase text-primary fw-bold">Administrasi katalog</span><h1 class="h3 fw-bold text-dark mt-1 mb-1">Beasiswa</h1><p class="text-secondary mb-0">Kelola informasi beasiswa yang tampil di katalog publik.</p></div>
    <a href="{{ route('admin.beasiswa.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah Beasiswa</a>
</div>

@if(session('status'))<div class="alert alert-success" role="status"><i class="bi bi-check-circle me-2"></i>{{ session('status') }}</div>@endif

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-4 px-4"><h2 class="h6 fw-bold mb-1">Daftar beasiswa</h2><p class="small text-secondary mb-0">{{ $scholarships->total() }} data terdaftar</p></div>
    <div class="card-body p-0"><div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th class="px-4 py-3">Beasiswa</th><th class="py-3">Jenis / Jenjang</th><th class="py-3">Nominal</th><th class="py-3">Batas waktu</th><th class="py-3 text-end px-4">Aksi</th></tr></thead>
            <tbody>
                @forelse($scholarships as $scholarship)
                <tr>
                    <td class="px-4"><div class="fw-semibold text-dark">{{ $scholarship->name }}</div><div class="small text-secondary">{{ $scholarship->provider }}</div></td>
                    <td><span class="badge rounded-pill text-bg-light border">{{ $scholarship->scholarship_type }}</span><div class="small text-secondary mt-1">{{ $scholarship->study_level }}</div></td>
                    <td class="fw-semibold">{{ $scholarship->amount }}</td><td>{{ $scholarship->deadline?->format('d/m/Y') ?? 'Tanggal belum diatur' }}</td>
                    <td class="text-end px-4"><div class="d-inline-flex gap-2"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.beasiswa.edit', $scholarship) }}"><i class="bi bi-pencil me-1"></i>Edit</a><form method="POST" action="{{ route('admin.beasiswa.destroy', $scholarship) }}" onsubmit="return confirm('Hapus beasiswa ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" type="submit"><i class="bi bi-trash"></i></button></form></div></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-5"><div class="text-secondary mb-3"><i class="bi bi-mortarboard fs-2"></i></div><h3 class="h6 fw-bold">Belum ada beasiswa</h3><p class="small text-secondary mb-3">Tambahkan data beasiswa agar tampil di katalog publik.</p><a href="{{ route('admin.beasiswa.create') }}" class="btn btn-sm btn-primary">Tambah beasiswa</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div></div>
    @if($scholarships->hasPages())<div class="card-footer bg-white border-0 px-4 py-3">{{ $scholarships->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
