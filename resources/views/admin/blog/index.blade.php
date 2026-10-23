@extends('layouts.dashboard')

@section('title', 'Kelola Blog - CampusFinder')

@section('content')
<div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
    <div><span class="small text-uppercase text-primary fw-bold">Administrasi konten</span><h1 class="h3 fw-bold text-dark mt-1 mb-1">Blog</h1><p class="text-secondary mb-0">Kelola artikel yang tampil di halaman Blog.</p></div>
    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah Artikel</a>
</div>

@if(session('status'))<div class="alert alert-success" role="status"><i class="bi bi-check-circle me-2"></i>{{ session('status') }}</div>@endif

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-4 px-4"><h2 class="h6 fw-bold mb-1">Daftar artikel</h2><p class="small text-secondary mb-0">{{ $articles->total() }} artikel</p></div>
    <div class="card-body p-0"><div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th class="px-4 py-3">Artikel</th><th class="py-3">Kategori</th><th class="py-3">Tanggal terbit</th><th class="py-3 text-end px-4">Aksi</th></tr></thead>
            <tbody>
                @forelse($articles as $article)
                <tr>
                    <td class="px-4">@if($article->image_path)<img src="{{ asset('storage/'.$article->image_path) }}" alt="" class="rounded me-2" style="width:56px;height:40px;object-fit:cover;">@endif<span class="fw-semibold text-dark">{{ $article->title }}</span></td>
                    <td><span class="badge rounded-pill text-bg-light border">{{ $article->category }}</span></td>
                    <td>{{ $article->published_at?->translatedFormat('d F Y') }}</td>
                    <td class="text-end px-4"><div class="d-inline-flex gap-2"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.blog.edit', $article) }}"><i class="bi bi-pencil me-1"></i>Edit</a><form method="POST" action="{{ route('admin.blog.destroy', $article) }}" onsubmit="return confirm('Hapus artikel ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" type="submit" aria-label="Hapus artikel"><i class="bi bi-trash"></i></button></form></div></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-5"><div class="text-secondary mb-3"><i class="bi bi-journal-text fs-2"></i></div><h3 class="h6 fw-bold">Belum ada artikel</h3><p class="small text-secondary mb-3">Tambahkan artikel agar tampil di halaman Blog.</p><a href="{{ route('admin.blog.create') }}" class="btn btn-sm btn-primary">Tambah artikel</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div></div>
    @if($articles->hasPages())<div class="card-footer bg-white border-0 px-4 py-3">{{ $articles->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
