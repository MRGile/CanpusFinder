@extends('layouts.app')

@section('title', 'Cari Kampus - CampusFinder')
@section('meta_description', 'Cari dan temukan kampus terbaik di Indonesia. Filter berdasarkan kota, akreditasi, jenis kampus, biaya kuliah, dan program studi.')

@section('content')

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="section-badge" style="display:inline-flex;background:rgba(255,255,255,0.1);color:white;border:1px solid rgba(255,255,255,0.2);">
                Direktori Kampus
            </div>
            <h1 class="page-hero-title">Cari Kampus Impianmu</h1>
            <p class="page-hero-subtitle">Cari universitas berdasarkan nama, kota, jenis, atau fakultas.</p>
        </div>
    </div>
</section>

<!-- Search Bar -->
<div class="search-section">
    <div class="container">
        <form class="search-form" action="/kampus" method="GET">
            <div class="search-row" style="grid-template-columns:repeat(auto-fit,minmax(min(100%,190px),1fr));">
                <div class="search-field">
                    <label>Nama Universitas</label>
                    <div class="search-input-wrap">
                        
                        <input type="text" name="q" placeholder="Cari universitas..." class="search-input" value="{{ request('q') }}">
                    </div>
                </div>
                <div class="search-field">
                    <label>Fakultas</label>
                    <div class="search-input-wrap">
                        <input type="text" name="fakultas" placeholder="Cari fakultas..." class="search-input" value="{{ request('fakultas') }}">
                    </div>
                </div>
                <div class="search-field">
                    <label>Provinsi / Kota</label>
                    <select name="kota" class="search-select">
                        <option value="">Semua Kota</option>
                        @foreach($filterCities as $kota)
                        <option {{ request('kota') == $kota ? 'selected' : '' }}>{{ $kota }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="search-field">
                    <label>Jenis Kampus</label>
                    <select name="jenis" class="search-select">
                        <option value="">Semua Jenis</option>
                        <option {{ request('jenis') == 'negeri' ? 'selected' : '' }} value="negeri">Negeri (PTN)</option>
                        <option {{ request('jenis') == 'swasta' ? 'selected' : '' }} value="swasta">Swasta (PTS)</option>
                        <option {{ request('jenis') == 'vokasi' ? 'selected' : '' }} value="vokasi">Vokasi</option>
                        <option {{ request('jenis') == 'kedinasan' ? 'selected' : '' }} value="kedinasan">Kedinasan</option>
                    </select>
                </div>
                <div class="search-field">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn-search">
                        
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Main Content -->
<section class="section-sm" style="background: var(--gray-100);">
    <div class="container">
        <div style="display: grid; grid-template-columns: 280px 1fr; gap: 28px; align-items: start;">

            {{--  SIDEBAR FILTER PARTIAL  --}}
            @include('partials.sidebar-filter')

            <!-- ============================
                 CAMPUS LIST
                 ============================ -->
            <div>
                <!-- Sort & Count Bar -->
                <div style="display:flex;align-items:center;justify-content:space-between;background:white;border-radius:12px;padding:14px 20px;border:1px solid var(--gray-200);margin-bottom:20px;flex-wrap:wrap;gap:12px;">
                    <div style="font-size:0.88rem;color:var(--gray-600);">
                        Menampilkan <strong style="color:var(--dark);">{{ $campuses->total() }}</strong> universitas
                        @if(request('q'))<span> untuk "<strong>{{ request('q') }}</strong>"</span>@endif
                        @if(request('fakultas'))<span> dengan fakultas "<strong>{{ request('fakultas') }}</strong>"</span>@endif
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;">
                        <!-- View Toggle -->
                        <div style="display:flex;border:1px solid var(--gray-300);border-radius:8px;overflow:hidden;">
                            <button onclick="setView('grid', this)" style="padding:8px 12px;background:var(--primary);color:white;border:none;cursor:pointer;" id="viewGrid">Grid</button>
                            <button onclick="setView('list', this)" style="padding:8px 12px;background:white;color:var(--gray-500);border:none;cursor:pointer;" id="viewList">Daftar</button>
                        </div>
                    </div>
                </div>

                <!-- Campus Grid -->
                <div class="campus-grid" id="campusListGrid">
                    @forelse($campuses as $kampus)
                    <div class="campus-card">
                        <div class="campus-card-image" style="background: {{ $kampus->cover_gradient }};">
                            @if($kampus->image_path)<img src="{{ asset('storage/'.$kampus->image_path) }}" alt="Foto {{ $kampus->name }}" style="position:absolute;inset:0;">@else<span style="font-size:3rem;font-weight:900;color:rgba(255,255,255,0.18);font-family:var(--font-main);">{{ $kampus->abbreviation }}</span>@endif
                            <span class="campus-type-badge {{ $kampus->typeBadgeClass() }}">{{ $kampus->type }}</span>
                            @auth<form method="POST" action="{{ route('campus.favorite.toggle', $kampus->slug) }}">@csrf<button class="campus-fav-btn" type="submit" aria-label="Simpan favorit">Simpan</button></form>@else<a class="campus-fav-btn" href="/masuk" aria-label="Masuk untuk menyimpan favorit">Simpan</a>@endauth
                            <span class="campus-rank-badge">{{ $kampus->rank }}</span>
                        </div>
                        <div class="campus-card-body">
                            <div class="campus-logo-row">
                                <div class="campus-logo" style="background:{{ $kampus->logo_color }};color:{{ $kampus->logo_text_color }};overflow:hidden;">@if($kampus->logo_path)<img src="{{ asset('storage/'.$kampus->logo_path) }}" alt="Logo {{ $kampus->name }}" style="width:100%;height:100%;object-fit:contain;padding:4px;">@else{{ $kampus->abbreviation }}@endif</div>
                                <div>
                                    <div class="campus-card-title">{{ $kampus->name }}</div>
                                    <div class="campus-card-location">
                                        
                                        {{ $kampus->city }}
                                    </div>
                                </div>
                            </div>
                            <div class="campus-meta">
                                <div class="campus-meta-item">
                                    
                                    {{ $kampus->accreditation }}
                                </div>
                                <div class="campus-meta-item">
                                    
                                    {{ $kampus->program_count }} Prodi
                                </div>
                                <div class="campus-rating">
                                    
                                    <span>{{ $kampus->reviews_count ? number_format((float) $kampus->reviews_avg_rating, 1) : '—' }}</span>
                                </div>
                            </div>
                            <div class="campus-card-footer">
                                <span class="campus-prodi-count">{{ number_format($kampus->reviews_count) }} ulasan</span>
                                <a href="/kampus/{{ $kampus->slug }}" class="btn-detail">Detail</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="card" style="padding:24px;">Tidak ada kampus yang cocok dengan pencarianmu.</div>
                    @endforelse
                </div>

                @include('partials.catalog-pagination', ['paginator' => $campuses])
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function setView(type, btn) {
    const grid = document.getElementById('campusListGrid');
    document.getElementById('viewGrid').style.background = 'white';
    document.getElementById('viewGrid').style.color = 'var(--gray-500)';
    document.getElementById('viewList').style.background = 'white';
    document.getElementById('viewList').style.color = 'var(--gray-500)';
    btn.style.background = 'var(--primary)';
    btn.style.color = 'white';
    if (type === 'list') {
        grid.style.gridTemplateColumns = '1fr';
    } else {
        grid.style.gridTemplateColumns = '';
    }
}
</script>
@endpush
