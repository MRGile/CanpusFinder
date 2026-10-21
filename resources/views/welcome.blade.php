@extends('layouts.app')

@section('title', 'Beranda - Temukan Kampus Impianmu')
@section('meta_description', 'CampusFinder - Platform terlengkap untuk mencari dan membandingkan kampus terbaik di Indonesia. Temukan universitas, politeknik, dan akademi sesuai impianmu.')

@section('content')

<!-- ============================
     HERO SECTION
     ============================ -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <!-- Left: Text -->
            <div class="hero-text">
                <div class="hero-badge">
                    <span class="dot"></span>
                    Platform #1 Pencari Kampus Indonesia
                </div>

                <h1 class="hero-title">
                    Temukan <span class="highlight">Kampus Impian</span><br>
                    Mulai Perjalanan<br>
                    Akademikmu
                </h1>

                <p class="hero-description">
                    Jelajahi lebih dari 4.500+ perguruan tinggi di seluruh Indonesia.
                    Bandingkan program studi, cari beasiswa, dan buat keputusan terbaik
                    untuk masa depanmu bersama CampusFinder.
                </p>

                <!-- Search Bar in Hero -->
                <div class="home-search-panel">
                    <form class="search-form" action="/kampus" method="GET">
                        <div class="home-search-row">
                            <input type="search" name="q" aria-label="Nama universitas" placeholder="Cari nama universitas..." class="home-search-input">
                            <button type="submit" class="btn-search home-search-submit">Cari</button>
                        </div>
                    </form>
                </div>

                <div class="hero-cta">
                    <a href="/kampus" class="btn btn-white btn-lg">
                        
                        Jelajahi Kampus
                    </a>
                    <a href="/bandingkan" class="btn btn-secondary" style="background: transparent; color: white; border-color: rgba(255,255,255,0.4);">
                        
                        Bandingkan Kampus
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="hero-stat-item">
                        <div class="stat-number" data-count="4500" data-suffix="+">4.500+</div>
                        <div class="stat-label">Perguruan Tinggi</div>
                    </div>
                    <div class="hero-stat-item">
                        <div class="stat-number" data-count="28000" data-suffix="+">28.000+</div>
                        <div class="stat-label">Program Studi</div>
                    </div>
                    <div class="hero-stat-item">
                        <div class="stat-number" data-count="2" data-suffix="Jt+">2Jt+</div>
                        <div class="stat-label">Pengguna Aktif</div>
                    </div>
                    <div class="hero-stat-item">
                        <div class="stat-number" data-count="500" data-suffix="+">500+</div>
                        <div class="stat-label">Info Beasiswa</div>
                    </div>
                </div>
            </div>

            <!-- Right: Visual Card -->
            <div class="hero-visual">
                <div class="hero-card" style="box-shadow: 0 30px 80px rgba(0,0,0,0.3);">
                    <div class="hero-card-header">
                        <h3> Rekomendasi Untukmu</h3>
                        <p>Berdasarkan minat & lokasi</p>
                    </div>
                    <div class="hero-card-body">
                        <div class="mini-campus-card">
                            <div class="mini-campus-logo" style="background: #EFF6FF; color: #1D4ED8;">UI</div>
                            <div class="mini-campus-info">
                                <h4>Universitas Indonesia</h4>
                                <p>Depok, Jawa Barat · Akreditasi A</p>
                            </div>
                            <span class="mini-campus-badge" style="background: #DCFCE7; color: #166534;">Negeri</span>
                        </div>
                        <div class="mini-campus-card">
                            <div class="mini-campus-logo" style="background: #FEF3C7; color: #B45309;">ITB</div>
                            <div class="mini-campus-info">
                                <h4>Institut Teknologi Bandung</h4>
                                <p>Bandung, Jawa Barat · Akreditasi A</p>
                            </div>
                            <span class="mini-campus-badge" style="background: #DCFCE7; color: #166534;">Negeri</span>
                        </div>
                        <div class="mini-campus-card">
                            <div class="mini-campus-logo" style="background: #EDE9FE; color: #5B21B6;">UGM</div>
                            <div class="mini-campus-info">
                                <h4>Universitas Gadjah Mada</h4>
                                <p>Yogyakarta · Akreditasi A</p>
                            </div>
                            <span class="mini-campus-badge" style="background: #DCFCE7; color: #166534;">Negeri</span>
                        </div>
                        <div class="mini-campus-card">
                            <div class="mini-campus-logo" style="background: #FFE4E6; color: #9F1239;">BINUS</div>
                            <div class="mini-campus-info">
                                <h4>Bina Nusantara University</h4>
                                <p>Jakarta · Akreditasi A</p>
                            </div>
                            <span class="mini-campus-badge" style="background: #FEF3C7; color: #92400E;">Swasta</span>
                        </div>

                        <a href="/kampus" style="display:flex;align-items:center;justify-content:center;gap:8px;margin-top:16px;padding:12px;background:var(--primary-light);color:var(--primary);border-radius:10px;font-size:0.88rem;font-weight:600;transition:var(--transition);">
                            Lihat Semua Kampus
                            
                        </a>
                    </div>
                </div>

                <!-- Floating badges -->
                <div style="position:absolute;top:-16px;right:-16px;background:var(--accent);color:white;padding:10px 18px;border-radius:12px;font-size:0.82rem;font-weight:700;box-shadow:var(--shadow-md);animation:float 3s ease-in-out infinite;">
                     4.500+ Kampus
                </div>
                <div style="position:absolute;bottom:20px;left:-20px;background:white;color:var(--dark);padding:10px 16px;border-radius:12px;font-size:0.8rem;font-weight:600;box-shadow:var(--shadow-md);display:flex;align-items:center;gap:8px;animation:float 4s ease-in-out infinite 1s;">
                    <span style="color:var(--success);"></span> 120+ Beasiswa Aktif
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.home-search-panel {
    max-width: 680px;
    margin-bottom: 28px;
    padding: 14px;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.22);
    border-radius: 12px;
}
.home-search-row {
    display: grid;
    grid-template-columns: minmax(0,1fr) auto;
    gap: 10px;
}
.home-search-input {
    width: 100%;
    min-width: 0;
    height: 48px;
    padding: 0 14px;
    color: var(--dark);
    background: white;
    border: 1px solid var(--gray-300);
    border-radius: 8px;
}
.home-search-submit {
    min-width: 112px;
    height: 48px;
    padding: 0 16px;
    border-radius: 8px;
}
@media (max-width: 480px) {
    .home-search-panel { padding: 10px; }
    .home-search-row { gap: 8px; }
    .home-search-submit { min-width: 82px; padding: 0 10px; }
}
</style>
@endpush

