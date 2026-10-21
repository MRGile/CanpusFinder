@extends('layouts.dashboard')

@section('title', 'Konten '.$campus->name.' - CampusFinder')
@php($activeMenu = 'admin')

@section('content')
<div class="mb-4"><a href="{{ route('admin.universitas.index') }}" class="text-decoration-none small fw-semibold"><i class="bi bi-arrow-left me-1"></i>Kembali ke universitas</a><h1 class="h3 fw-bold mt-2 mb-1">Konten {{ $campus->name }}</h1><p class="text-secondary mb-0">Kelola informasi yang ditampilkan pada tab detail kampus.</p></div>
@if(session('status'))<div class="alert alert-success" role="status">{{ session('status') }}</div>@endif
<div class="alert alert-info border-0"><i class="bi bi-info-circle me-2"></i>Data di sini tampil langsung pada halaman kampus. Bagian tanpa data akan menunjukkan keterangan bahwa informasinya belum tersedia.</div>

<div class="row g-4">
    @foreach($types as $kind => $label)
    <div class="col-12">
        <section class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 px-4"><div class="d-flex align-items-center justify-content-between gap-2"><div><h2 class="h6 fw-bold mb-1">{{ $label }}</h2><p class="small text-secondary mb-0">{{ $content->get($kind, collect())->count() }} data</p></div><span class="badge text-bg-light border">{{ $campus->abbreviation }}</span></div></div>
            <div class="card-body px-4">
                <form method="POST" action="{{ route('admin.universitas.konten.store', $campus) }}" class="border rounded-3 p-3 p-md-4 mb-4 bg-light-subtle">
                    @csrf<input type="hidden" name="kind" value="{{ $kind }}">
                    <h3 class="small fw-bold mb-3">Tambah {{ strtolower($label) }}</h3>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label" for="{{ $kind }}-title">Nama / judul</label><input class="form-control" id="{{ $kind }}-title" name="title" required maxlength="255" placeholder="{{ $kind === 'program' ? 'Contoh: Teknik Informatika' : $label }}"></div>
                        <div class="col-md-3"><label class="form-label" for="{{ $kind }}-subtitle">Keterangan singkat</label><input class="form-control" id="{{ $kind }}-subtitle" name="subtitle" maxlength="255" placeholder="{{ $kind === 'program' ? 'S1 · Fakultas Teknik' : ($kind === 'cost' ? 'Biaya per semester' : 'Opsional') }}"></div>
                        <div class="col-md-3"><label class="form-label" for="{{ $kind }}-value">Nilai / nominal</label><input class="form-control" id="{{ $kind }}-value" name="value" maxlength="255" placeholder="{{ $kind === 'cost' ? 'Rp 500.000–7.500.000' : 'Opsional' }}"></div>
                        <div class="col-md-9"><label class="form-label" for="{{ $kind }}-description">Deskripsi</label><textarea class="form-control" id="{{ $kind }}-description" name="description" rows="2" maxlength="5000" placeholder="Detail informasi untuk calon mahasiswa"></textarea></div>
                        <div class="col-md-3"><label class="form-label" for="{{ $kind }}-order">Urutan tampil</label><input class="form-control" id="{{ $kind }}-order" name="sort_order" type="number" min="0" max="10000" value="0"></div>
                    </div>
                    <div class="text-end mt-3"><button class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah</button></div>
                </form>

                @forelse($content->get($kind, collect()) as $item)
                <form method="POST" action="{{ route('admin.universitas.konten.update', [$campus, $item]) }}" class="border rounded-3 p-3 p-md-4 mb-3">
                    @csrf @method('PUT')<input type="hidden" name="kind" value="{{ $kind }}">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label" for="{{ $kind }}-title-{{ $item->id }}">Nama / judul</label><input class="form-control" id="{{ $kind }}-title-{{ $item->id }}" name="title" value="{{ $item->title }}" required maxlength="255"></div>
                        <div class="col-md-3"><label class="form-label">Keterangan singkat</label><input class="form-control" name="subtitle" value="{{ $item->subtitle }}" maxlength="255"></div>
                        <div class="col-md-3"><label class="form-label">Nilai / nominal</label><input class="form-control" name="value" value="{{ $item->value }}" maxlength="255"></div>
                        <div class="col-md-9"><label class="form-label">Deskripsi</label><textarea class="form-control" name="description" rows="2" maxlength="5000">{{ $item->description }}</textarea></div>
                        <div class="col-md-3"><label class="form-label">Urutan tampil</label><input class="form-control" name="sort_order" type="number" min="0" max="10000" value="{{ $item->sort_order }}"></div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-3"><button form="delete-content-{{ $item->id }}" class="btn btn-outline-danger btn-sm" type="submit">Hapus</button><button class="btn btn-outline-primary btn-sm" type="submit">Simpan perubahan</button></div>
                </form>
                <form id="delete-content-{{ $item->id }}" method="POST" action="{{ route('admin.universitas.konten.destroy', [$campus, $item]) }}" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')</form>
                @empty
                <div class="text-center border rounded-3 py-4 text-secondary small">Belum ada data {{ strtolower($label) }}. Bagian ini belum akan muncul sebagai informasi di halaman kampus.</div>
                @endforelse
            </div>
        </section>
    </div>
    @endforeach
</div>
<div class="alert alert-light border mt-4 small"><i class="bi bi-chat-square-text me-2 text-primary"></i>Ulasan berasal dari pengguna yang masuk. Ulasan ditampilkan di tab Ulasan setelah dikirim.</div>
@endsection
