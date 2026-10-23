@extends('layouts.dashboard')

@section('title', 'Konten '.$campus->name.' - CampusFinder')
@php($activeMenu = 'admin')

@section('content')
<div class="mb-4"><a href="{{ route('admin.universitas.index') }}" class="text-decoration-none small fw-semibold"><i class="bi bi-arrow-left me-1"></i>Kembali ke universitas</a><h1 class="h3 fw-bold mt-2 mb-1">Konten {{ $campus->name }}</h1><p class="text-secondary mb-0">Kelola informasi yang ditampilkan pada tab detail kampus.</p></div>
@if(session('status'))<div class="alert alert-success" role="status">{{ session('status') }}</div>@endif
@if($errors->any())<div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>@endif
<div class="alert alert-info border-0"><i class="bi bi-info-circle me-2"></i>Data di sini tampil langsung pada halaman kampus. Bagian tanpa data akan menunjukkan keterangan bahwa informasinya belum tersedia.</div>

<div class="accordion d-flex flex-column gap-3" id="campusContentSections">
    @foreach($types as $kind => $label)
    @php($sectionId = 'campus-content-'.$campus->id.'-'.$kind)
    <section class="accordion-item card border-0 shadow-sm overflow-hidden">
        <h2 class="accordion-header" id="heading-{{ $sectionId }}">
            <button class="accordion-button {{ $kind === 'program' ? '' : 'collapsed' }} bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $sectionId }}" aria-expanded="{{ $kind === 'program' ? 'true' : 'false' }}" aria-controls="{{ $sectionId }}">
                <span class="d-flex align-items-center justify-content-between gap-3 w-100 pe-2"><span><span class="d-block fw-bold text-dark">{{ $label }}</span><span class="d-block small text-secondary mt-1">{{ $content->get($kind, collect())->count() }} data · {{ $campus->abbreviation }}</span></span><i class="bi {{ $kind === 'program' ? 'bi-mortarboard' : 'bi-chevron-down' }} text-primary me-2"></i></span>
            </button>
        </h2>
        <div id="{{ $sectionId }}" class="accordion-collapse collapse {{ $kind === 'program' ? 'show' : '' }}" aria-labelledby="heading-{{ $sectionId }}" data-bs-parent="#campusContentSections">
            <div class="accordion-body px-4">
                <form method="POST" action="{{ route('admin.universitas.konten.store', $campus) }}" class="border rounded-3 p-3 p-md-4 mb-4 bg-light-subtle">
                    @csrf<input type="hidden" name="kind" value="{{ $kind }}">
                    <h3 class="small fw-bold mb-3">Tambah {{ strtolower($label) }}</h3>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label" for="{{ $kind }}-title">Nama / judul</label>
                            @if($kind === 'program')
                            @php($customTitleWasSubmitted = old('title') === '__new' || (old('title') && !$programOptions->contains(old('title'))))
                            <select class="form-select" id="program-title-select" name="title" required><option value="">Pilih program studi</option>@foreach($programOptions as $programOption)<option value="{{ $programOption }}" @selected(!$customTitleWasSubmitted && old('title') === $programOption)>{{ $programOption }}</option>@endforeach<option value="__new" @selected($customTitleWasSubmitted)>+ Tambah nama program studi baru</option></select>
                            <div class="form-text">Daftar diambil dari program studi yang sudah ditambahkan di universitas lain.</div>
                            <input class="form-control mt-2" id="program-title-custom" name="title_custom" value="{{ old('title_custom', $customTitleWasSubmitted && old('title') !== '__new' ? old('title') : '') }}" maxlength="255" placeholder="Nama program studi baru" @if(!$customTitleWasSubmitted) style="display:none" @endif>
                            @else
                            <input class="form-control" id="{{ $kind }}-title" name="title" required maxlength="255" placeholder="{{ $label }}">
                            @endif
                        </div>
                        <div class="col-md-3"><label class="form-label" for="{{ $kind }}-subtitle">Keterangan singkat</label>
                            @if($kind === 'program')
                            <input class="form-control" id="program-subtitle" name="subtitle" value="{{ old('subtitle') }}" maxlength="255" placeholder="Informasi tambahan (opsional)">
                            @else
                            <input class="form-control" id="{{ $kind }}-subtitle" name="subtitle" maxlength="255" placeholder="{{ $kind === 'cost' ? 'Biaya per semester' : 'Opsional' }}">
                            @endif
                        </div>
                        <div class="col-md-3"><label class="form-label" for="{{ $kind }}-value">Nilai / nominal</label><input class="form-control" id="{{ $kind }}-value" name="value" maxlength="255" placeholder="{{ $kind === 'cost' ? 'Rp 500.000–7.500.000' : 'Opsional' }}"></div>
                        @if($kind === 'program')
                        <div class="col-md-3"><label class="form-label" for="program-study-level">Jenjang</label><select class="form-select" id="program-study-level" name="study_level"><option value="">Pilih jenjang</option>@foreach(['D1','D2','D3','D4','S1','S2','S3','Profesi'] as $level)<option value="{{ $level }}" @selected(old('study_level') === $level)>{{ $level }}</option>@endforeach</select></div>
                        <div class="col-md-3"><label class="form-label" for="program-faculty">Fakultas</label><select class="form-select" id="program-faculty" name="faculty_id"><option value="">Pilih fakultas (opsional)</option>@foreach($faculties as $faculty)<option value="{{ $faculty->id }}" @selected((string) old('faculty_id') === (string) $faculty->id)>{{ $faculty->name }}</option>@endforeach</select>@if($faculties->isEmpty())<div class="form-text">Tambahkan fakultas universitas ini terlebih dahulu.</div>@endif</div>
                        @endif
                        <div class="col-12"><label class="form-label" for="{{ $kind }}-description">Deskripsi</label><textarea class="form-control" id="{{ $kind }}-description" name="description" rows="2" maxlength="5000" placeholder="Detail informasi untuk calon mahasiswa"></textarea></div>
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
                        @if($kind === 'program')
                        <div class="col-md-3"><label class="form-label" for="study-level-{{ $item->id }}">Jenjang</label><select class="form-select" id="study-level-{{ $item->id }}" name="study_level"><option value="">Pilih jenjang</option>@foreach(['D1','D2','D3','D4','S1','S2','S3','Profesi'] as $level)<option value="{{ $level }}" @selected($item->study_level === $level)>{{ $level }}</option>@endforeach</select></div>
                        <div class="col-md-3"><label class="form-label" for="faculty-{{ $item->id }}">Fakultas</label><select class="form-select" id="faculty-{{ $item->id }}" name="faculty_id"><option value="">Pilih fakultas (opsional)</option>@foreach($faculties as $faculty)<option value="{{ $faculty->id }}" @selected((string) $item->faculty_id === (string) $faculty->id)>{{ $faculty->name }}</option>@endforeach</select></div>
                        @endif
                        <div class="col-12"><label class="form-label">Deskripsi</label><textarea class="form-control" name="description" rows="2" maxlength="5000">{{ $item->description }}</textarea></div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-3"><button form="delete-content-{{ $item->id }}" class="btn btn-outline-danger btn-sm" type="submit">Hapus</button><button class="btn btn-outline-primary btn-sm" type="submit">Simpan perubahan</button></div>
                </form>
                <form id="delete-content-{{ $item->id }}" method="POST" action="{{ route('admin.universitas.konten.destroy', [$campus, $item]) }}" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')</form>
                @empty
                <div class="text-center border rounded-3 py-4 text-secondary small">Belum ada data {{ strtolower($label) }}. Bagian ini belum akan muncul sebagai informasi di halaman kampus.</div>
                @endforelse
            </div>
        </div>
    </section>
    @endforeach
</div>
<div class="alert alert-light border mt-4 small"><i class="bi bi-chat-square-text me-2 text-primary"></i>Ulasan berasal dari pengguna yang masuk. Ulasan ditampilkan di tab Ulasan setelah dikirim.</div>
@endsection

@push('scripts')
<script>
(() => {
    const select = document.getElementById('program-title-select');
    const customInput = document.getElementById('program-title-custom');
    [[select, customInput, true]].forEach(([dropdown, input, required]) => {
        if (!dropdown || !input) return;
        const sync = () => {
            const isCustom = dropdown.value === '__new';
            input.style.display = isCustom ? 'block' : 'none';
            input.required = isCustom && required;
            if (!isCustom) input.value = '';
        };
        dropdown.addEventListener('change', sync);
        sync();
    });
})();
</script>
@endpush
