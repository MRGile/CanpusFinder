@extends('layouts.app')

@section('title', 'Beasiswa - CampusFinder')

@section('content')

<section class="page-hero" style="background: linear-gradient(135deg, #064E3B 0%, #065F46 50%, #047857 100%);">
    <div class="container">
        <div class="page-hero-content">
            <div class="section-badge" style="display:inline-flex;background:rgba(255,255,255,0.1);color:white;border:1px solid rgba(255,255,255,0.2);"> Beasiswa</div>
            <h1 class="page-hero-title">Temukan Beasiswa Impianmu</h1>
            <p class="page-hero-subtitle">500+ program beasiswa dari dalam dan luar negeri tersedia untukmu</p>

            <!-- Search -->
            <div style="max-width:600px;margin:32px auto 0;display:flex;gap:10px;flex-wrap:wrap;">
                <div style="flex:1;min-width:200px;position:relative;">
                    
                    <input type="text" placeholder="Cari beasiswa..." class="search-input" style="padding-left:42px;height:48px;border-radius:12px;border:none;">
                </div>
                <button class="btn btn-accent" style="height:48px;padding:0 28px;border-radius:12px;">Cari Beasiswa</button>
            </div>
        </div>
    </div>
</section>

<section style="background:var(--gray-100);padding:40px 0;">
    <div class="container">
        <div style="display:grid;grid-template-columns:260px 1fr;gap:28px;align-items:start;">

            <!-- Filter Sidebar -->
            <aside style="position:sticky;top:96px;">
                <div class="card" style="padding:0;overflow:hidden;">
                    <div style="background:#065F46;padding:16px 20px;color:white;">
                        <h3 style="font-size:0.95rem;font-weight:700;">Filter Beasiswa</h3>
                    </div>
                    <div style="padding:20px;">
                        <!-- Jenis -->
                        <div style="margin-bottom:20px;">
                            <h4 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--gray-600);margin-bottom:10px;">Jenis Beasiswa</h4>
                            @foreach($scholarships->pluck('scholarship_type')->unique() as $j)
                            <label style="display:flex;align-items:center;gap:10px;padding:7px 0;cursor:pointer;font-size:0.84rem;">
                                <input type="checkbox" style="accent-color:#047857;width:15px;height:15px;"> {{ $j }}
                            </label>
                            @endforeach
                        </div>
                        <div style="border-top:1px solid var(--gray-200);margin-bottom:20px;"></div>
                        <!-- Jenjang -->
                        <div style="margin-bottom:20px;">
                            <h4 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--gray-600);margin-bottom:10px;">Jenjang</h4>
                            @foreach($scholarships->pluck('study_level')->unique() as $j)
                            <label style="display:flex;align-items:center;gap:10px;padding:7px 0;cursor:pointer;font-size:0.84rem;">
                                <input type="checkbox" style="accent-color:#047857;width:15px;height:15px;"> {{ $j }}
                            </label>
                            @endforeach
                        </div>
                        <div style="border-top:1px solid var(--gray-200);margin-bottom:20px;"></div>
                        <!-- Penyelenggara -->
                        <div style="margin-bottom:20px;">
                            <h4 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--gray-600);margin-bottom:10px;">Penyelenggara</h4>
                            @foreach($scholarships->pluck('provider')->unique() as $p)
                            <label style="display:flex;align-items:center;gap:10px;padding:7px 0;cursor:pointer;font-size:0.84rem;">
                                <input type="checkbox" style="accent-color:#047857;width:15px;height:15px;"> {{ $p }}
                            </label>
                            @endforeach
                        </div>
                        <button class="btn btn-primary w-full" style="width:100%;background:#047857;">Terapkan Filter</button>
                    </div>
                </div>
            </aside>

            <!-- Beasiswa List -->
            <div>
                <!-- Filter Tabs -->
                <div class="filter-pills" style="margin-bottom:20px;">
                    <button class="filter-pill active" style="--primary:#047857;">Semua <span class="count">500+</span></button>
                    <button class="filter-pill">Deadline Terdekat</button>
                    <button class="filter-pill">Pemerintah</button>
                    <button class="filter-pill">Swasta</button>
                    <button class="filter-pill">Luar Negeri</button>
                </div>

                <!-- Beasiswa Cards -->
                <div style="display:flex;flex-direction:column;gap:20px;">
                    @forelse($scholarships as $bs)
                    <div class="card" style="padding:24px;transition:var(--transition);" onmouseover="this.style.boxShadow='var(--shadow-md)';this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='';this.style.transform=''">
                        <div style="display:flex;gap:20px;align-items:flex-start;">
                            
                            <div style="flex:1;min-width:0;">
                                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;">
                                    <div>
                                        <div style="display:flex;gap:8px;margin-bottom:6px;flex-wrap:wrap;">
                                            <span style="background:{{ $bs->background_color }};color:{{ $bs->text_color }};padding:3px 10px;border-radius:20px;font-size:0.72rem;font-weight:700;">{{ $bs->scholarship_type }}</span>
                                            <span style="background:var(--gray-200);color:var(--gray-600);padding:3px 10px;border-radius:20px;font-size:0.72rem;font-weight:600;">{{ $bs->study_level }}</span>
                                        </div>
                                        <h3 style="font-size:0.95rem;font-weight:700;color:var(--dark);margin-bottom:4px;">{{ $bs->name }}</h3>
                                        <p style="font-size:0.82rem;color:var(--gray-600);">oleh {{ $bs->provider }}</p>
                                    </div>
                                    <div style="text-align:right;flex-shrink:0;">
                                        <div style="font-size:0.9rem;font-weight:800;color:{{ $bs->text_color }};">{{ $bs->amount }}</div>
                                        <div style="font-size:0.72rem;color:var(--gray-500);margin-top:2px;">{{ $bs->recipient_count }} penerima</div>
                                    </div>
                                </div>
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-top:14px;flex-wrap:wrap;gap:10px;">
                                    <div style="display:flex;align-items:center;gap:6px;font-size:0.8rem;color:var(--danger);font-weight:600;">
                                        
                                        Deadline: {{ $bs->deadline_label }}
                                    </div>
                                    <div style="display:flex;gap:8px;">
                                        <button style="padding:7px 16px;border:1px solid var(--gray-300);border-radius:8px;font-size:0.8rem;font-weight:600;color:var(--gray-600);background:white;cursor:pointer;display:flex;align-items:center;gap:4px;">
                                            
                                            Simpan
                                        </button>
                                        <a href="/beasiswa/detail" style="padding:7px 16px;background:{{ $bs->badge_color }};color:white;border-radius:8px;font-size:0.8rem;font-weight:700;display:flex;align-items:center;gap:4px;transition:var(--transition);" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                                            Lihat Detail
                                            
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="card" style="padding:24px;">Belum ada beasiswa yang tersedia.</div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <button class="page-btn disabled">‹</button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <span style="color:var(--gray-400);">...</span>
                    <button class="page-btn">25</button>
                    <button class="page-btn">›</button>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
