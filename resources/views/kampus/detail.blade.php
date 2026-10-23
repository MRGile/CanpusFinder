@extends('layouts.app')

@section('title', $campus->name.' - Detail Kampus | CampusFinder')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb-section" style="margin-top:72px;">
    <div class="container">
        <div class="breadcrumb">
            <a href="/">Beranda</a>
            <span class="sep">/</span>
            <a href="/kampus">Cari Kampus</a>
            <span class="sep">/</span>
            <span class="current">{{ $campus->name }}</span>
        </div>
    </div>
</div>

<!-- Campus Hero Detail -->
<section class="campus-detail-hero" style="background: {{ $campus->cover_gradient }};{{ $campus->image_path ? 'background-image:linear-gradient(rgba(15,23,42,.72),rgba(15,23,42,.72)),url('.asset('storage/'.$campus->image_path).');background-size:cover;background-position:center;' : '' }} padding: 48px 0;">
    <div class="container">
        <div style="display:flex;align-items:flex-start;gap:32px;flex-wrap:wrap;">
            <!-- Logo -->
            <div style="width:100px;height:100px;background:white;border-radius:20px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:1.8rem;color:var(--primary);flex-shrink:0;box-shadow:0 8px 24px rgba(0,0,0,0.2);overflow:hidden;">@if($campus->logo_path)<img src="{{ asset('storage/'.$campus->logo_path) }}" alt="Logo {{ $campus->name }}" style="width:100%;height:100%;object-fit:contain;padding:10px;">@else{{ $campus->abbreviation }}@endif</div>
            <!-- Info -->
            <div style="flex:1;min-width:280px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;flex-wrap:wrap;">
                    <span class="campus-type-badge {{ $campus->typeBadgeClass() }}">{{ $campus->type }}</span>
                    <span style="background:rgba(255,255,255,0.1);color:white;padding:4px 12px;border-radius:20px;font-size:0.75rem;font-weight:600;">Akreditasi {{ $campus->accreditation }}</span>
                    @if($reviewCount)<span style="background:rgba(245,158,11,0.2);color:#FCD34D;padding:4px 12px;border-radius:20px;font-size:0.75rem;font-weight:600;">{{ number_format((float) $averageRating, 1) }} ({{ number_format($reviewCount) }} ulasan)</span>@endif
                </div>
                <h1 style="font-size:2rem;font-weight:800;color:white;margin-bottom:8px;">{{ $campus->name }}</h1>
                <p style="color:rgba(255,255,255,0.75);display:flex;align-items:center;gap:6px;font-size:0.9rem;margin-bottom:16px;">
                    
                    {{ $campus->city }}{{ $campus->province ? ', '.$campus->province : '' }}
                </p>
                <div style="display:flex;gap:24px;flex-wrap:wrap;">
                    <div>
                        <div style="font-size:1.3rem;font-weight:800;color:white;">{{ $campusContent->get('program', collect())->count() ?: $campus->program_count }}</div>
                        <div style="font-size:0.75rem;color:rgba(255,255,255,0.6);">Program Studi</div>
                    </div>
                    <div>
                        <div style="font-size:1.3rem;font-weight:800;color:white;">{{ $campus->rank ?? '—' }}</div>
                        <div style="font-size:0.75rem;color:rgba(255,255,255,0.6);">Peringkat</div>
                    </div>
                    <div>
                        <div style="font-size:1.3rem;font-weight:800;color:white;">{{ $reviewCount ? number_format((float) $averageRating, 1) : '—' }}</div>
                        <div style="font-size:0.75rem;color:rgba(255,255,255,0.6);">Rating</div>
                    </div>
                </div>
            </div>
            <!-- Actions -->
            <div style="display:flex;flex-direction:column;gap:10px;min-width:180px;">
                @if($campusContent->get('admission', collect())->isNotEmpty())<a href="#tab-pendaftaran" class="btn btn-accent" style="width:100%;justify-content:center;" onclick="document.querySelector('[data-tab=tab-pendaftaran]').click()">Lihat Pendaftaran</a>@elseif($campus->website)<a href="{{ $campus->website }}" target="_blank" rel="noopener" class="btn btn-accent" style="width:100%;justify-content:center;">Situs Resmi</a>@endif
                <a href="{{ route('campus.compare', ['kampus' => [$campus->slug]]) }}" class="btn" style="background:rgba(255,255,255,0.1);color:white;border:1px solid rgba(255,255,255,0.3);width:100%;justify-content:center;">
                    
                    Bandingkan
                </a>
                @auth<form method="POST" action="{{ route('campus.favorite.toggle', $campus->slug) }}">@csrf<button class="campus-fav-btn" type="submit" style="position:static;width:100%;border-radius:8px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.3);height:auto;padding:10px;color:white;display:flex;align-items:center;justify-content:center;gap:6px;font-size:0.85rem;font-weight:600;">Simpan</button></form>@else<a href="/masuk" class="btn" style="width:100%;justify-content:center;">Masuk untuk Simpan Favorit</a>@endauth
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section style="background:var(--gray-100);padding:32px 0;">
    <div class="container">
        <div class="detail-layout">

            <!-- Content Area -->
            <div>
                <!-- Tabs -->
                <div class="detail-tabs">
                    <div class="detail-tab active" data-tab="tab-overview">Overview</div>
                    <div class="detail-tab" data-tab="tab-prodi">Program Studi</div>
                    <div class="detail-tab" data-tab="tab-pendaftaran">Pendaftaran</div>
                    <div class="detail-tab" data-tab="tab-biaya">Biaya</div>
                    <div class="detail-tab" data-tab="tab-fasilitas">Fasilitas</div>
                    <div class="detail-tab" data-tab="tab-ulasan">Ulasan</div>
                </div>

                <!-- Tab: Overview -->
                <div class="tab-panel" id="tab-overview">
                    <!-- Tentang -->
                    @if($campusContent->get('highlight', collect())->isNotEmpty())<div class="card" style="padding:28px;margin-bottom:20px;">
                        <h2 style="font-size:1.1rem;font-weight:700;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                            <span style="color:var(--primary);"></span> Tentang {{ $campus->name }}
                        </h2>
                        <p style="color:var(--gray-700);line-height:1.8;font-size:0.9rem;margin-bottom:18px;">
                            {{ $campus->description ?: $campus->name.' adalah perguruan tinggi '.$campus->type.' yang berlokasi di '.$campus->city.($campus->province ? ', '.$campus->province : '').'. Informasi profil kampus akan diperbarui oleh administrator.' }}
                        </p>
                        @if($campus->founded_year || $campus->address || $campus->website || $campus->email || $campus->phone)
                        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;border-top:1px solid var(--gray-200);padding-top:16px;">
                            @if($campus->founded_year)<div><div style="font-size:.75rem;color:var(--gray-500);">Tahun berdiri</div><strong>{{ $campus->founded_year }}</strong></div>@endif
                            @if($campus->address)<div><div style="font-size:.75rem;color:var(--gray-500);">Alamat</div><span>{{ $campus->address }}</span></div>@endif
                            @if($campus->website)<div><div style="font-size:.75rem;color:var(--gray-500);">Situs web</div><a href="{{ $campus->website }}" target="_blank" rel="noopener">{{ $campus->website }}</a></div>@endif
                            @if($campus->email)<div><div style="font-size:.75rem;color:var(--gray-500);">Email</div><a href="mailto:{{ $campus->email }}">{{ $campus->email }}</a></div>@endif
                            @if($campus->phone)<div><div style="font-size:.75rem;color:var(--gray-500);">Telepon</div><a href="tel:{{ $campus->phone }}">{{ $campus->phone }}</a></div>@endif
                        </div>
                        @endif
                    </div>@endif

                    <!-- Keunggulan -->
                    <div class="card" style="padding:28px;margin-bottom:20px;">
                        <h2 style="font-size:1.1rem;font-weight:700;margin-bottom:16px;"> Keunggulan {{ $campus->name }}</h2>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                            @foreach($campusContent->get('highlight', collect()) as $item)
                            <div style="display:flex;align-items:center;gap:10px;background:var(--gray-100);border-radius:10px;padding:12px;">
                                
                                <span style="font-size:0.85rem;color:var(--dark);">{{ $item->title }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Info Singkat Grid -->
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:20px;">
                        @foreach($campusContent->get('fact', collect()) as $info)
                        <div class="card" style="padding:18px;text-align:center;">
                            
                            <div style="font-size:0.75rem;color:var(--gray-500);text-transform:uppercase;letter-spacing:0.5px;">{{ $info->title }}</div>
                            <div style="font-size:0.92rem;font-weight:700;color:var(--dark);margin-top:4px;">{{ $info->value }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tab: Program Studi -->
                <div class="tab-panel" id="tab-prodi" style="display:none;">
                    <div class="card" style="padding:28px;">
                        <h2 style="font-size:1.1rem;font-weight:700;margin-bottom:20px;">Program Studi</h2>
                        <div style="display:flex;flex-direction:column;gap:12px;">
                            @forelse($campusContent->get('program', collect()) as $program)
                            <div style="border:1px solid var(--gray-200);border-radius:12px;overflow:hidden;">
                                <div style="background:var(--gray-100);padding:14px 20px;display:flex;align-items:center;justify-content:space-between;">
                                    <span style="font-size:0.9rem;font-weight:700;">{{ $program->title }}</span>
                                    <span style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">@if($program->study_level)<span style="background:var(--primary);color:white;padding:3px 10px;border-radius:20px;font-size:0.75rem;font-weight:600;">{{ $program->study_level }}</span>@endif @if($program->faculty)<span style="background:var(--gray-200);color:var(--gray-700);padding:3px 10px;border-radius:20px;font-size:0.75rem;font-weight:600;">{{ $program->faculty->name }}</span>@endif</span>
                                </div>
                                @if($program->subtitle || $program->description || $program->value)<div style="padding:16px 20px;">@if($program->subtitle)<p style="margin:0 0 8px;color:var(--gray-600);">{{ $program->subtitle }}</p>@endif{{ $program->description }}@if($program->value)<span>{{ $program->value }}</span>@endif</div>@endif
                            </div>
                            @empty<div class="alert alert-light border mb-0">Informasi program studi belum tersedia.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Tab: Pendaftaran -->
                <div class="tab-panel" id="tab-pendaftaran" style="display:none;">
                    <div class="card" style="padding:28px;">
                        <h2 style="font-size:1.1rem;font-weight:700;margin-bottom:20px;"> Jalur Pendaftaran</h2>
                        <div style="display:flex;flex-direction:column;gap:16px;">
                            @forelse($campusContent->get('admission', collect()) as $route)
                            <div style="border:1px solid var(--gray-200);border-radius:12px;padding:20px;display:flex;align-items:center;gap:16px;">
                                <div style="width:10px;height:10px;background:var(--primary);border-radius:50%;flex-shrink:0;"></div>
                                <div style="flex:1;">
                                    <h4 style="font-size:0.92rem;font-weight:700;margin-bottom:4px;">{{ $route->title }}</h4>
                                    <p style="font-size:0.82rem;color:var(--gray-600);">{{ $route->description }}</p>
                                </div>
                                @if($route->subtitle)<span style="background:var(--primary-light);color:var(--primary);padding:5px 14px;border-radius:20px;font-size:0.75rem;font-weight:700;white-space:nowrap;">{{ $route->subtitle }}</span>@endif
                            </div>
                            @empty<div class="alert alert-light border mb-0">Informasi pendaftaran belum tersedia.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Tab: Biaya -->
                <div class="tab-panel" id="tab-biaya" style="display:none;">
                    <div class="card" style="padding:28px;">
                        <h2 style="font-size:1.1rem;font-weight:700;margin-bottom:20px;"> Estimasi Biaya Kuliah</h2>
                        @if($campusContent->get('cost', collect())->isNotEmpty())<table style="width:100%;border-collapse:collapse;margin-top:16px;">
                            <thead>
                                <tr style="background:var(--primary);color:white;">
                                    <th style="padding:12px 16px;text-align:left;font-size:0.85rem;">Kelompok UKT</th>
                                    <th style="padding:12px 16px;text-align:center;font-size:0.85rem;">Besaran UKT/Semester</th>
                                    <th style="padding:12px 16px;text-align:center;font-size:0.85rem;">Kriteria Penghasilan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($campusContent->get('cost', collect()) as $ukt)
                                <tr style="border-bottom:1px solid var(--gray-200);">
                                    <td style="padding:12px 16px;font-size:0.85rem;font-weight:600;">{{ $ukt->title }}</td>
                                    <td style="padding:12px 16px;font-size:0.85rem;text-align:center;color:var(--primary);font-weight:600;">{{ $ukt->value ?: $ukt->subtitle }}</td>
                                    <td style="padding:12px 16px;font-size:0.82rem;text-align:center;color:var(--gray-600);">{{ $ukt->description }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>@else<div class="alert alert-light border mb-0">Informasi biaya kuliah belum tersedia.</div>@endif
                    </div>
                </div>

                <!-- Tab: Fasilitas -->
                <div class="tab-panel" id="tab-fasilitas" style="display:none;">
                    <div class="card" style="padding:28px;">
                        <h2 style="font-size:1.1rem;font-weight:700;margin-bottom:20px;"> Fasilitas Kampus</h2>
                        @if($campusContent->get('facility', collect())->isNotEmpty())<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;">
                            @foreach($campusContent->get('facility', collect()) as $facility)
                            <div style="background:var(--gray-100);border-radius:12px;padding:16px;text-align:center;">
                                
                                <h4 style="font-size:0.85rem;font-weight:700;margin-bottom:4px;">{{ $facility->title }}</h4>
                                <p style="font-size:0.75rem;color:var(--gray-600);">{{ $facility->description }}</p>
                            </div>
                            @endforeach
                        </div>@else<div class="alert alert-light border mb-0">Informasi fasilitas belum tersedia.</div>@endif
                    </div>
                </div>

                <!-- Tab: Ulasan -->
                <div class="tab-panel" id="tab-ulasan" style="display:none;">
                    <div class="card" style="padding:28px;">
                        @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
                        <div style="display:flex;align-items:center;gap:32px;margin-bottom:28px;flex-wrap:wrap;">
                            <div style="text-align:center;">
                                <div style="font-size:4rem;font-weight:900;color:var(--dark);line-height:1;">{{ $reviewCount ? number_format((float) $averageRating, 1) : '—' }}</div>
                                <div style="font-size:0.8rem;color:var(--gray-600);">{{ number_format($reviewCount) }} ulasan pengguna</div>
                            </div>
                        </div>
                        @auth
                        <form method="POST" action="{{ route('campus.review.store', ['campus' => $campus->slug]) }}" class="border rounded-3 p-3 p-md-4 mb-4 bg-light">
                            @csrf
                            <h3 style="font-size:1rem;font-weight:700;margin-bottom:14px;">{{ $myReview ? 'Perbarui ulasan kamu' : 'Tulis ulasan' }}</h3>
                            @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
                            <label for="review-rating" class="form-label">Penilaian</label>
                            <select id="review-rating" name="rating" class="form-select mb-3" required style="max-width:240px;">
                                @foreach(range(5, 1) as $rating)<option value="{{ $rating }}" @selected((int) old('rating', $myReview?->rating ?? 5) === $rating)>{{ $rating }} dari 5 bintang</option>@endforeach
                            </select>
                            <label for="review-body" class="form-label">Ulasan kamu</label>
                            <textarea id="review-body" name="body" class="form-control" rows="4" minlength="10" maxlength="3000" required placeholder="Ceritakan pengalaman atau informasi yang bisa membantu calon mahasiswa.">{{ old('body', $myReview?->body) }}</textarea>
                            <div class="text-end mt-3"><button type="submit" class="btn btn-primary">{{ $myReview ? 'Simpan perubahan' : 'Kirim ulasan' }}</button></div>
                        </form>
                        @else
                        <div class="alert alert-light border"><a href="{{ route('login') }}">Masuk</a> untuk menulis ulasan kampus.</div>
                        @endauth
                        <div style="display:flex;flex-direction:column;gap:16px;">
                            @forelse($reviews as $review)
                            <div style="border:1px solid var(--gray-200);border-radius:12px;padding:20px;">
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <div style="width:40px;height:40px;background:var(--primary-light);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--primary);">{{ strtoupper(substr($review->user->name, 0, 1)) }}</div>
                                        <div>
                                            <div style="font-size:0.88rem;font-weight:700;">{{ $review->user->name }}</div>
                                            <div style="font-size:0.75rem;color:var(--gray-500);">{{ $review->created_at->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                    <div style="color:var(--accent);" aria-label="{{ $review->rating }} dari 5 bintang">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</div>
                                </div>
                                <p style="font-size:0.85rem;color:var(--gray-700);line-height:1.7;margin-bottom:0;">{{ $review->body }}</p>
                            </div>
                            @empty<div class="text-center text-secondary py-4">Belum ada ulasan untuk kampus ini.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="detail-sidebar">
                <!-- Quick Info Card -->
                <div class="sidebar-card">
                    <div class="sidebar-card-header">
                        <div class="sidebar-campus-logo">@if($campus->logo_path)<img src="{{ asset('storage/'.$campus->logo_path) }}" alt="Logo {{ $campus->name }}" style="width:100%;height:100%;object-fit:contain;background:white;border-radius:inherit;padding:5px;">@else{{ $campus->abbreviation }}@endif</div>
                        <h3 style="font-size:0.95rem;font-weight:700;margin-bottom:4px;">{{ $campus->name }}</h3>
                        <p style="font-size:0.78rem;opacity:0.85;">{{ $campus->city }}{{ $campus->province ? ', '.$campus->province : '' }}</p>
                    </div>
                    <div class="sidebar-card-body">
                        @foreach($campusContent->get('side_info', collect()) as $info)
                        <div class="sidebar-info-row">
                            
                            <span>{{ $info->title }}</span>
                            <strong>{{ $info->value }}</strong>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Apply CTA -->
                @if($campusContent->get('admission', collect())->isNotEmpty())<div class="sidebar-card" style="background: linear-gradient(135deg,var(--primary),var(--secondary));border:none;">
                    <div style="padding:24px;text-align:center;color:white;">
                        
                        <h3 style="font-size:1rem;font-weight:700;margin-bottom:8px;">Tertarik Kuliah di {{ $campus->abbreviation }}?</h3>
                        <p style="font-size:0.82rem;opacity:0.85;margin-bottom:16px;">Pelajari jalur masuk dan persyaratan pendaftaran</p>
                        <a href="#tab-pendaftaran" class="btn btn-white" style="width:100%;justify-content:center;" onclick="document.querySelector('[data-tab=tab-pendaftaran]').click()">Lihat Info Pendaftaran</a>
                    </div>
                </div>@endif

                <!-- Similar Campus -->
                <div class="sidebar-card">
                    <div style="padding:20px;">
                        <h4 style="font-size:0.9rem;font-weight:700;margin-bottom:16px;"> Kampus Serupa</h4>
                        @foreach($similarCampuses as $similarCampus)
                        <a href="/kampus/{{ $similarCampus->slug }}" style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--gray-200);">
                            <div style="width:36px;height:36px;background:white;border:1px solid var(--gray-200);border-radius:8px;display:flex;align-items:center;justify-content:center;overflow:hidden;font-weight:800;font-size:0.75rem;color:var(--primary);">@if($similarCampus->logo_path)<img src="{{ asset('storage/'.$similarCampus->logo_path) }}" alt="Logo {{ $similarCampus->name }}" style="width:100%;height:100%;object-fit:contain;padding:3px;">@else{{ $similarCampus->abbreviation }}@endif</div>
                            <div>
                                <div style="font-size:0.82rem;font-weight:600;color:var(--dark);">{{ $similarCampus->name }}</div>
                                <div style="font-size:0.72rem;color:var(--gray-500);">{{ $similarCampus->city }}</div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-sm" style="background:var(--gray-100);">
    <div class="container">
        <div style="margin-bottom:18px;">
            <h2 style="font-size:1.35rem;font-weight:700;color:var(--dark);">Fakultas di {{ $campus->name }}</h2>
            <p style="color:var(--gray-600);margin-top:5px;">Daftar fakultas yang tersedia di universitas ini.</p>
        </div>
        @if($faculties->isNotEmpty())
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,260px),1fr));gap:14px;">
            @foreach($faculties as $faculty)
            <article class="card" style="padding:18px;border-left:3px solid var(--primary);">
                <h3 style="font-size:1rem;font-weight:700;margin:0;"><a href="{{ route('faculties.show', ['campus' => $campus->slug, 'faculty' => $faculty]) }}" style="color:var(--dark);text-decoration:none;">{{ $faculty->name }}</a></h3>
                @if($faculty->description)<p style="margin-top:7px;color:var(--gray-600);font-size:.88rem;">{{ \Illuminate\Support\Str::limit($faculty->description, 180) }}</p>@endif
                @if($faculty->dean)<p style="margin:8px 0 0;color:var(--gray-600);font-size:.84rem;">Dekan: <strong style="color:var(--dark);">{{ $faculty->dean }}</strong></p>@endif
                @if($faculty->email)<a style="display:block;margin-top:6px;font-size:.84rem;" href="mailto:{{ $faculty->email }}">{{ $faculty->email }}</a>@endif
                @if($faculty->phone)<a style="display:block;margin-top:4px;font-size:.84rem;" href="tel:{{ $faculty->phone }}">{{ $faculty->phone }}</a>@endif
                @if($faculty->website)<a style="display:block;margin-top:4px;font-size:.84rem;" href="{{ $faculty->website }}" target="_blank" rel="noopener">Situs fakultas</a>@endif
                <a href="{{ route('faculties.show', ['campus' => $campus->slug, 'faculty' => $faculty]) }}" class="btn btn-outline-primary btn-sm" style="margin-top:14px;align-self:flex-start;">Lihat detail fakultas</a>
            </article>
            @endforeach
        </div>
        @else
        <div class="card" style="padding:22px;color:var(--gray-600);">Informasi fakultas belum tersedia.</div>
        @endif
    </div>
</section>

@endsection