<!-- Float animation -->
<style>
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}
</style>

<!-- ============================
     KATEGORI KAMPUS
     ============================ -->
<section class="section bg-white">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">
                
                Kategori
            </div>
            <h2 class="section-title">Jelajahi Berdasarkan Jenis Kampus</h2>
            <p class="section-subtitle">Temukan kampus yang sesuai dengan tujuan dan minatmu dari berbagai kategori</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:16px;">
            @foreach($campusTypes as $campusType)
            <a href="/kampus?jenis={{ strtolower($campusType->type) }}" style="background: {{ $campusType->type === 'Negeri' ? '#EFF6FF' : '#FEF3C7' }}; border-radius: 16px; padding: 24px 16px; text-align: center; transition: all 0.3s; border: 2px solid transparent; text-decoration: none;" onmouseover="this.style.transform='translateY(-4px)';this.style.borderColor='{{ $campusType->type === 'Negeri' ? '#1D4ED8' : '#B45309' }}'" onmouseout="this.style.transform='';this.style.borderColor='transparent'">
                
                <h3 style="font-size: 0.85rem; font-weight: 700; color: {{ $campusType->type === 'Negeri' ? '#1D4ED8' : '#B45309' }}; margin-bottom: 4px;">Universitas {{ $campusType->type }}</h3>
                <p style="font-size: 0.78rem; color: {{ $campusType->type === 'Negeri' ? '#1D4ED8' : '#B45309' }}; opacity: 0.75;">{{ $campusType->total }} kampus</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- ============================
     KAMPUS UNGGULAN
     ============================ -->
