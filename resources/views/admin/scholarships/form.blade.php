@extends('layouts.dashboard')

@php($editing = $scholarship->exists)
@php($allCampusesValue = \App\Models\Scholarship::ALL_CAMPUSES)
@php($selectedEligibleUniversity = old('eligible_universities', $scholarship->eligible_universities))
@section('title', ($editing ? 'Edit' : 'Tambah').' Beasiswa - CampusFinder')

@section('content')
<div class="mb-4"><a href="{{ route('admin.beasiswa.index') }}" class="text-decoration-none small"><i class="bi bi-arrow-left me-1"></i>Kembali ke daftar beasiswa</a><h1 class="h3 fw-bold text-dark mt-2 mb-1">{{ $editing ? 'Edit beasiswa' : 'Tambah beasiswa' }}</h1><p class="text-secondary mb-0">Informasi ini akan digunakan pada katalog beasiswa publik.</p></div>

@if($errors->any())<div class="alert alert-danger"><div class="fw-semibold mb-1">Periksa kembali isian berikut:</div><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

<form method="POST" action="{{ $editing ? route('admin.beasiswa.update', $scholarship) : route('admin.beasiswa.store') }}">
    @csrf
    @if($editing)@method('PUT')@endif
    <div class="card border-0 shadow-sm mb-4"><div class="card-header bg-white border-0 pt-4 px-4"><h2 class="h6 fw-bold mb-1">Informasi beasiswa</h2><p class="small text-secondary mb-0">Lengkapi detail program dan penyelenggaranya.</p></div>
        <div class="card-body p-4"><div class="row g-3">
            <div class="col-md-8"><label class="form-label fw-semibold" for="name">Nama beasiswa <span class="text-danger">*</span></label><input class="form-control" id="name" name="name" value="{{ old('name', $scholarship->name) }}" required maxlength="255"></div>
            <div class="col-md-4"><label class="form-label fw-semibold" for="provider">Penyelenggara <span class="text-danger">*</span></label><input class="form-control" id="provider" name="provider" value="{{ old('provider', $scholarship->provider) }}" required maxlength="255" placeholder="Contoh: Pemerintah RI"></div>
            <div class="col-md-4"><label class="form-label fw-semibold" for="scholarship_type">Jenis <span class="text-danger">*</span></label><select class="form-select" id="scholarship_type" name="scholarship_type" required><option value="">Pilih jenis beasiswa</option>@foreach($scholarshipTypes as $type)<option value="{{ $type }}" @selected(!$customTypeSelected && old('scholarship_type', $scholarship->scholarship_type) === $type)>{{ $type }}</option>@endforeach<option value="__new" @selected($customTypeSelected)>+ Tambah jenis baru</option></select><input class="form-control mt-2" id="scholarship_type_custom" name="scholarship_type_custom" value="{{ old('scholarship_type_custom', $customTypeSelected && old('scholarship_type') !== '__new' ? old('scholarship_type') : '') }}" maxlength="255" placeholder="Nama jenis beasiswa" @if(!$customTypeSelected) style="display:none" @endif></div>
            <div class="col-md-4"><label class="form-label fw-semibold" for="study_level">Jenjang <span class="text-danger">*</span></label><select class="form-select" id="study_level" name="study_level" required><option value="">Pilih jenjang</option>@foreach($studyLevels as $level)<option value="{{ $level }}" @selected(!$customLevelSelected && old('study_level', $scholarship->study_level) === $level)>{{ $level }}</option>@endforeach<option value="__new" @selected($customLevelSelected)>+ Tambah jenjang baru</option></select><input class="form-control mt-2" id="study_level_custom" name="study_level_custom" value="{{ old('study_level_custom', $customLevelSelected && old('study_level') !== '__new' ? old('study_level') : '') }}" maxlength="255" placeholder="Nama jenjang baru" @if(!$customLevelSelected) style="display:none" @endif></div>
            <div class="col-md-4"><label class="form-label fw-semibold" for="amount">Nominal/manfaat <span class="text-danger">*</span></label><input class="form-control" id="amount" name="amount" value="{{ old('amount', $scholarship->amount) }}" required maxlength="255" placeholder="Contoh: Biaya kuliah penuh"></div>
            <div class="col-md-4"><label class="form-label fw-semibold" for="deadline">Batas waktu <span class="text-danger">*</span></label><input class="form-control" type="date" id="deadline" name="deadline" value="{{ old('deadline', $scholarship->deadline?->format('Y-m-d')) }}" required></div>
            <div class="col-md-4"><label class="form-label fw-semibold" for="recipient_count">Jumlah penerima</label><input class="form-control" id="recipient_count" name="recipient_count" value="{{ old('recipient_count', $scholarship->recipient_count) }}" maxlength="255" placeholder="Contoh: 1.000 mahasiswa"></div>
            <div class="col-12">
                <label class="form-label fw-semibold" for="eligible_universities">Kampus/universitas yang bisa mendaftar <span class="text-danger">*</span></label>
                <select class="form-select" id="eligible_universities" name="eligible_universities" required>
                    <option value="">Pilih kampus atau cakupan pendaftar</option>
                    <option value="{{ $allCampusesValue }}" @selected($selectedEligibleUniversity === $allCampusesValue)>Semua universitas/sekolah</option>
                    @if($legacyEligibleUniversity)
                        <option value="{{ $legacyEligibleUniversity }}" @selected($selectedEligibleUniversity === $legacyEligibleUniversity)>{{ $legacyEligibleUniversity }} (data sebelumnya)</option>
                    @endif
                    @foreach($campuses as $campus)
                        <option value="{{ $campus->name }}" @selected($selectedEligibleUniversity === $campus->name)>
                            {{ $campus->name }}{{ $campus->abbreviation ? ' ('.$campus->abbreviation.')' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12"><label class="form-label fw-semibold" for="requirements">Persyaratan</label><textarea class="form-control" id="requirements" name="requirements" rows="4" maxlength="10000" placeholder="Satu persyaratan per baris">{{ old('requirements', $scholarship->requirements) }}</textarea></div>
            <div class="col-12"><label class="form-label fw-semibold" for="benefits">Benefit</label><textarea class="form-control" id="benefits" name="benefits" rows="4" maxlength="10000" placeholder="Contoh: biaya kuliah, uang saku">{{ old('benefits', $scholarship->benefits) }}</textarea></div>
            <div class="col-12"><label class="form-label fw-semibold" for="required_documents">Dokumen yang dibutuhkan</label><textarea class="form-control" id="required_documents" name="required_documents" rows="4" maxlength="10000" placeholder="Satu dokumen per baris">{{ old('required_documents', $scholarship->required_documents) }}</textarea></div>
            <div class="col-12"><label class="form-label fw-semibold" for="description">Deskripsi</label><textarea class="form-control" id="description" name="description" rows="4" maxlength="5000">{{ old('description', $scholarship->description) }}</textarea></div>
            <div class="col-12"><label class="form-label fw-semibold" for="application_url">Tautan pendaftaran/info resmi</label><input class="form-control" type="url" id="application_url" name="application_url" value="{{ old('application_url', $scholarship->application_url) }}" maxlength="255" placeholder="https://..."><div class="form-text">Masukkan URL lengkap yang diawali http:// atau https://.</div></div>
        </div></div>
    </div>
    <div class="d-flex justify-content-end gap-2"><a href="{{ route('admin.beasiswa.index') }}" class="btn btn-light border">Batal</a><button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i>{{ $editing ? 'Simpan perubahan' : 'Tambah beasiswa' }}</button></div>
</form>
@endsection

@push('scripts')
<script>
(() => {
    [['scholarship_type', 'scholarship_type_custom'], ['study_level', 'study_level_custom']].forEach(([selectId, inputId]) => {
        const select = document.getElementById(selectId);
        const customInput = document.getElementById(inputId);
        if (!select || !customInput) return;
        const sync = () => {
            const isCustom = select.value === '__new';
            customInput.style.display = isCustom ? 'block' : 'none';
            customInput.required = isCustom;
            if (!isCustom) customInput.value = '';
        };
        select.addEventListener('change', sync);
        sync();
    });
})();
</script>
@endpush
