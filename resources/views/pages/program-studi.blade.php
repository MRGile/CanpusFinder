@extends('layouts.app')

@section('title', 'Program Studi - CampusFinder')

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="section-badge"> Program Studi</div>
            <h1 class="page-hero-title">Temukan Program Studi yang Tepat</h1>
            <p class="page-hero-subtitle">Jelajahi {{ number_format($programs->total()) }} program studi yang tersedia di katalog dan temukan bidang yang sesuai dengan minatmu.</p>
        </div>
    </div>
</section>

<section style="background:var(--gray-100);padding:40px 0;">
    <div class="container">
        <div class="card" style="padding:24px;margin-bottom:24px;">
            <form action="/program-studi" method="GET" style="display:flex;gap:12px;flex-wrap:wrap;">
                <input class="search-input" type="search" name="nama" value="{{ request('nama', isset($selectedProgram) ? str_replace('-', ' ', $selectedProgram) : '') }}" placeholder="Cari program studi..." style="flex:1;min-width:220px;">
                <button class="btn btn-primary" type="submit">Cari Program Studi</button>
            </form>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:20px;">
            @forelse($programs as $program)
            <a href="{{ route('programs.show', $program->slug) }}" class="card" style="padding:22px;display:flex;gap:14px;align-items:flex-start;color:inherit;text-decoration:none;transition:transform .16s ease,box-shadow .16s ease;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
                <div><h2 style="font-size:1rem;font-weight:700;margin:0 0 6px;">{{ $program->name }}</h2>
                    <p style="font-size:0.82rem;color:var(--gray-600);margin:0;">{{ $program->category }}</p>
                    <p style="font-size:.78rem;color:var(--gray-500);margin:8px 0 0;">{{ $program->university_count }} universitas</p>
                </div>
                <span aria-hidden="true" style="margin-left:auto;color:var(--primary);font-weight:700;white-space:nowrap;">Lihat detail →</span>
            </a>
            @empty
            <div class="card" style="padding:22px;">Program studi tidak ditemukan.</div>
            @endforelse
        </div>
        @include('partials.catalog-pagination', ['paginator' => $programs])
    </div>
</section>
@endsection