<section class="section" style="background: var(--gray-200);">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">
                
                Terbaik
            </div>
            <h2 class="section-title">Kampus Unggulan Indonesia</h2>
            <p class="section-subtitle">Perguruan tinggi terbaik berdasarkan akreditasi, reputasi, dan pilihan mahasiswa</p>
        </div>

        <div class="filter-pills">
            <button class="filter-pill active" onclick="filterCampus(this, 'semua')">Semua <span class="count">4.500+</span></button>
            <button class="filter-pill" onclick="filterCampus(this, 'negeri')">Negeri <span class="count">122</span></button>
            <button class="filter-pill" onclick="filterCampus(this, 'swasta')">Swasta <span class="count">2.800+</span></button>
            <button class="filter-pill" onclick="filterCampus(this, 'vokasi')">Vokasi <span class="count">310+</span></button>
            <button class="filter-pill" onclick="filterCampus(this, 'kedinasan')">Kedinasan <span class="count">80+</span></button>
        </div>

        <div class="campus-grid" id="campusGrid">
            @foreach($campuses as $campus)
            <div class="campus-card">
                <div class="campus-card-image" style="background: {{ $campus->cover_gradient }};">
                    @if($campus->image_path)<img src="{{ asset('storage/'.$campus->image_path) }}" alt="Foto {{ $campus->name }}" style="position:absolute;inset:0;">@else<span style="font-size: 3.5rem; font-weight: 900; color: rgba(255,255,255,0.2); font-family: var(--font-main);">{{ $campus->abbreviation }}</span>@endif
                    <span class="campus-type-badge {{ $campus->type === 'Negeri' ? 'badge-negeri' : 'badge-swasta' }}">{{ $campus->type }}</span>
                    @auth<form method="POST" action="{{ route('campus.favorite.toggle', $campus->slug) }}">@csrf<button class="campus-fav-btn" type="submit" aria-label="Simpan ke favorit">Simpan</button></form>@else<a class="campus-fav-btn" href="/masuk" aria-label="Masuk untuk menyimpan favorit">Simpan</a>@endauth
                    <span class="campus-rank-badge">{{ $campus->rank }}</span>
                </div>
                <div class="campus-card-body">
                    <div class="campus-logo-row">
                        <div class="campus-logo" style="background: {{ $campus->logo_color }}; color: {{ $campus->logo_text_color }};">{{ $campus->abbreviation }}</div>
                        <div>
                            <div class="campus-card-title">{{ $campus->name }}</div>
                            <div class="campus-card-location">
                                
                                {{ $campus->city }}
                            </div>
                        </div>
                    </div>
                    <div class="campus-meta">
                        <div class="campus-meta-item">
                            
                            Akreditasi {{ $campus->accreditation }}
                        </div>
                        <div class="campus-meta-item">
                            
                            {{ $campus->program_count }} Prodi
                        </div>
                        <div class="campus-rating">
                            
                            <span>{{ $campus->rating }} ({{ number_format($campus->review_count) }})</span>
                        </div>
                    </div>
                    <div class="campus-card-footer">
                        <span class="campus-prodi-count">{{ $campus->program_count }} Program Studi</span>
                        <a href="/kampus/{{ $campus->slug }}" class="btn-detail">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <a href="/kampus" class="btn btn-primary btn-lg">
                Lihat Semua Kampus
                
            </a>
        </div>
    </div>
