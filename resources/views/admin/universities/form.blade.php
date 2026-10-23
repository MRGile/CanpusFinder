@extends('layouts.dashboard')

@section('title', ($campus->exists ? 'Edit' : 'Tambah').' Universitas - CampusFinder')
@php($activeMenu = 'admin')

@section('content')
<div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
    <div>
        <a href="{{ route('admin.universitas.index') }}" class="text-decoration-none small fw-semibold"><i class="bi bi-arrow-left me-1"></i>Semua universitas</a>
        <h1 class="h3 fw-bold text-dark mt-2 mb-1">{{ $campus->exists ? 'Edit Universitas' : 'Tambah Universitas' }}</h1>
        <p class="text-secondary mb-0">Lengkapi profil, kontak, dan informasi akademik universitas.</p>
    </div>
    <span class="badge rounded-pill text-bg-primary-subtle text-primary px-3 py-2">Profil universitas</span>
</div>

<form method="POST" enctype="multipart/form-data" action="{{ $campus->exists ? route('admin.universitas.update', $campus) : route('admin.universitas.store') }}">
    @csrf @if($campus->exists) @method('PUT') @endif
    @if($errors->any())<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}</div>@endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom py-3"><h2 class="h6 fw-bold mb-1"><i class="bi bi-patch-check me-2 text-primary"></i>Logo universitas</h2><p class="small text-secondary mb-0">Logo tampil sebagai identitas kampus di katalog dan halaman detail.</p></div>
        <div class="card-body p-4">
            <div class="row align-items-center g-4">
                @if($campus->logo_path)
                <div class="col-sm-auto"><img src="{{ asset('storage/'.$campus->logo_path) }}" alt="Logo {{ $campus->name }}" class="rounded-3 border bg-white p-2" style="width:112px;height:112px;object-fit:contain;" id="campusLogoPreview"></div>
                @else
                <div class="col-sm-auto d-none" id="campusLogoPreviewWrap"><img src="" alt="Pratinjau logo universitas" class="rounded-3 border bg-white p-2" style="width:112px;height:112px;object-fit:contain;" id="campusLogoPreview"></div>
                @endif
                <div class="col">
                    <label for="logo" class="form-label">{{ $campus->logo_path ? 'Ganti logo' : 'Pilih file logo' }}</label>
                    <input id="logo" name="logo" type="file" accept="image/jpeg,image/png,image/webp" class="form-control @error('logo') is-invalid @enderror">
                    <div class="form-text">PNG dengan latar transparan paling cocok. Format JPG, PNG, atau WebP, maksimal 2 MB.</div>
                    @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if($campus->logo_path)<div class="form-check mt-3"><input class="form-check-input" type="checkbox" value="1" id="remove_logo" name="remove_logo"><label class="form-check-label text-danger" for="remove_logo">Hapus logo saat disimpan</label></div>@endif
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom py-3"><h2 class="h6 fw-bold mb-1"><i class="bi bi-image me-2 text-primary"></i>Foto universitas</h2><p class="small text-secondary mb-0">Unggah foto kampus agar tampil di katalog dan halaman detail.</p></div>
        <div class="card-body p-4">
            <div class="row align-items-center g-4">
                @if($campus->image_path)
                <div class="col-sm-auto"><img src="{{ asset('storage/'.$campus->image_path) }}" alt="Foto {{ $campus->name }}" class="rounded-3 border" style="width:180px;height:120px;object-fit:cover;" id="campusImagePreview"></div>
                @else
                <div class="col-sm-auto d-none" id="campusImagePreviewWrap"><img src="" alt="Pratinjau foto universitas" class="rounded-3 border" style="width:180px;height:120px;object-fit:cover;" id="campusImagePreview"></div>
                @endif
                <div class="col">
                    <label for="image" class="form-label">{{ $campus->image_path ? 'Ganti foto' : 'Pilih foto' }}</label>
                    <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="form-control @error('image') is-invalid @enderror">
                    <div class="form-text">JPG, PNG, atau WebP. Maksimal 5 MB.</div>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if($campus->image_path)<div class="form-check mt-3"><input class="form-check-input" type="checkbox" value="1" id="remove_image" name="remove_image"><label class="form-check-label text-danger" for="remove_image">Hapus foto saat disimpan</label></div>@endif
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom py-3">
            <h2 class="h6 fw-bold mb-1"><i class="bi bi-building me-2 text-primary"></i>Identitas universitas</h2>
            <p class="small text-secondary mb-0">Informasi dasar yang tampil di katalog kampus.</p>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-8"><label for="name" class="form-label">Nama resmi universitas <span class="text-danger">*</span></label><input id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $campus->name) }}" required maxlength="255" placeholder="Contoh: Universitas Indonesia">@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-4"><label for="abbreviation" class="form-label">Singkatan <span class="text-danger">*</span></label><input id="abbreviation" name="abbreviation" class="form-control" value="{{ old('abbreviation', $campus->abbreviation) }}" required maxlength="20" placeholder="UI"></div>
                <div class="col-md-4"><label for="type" class="form-label">Jenis perguruan tinggi <span class="text-danger">*</span></label><select id="type" name="type" class="form-select" required><option value="">Pilih jenis</option>@foreach(['Negeri', 'Swasta', 'Vokasi', 'Kedinasan'] as $type)<option value="{{ $type }}" @selected(old('type', $campus->type) === $type)>{{ $type }}</option>@endforeach</select></div>
                <div class="col-md-4"><label for="founded_year" class="form-label">Tahun berdiri</label><input id="founded_year" name="founded_year" type="number" class="form-control" value="{{ old('founded_year', $campus->founded_year) }}" min="1800" max="{{ now()->year }}" placeholder="Contoh: 1849"><div class="form-text">Opsional</div></div>
                <div class="col-md-4"><label for="program_count" class="form-label">Jumlah program studi <span class="text-danger">*</span></label><input id="program_count" name="program_count" type="number" class="form-control" value="{{ old('program_count', $campus->program_count ?? 0) }}" min="0" max="10000" required><div class="form-text">Masukkan jumlah prodi aktif.</div></div>
                <div class="col-md-6"><label for="accreditation" class="form-label">Akreditasi institusi <span class="text-danger">*</span></label><input id="accreditation" name="accreditation" class="form-control" value="{{ old('accreditation', $campus->accreditation ?: 'Unggul') }}" required maxlength="100" placeholder="Unggul / A / Baik Sekali"></div>
                <div class="col-md-6"><label for="rank" class="form-label">Peringkat</label><input id="rank" name="rank" class="form-control" value="{{ old('rank', $campus->rank) }}" maxlength="100" placeholder="Contoh: #1 nasional"><div class="form-text">Sertakan sumber atau kategori peringkat di deskripsi.</div></div>
                <div class="col-12"><label for="description" class="form-label">Tentang universitas</label><textarea id="description" name="description" class="form-control" rows="4" maxlength="5000" placeholder="Sejarah singkat, keunggulan, dan informasi penting lainnya">{{ old('description', $campus->description) }}</textarea><div class="form-text">Maksimal 5.000 karakter.</div></div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom py-3">
            <h2 class="h6 fw-bold mb-1"><i class="bi bi-geo-alt me-2 text-primary"></i>Lokasi dan kontak</h2>
            <p class="small text-secondary mb-0">Memudahkan calon mahasiswa menemukan dan menghubungi kampus.</p>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6"><label for="city" class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label><input id="city" name="city" class="form-control" value="{{ old('city', $campus->city) }}" required maxlength="255" placeholder="Depok"></div>
                <div class="col-md-6"><label for="province" class="form-label">Provinsi</label><input id="province" name="province" class="form-control" value="{{ old('province', $campus->province) }}" maxlength="255" placeholder="Jawa Barat"></div>
                <div class="col-12"><label for="address" class="form-label">Alamat kampus</label><textarea id="address" name="address" class="form-control" rows="2" maxlength="2000" placeholder="Jalan, nomor, kelurahan, dan kode pos">{{ old('address', $campus->address) }}</textarea></div>
                <div class="col-md-6"><label for="website" class="form-label">Situs web resmi</label><input id="website" name="website" type="url" class="form-control" value="{{ old('website', $campus->website) }}" maxlength="255" placeholder="https://www.universitas.ac.id"></div>
                <div class="col-md-6"><label for="email" class="form-label">Email informasi</label><input id="email" name="email" type="email" class="form-control" value="{{ old('email', $campus->email) }}" maxlength="255" placeholder="info@universitas.ac.id"></div>
                <div class="col-md-6"><label for="phone" class="form-label">Telepon</label><input id="phone" name="phone" type="tel" class="form-control" value="{{ old('phone', $campus->phone) }}" maxlength="40" placeholder="(021) 12345678"></div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-end gap-2 mb-4"><a href="{{ route('admin.universitas.index') }}" class="btn btn-outline-secondary">Batal</a><button type="submit" class="btn btn-primary px-4"><i class="bi bi-check2-circle me-2"></i>Simpan Universitas</button></div>
</form>
@push('scripts')
<script>
document.getElementById('image')?.addEventListener('change', function (event) {
    const file = event.target.files?.[0];
    if (!file) return;

    const preview = document.getElementById('campusImagePreview');
    const wrap = document.getElementById('campusImagePreviewWrap');
    preview.src = URL.createObjectURL(file);
    wrap?.classList.remove('d-none');
});
document.getElementById('logo')?.addEventListener('change', function (event) {
    const file = event.target.files?.[0];
    if (!file) return;

    const preview = document.getElementById('campusLogoPreview');
    const wrap = document.getElementById('campusLogoPreviewWrap');
    preview.src = URL.createObjectURL(file);
    wrap?.classList.remove('d-none');
});
</script>
@endpush
@endsection