</section>

<!-- ============================
     STATISTIK
     ============================ -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                
                <div class="stat-number" data-count="4500" data-suffix="+">4.500+</div>
                <div class="stat-label">Perguruan Tinggi Terdaftar</div>
            </div>
            <div class="stat-card">
                
                <div class="stat-number" data-count="28000" data-suffix="+">28.000+</div>
                <div class="stat-label">Program Studi Tersedia</div>
            </div>
            <div class="stat-card">
                
                <div class="stat-number" data-count="2000000" data-suffix="+">2Jt+</div>
                <div class="stat-label">Pengguna Aktif</div>
            </div>
            <div class="stat-card">
                
                <div class="stat-number" data-count="500" data-suffix="+">500+</div>
                <div class="stat-label">Beasiswa Aktif</div>
            </div>
        </div>
    </div>
</section>

<!-- ============================
     PROGRAM STUDI POPULER
     ============================ -->
<section class="section bg-white">
    <div class="container">
        <div class="section-header">
            <div class="section-badge"> Program Studi</div>
            <h2 class="section-title">Program Studi Paling Diminati</h2>
            <p class="section-subtitle">Temukan program studi impianmu dari ribuan pilihan yang tersedia</p>
        </div>

        <div class="prodi-grid">
            @foreach($programs as $program)
            <a href="/program-studi?nama={{ urlencode($program->name) }}" class="prodi-card" style="border: 1px solid var(--gray-200);">
                <h3>{{ $program->name }}</h3>
                <p>Tersedia di {{ $program->university_count }} Universitas</p>
                <span class="prodi-count">Lihat Semua </span>
            </a>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <a href="/program-studi" class="btn btn-secondary btn-lg">Lihat Semua Program Studi</a>
        </div>
    </div>
</section>

<!-- ============================
     CARA KERJA
     ============================ -->
<section class="section" style="background: var(--gray-100);">
    <div class="container">
        <div class="section-header">
            <div class="section-badge"> Cara Kerja</div>
            <h2 class="section-title">Mudah Menemukan Kampus Impian</h2>
            <p class="section-subtitle">Hanya 4 langkah mudah untuk menemukan kampus yang tepat untukmu</p>
        </div>

        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Tentukan Minat</h3>
                <p>Pilih bidang studi atau program yang sesuai dengan passion dan minatmu</p>
            </div>
            <div class="step-card">
                <div class="step-number">2</div>
                <h3>Cari & Filter</h3>
                <p>Gunakan filter canggih kami untuk menyaring kampus berdasarkan lokasi, biaya, akreditasi</p>
            </div>
            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Bandingkan</h3>
                <p>Bandingkan beberapa kampus sekaligus untuk mendapatkan pilihan terbaik</p>
            </div>
            <div class="step-card">
                <div class="step-number">4</div>
                <h3>Daftar Sekarang</h3>
                <p>Akses informasi pendaftaran dan mulai perjalanan akademikmu</p>
            </div>
        </div>
    </div>
</section>

<!-- ============================
     BEASISWA
     ============================ -->
<section class="section bg-white">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">
            <div>
                <div class="section-badge" style="display:inline-flex;"> Beasiswa</div>
                <h2 class="section-title" style="text-align:left; margin-bottom: 16px;">Raih Beasiswamu Sekarang</h2>
                <p style="color: var(--gray-600); line-height: 1.8; margin-bottom: 28px;">Kami memiliki 500+ program beasiswa dari pemerintah, swasta, hingga luar negeri yang bisa kamu akses secara gratis.</p>

                <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 32px;">
                    @foreach($scholarships as $scholarship)
                    <div style="display:flex;align-items:center;gap:16px;background:var(--gray-100);border-radius:12px;padding:16px;">
                        
                        <div style="flex:1;">
                            <h4 style="font-size:0.88rem;font-weight:700;margin-bottom:2px;">{{ $scholarship->name }}</h4>
                            <p style="font-size:0.75rem;color:var(--gray-600);">{{ $scholarship->provider }}</p>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-size:0.75rem;font-weight:700;color:var(--success);margin-bottom:2px;">{{ $scholarship->amount }}</div>
                            <div style="font-size:0.72rem;color:var(--gray-500);">Deadline: {{ $scholarship->deadline_label }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <a href="/beasiswa" class="btn btn-primary btn-lg">Cari Beasiswa Lebih </a>
            </div>

            <div style="position:relative;">
                <div style="background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 24px; padding: 40px; color: white; text-align: center;">
                    
                    <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 8px;">500+ Beasiswa</h3>
                    <p style="opacity: 0.85; margin-bottom: 24px;">Tersedia untuk mahasiswa Indonesia di dalam dan luar negeri</p>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div style="background:rgba(255,255,255,0.15);border-radius:12px;padding:16px;">
                            <div style="font-size:1.4rem;font-weight:800;">120+</div>
                            <div style="font-size:0.78rem;opacity:0.8;">Beasiswa Penuh</div>
                        </div>
                        <div style="background:rgba(255,255,255,0.15);border-radius:12px;padding:16px;">
                            <div style="font-size:1.4rem;font-weight:800;">380+</div>
                            <div style="font-size:0.78rem;opacity:0.8;">Beasiswa Parsial</div>
                        </div>
                        <div style="background:rgba(255,255,255,0.15);border-radius:12px;padding:16px;">
                            <div style="font-size:1.4rem;font-weight:800;">50+</div>
                            <div style="font-size:0.78rem;opacity:0.8;">Beasiswa LN</div>
                        </div>
                        <div style="background:rgba(255,255,255,0.15);border-radius:12px;padding:16px;">
                            <div style="font-size:1.4rem;font-weight:800;">2Jt+</div>
                            <div style="font-size:0.78rem;opacity:0.8;">Penerima/Tahun</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================
     TESTIMONI
     ============================ -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge"> Testimoni</div>
            <h2 class="section-title">Cerita Sukses Pengguna Kami</h2>
            <p class="section-subtitle">Ribuan mahasiswa telah menemukan kampus impian mereka melalui CampusFinder</p>
        </div>

        <div class="testimonial-grid">
            @foreach($testimonials as $testimonial)
            <div class="testimonial-card">
                <p class="testimonial-quote">{{ $testimonial->quote }}</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar" style="background: {{ $testimonial->background_color }}; color: {{ $testimonial->text_color }};">{{ $testimonial->initials }}</div>
                    <div class="testimonial-author-info">
                        <h4>{{ $testimonial->name }}</h4>
                        <p>{{ $testimonial->detail }}</p>
                        
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ============================
     CTA SECTION
     ============================ -->
<section style="background: linear-gradient(135deg, var(--dark), #1E3A5F); padding: 80px 0;">
    <div class="container" style="text-align: center;">
        <div style="max-width: 600px; margin: 0 auto;">
            <h2 style="font-size: 2.2rem; font-weight: 800; color: white; margin-bottom: 16px;">
                Mulai Perjalanan Akademikmu Sekarang!
            </h2>
            <p style="color: rgba(255,255,255,0.75); font-size: 1rem; margin-bottom: 36px; line-height: 1.8;">
                Daftar gratis dan dapatkan akses ke ribuan informasi kampus, beasiswa, dan program studi pilihan.
            </p>
            <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                <a href="/daftar" class="btn btn-accent btn-lg">
                    Daftar Gratis Sekarang
                    
                </a>
                <a href="/kampus" class="btn btn-white btn-lg">Jelajahi Kampus</a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function filterCampus(btn, type) {
    // Remove active from all pills
    btn.closest('.filter-pills').querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    // In real app, this would filter via AJAX or show/hide cards
}
</script>
@endpush
