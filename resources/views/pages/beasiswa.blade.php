@extends('layouts.app')

@section('title', 'Beasiswa - CampusFinder')

@section('content')
<section class="page-hero" style="background:linear-gradient(135deg,#064E3B 0%,#065F46 50%,#047857 100%);">
    <div class="container"><div class="page-hero-content">
        <div class="section-badge" style="display:inline-flex;background:rgba(255,255,255,.1);color:white;border:1px solid rgba(255,255,255,.2);">Beasiswa</div>
        <h1 class="page-hero-title">Temukan Beasiswa Impianmu</h1>
        <p class="page-hero-subtitle">Jelajahi {{ number_format($scholarships->total()) }} program beasiswa yang tersedia di katalog.</p>
        <form method="GET" action="{{ route('scholarships.index') }}" style="max-width:760px;margin:32px auto 0;display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
            <input type="search" name="q" value="{{ request('q') }}" aria-label="Cari nama beasiswa atau penyelenggara" placeholder="Cari beasiswa atau penyelenggara..." class="search-input" style="flex:1;min-width:220px;height:48px;border-radius:12px;border:none;padding:0 16px;">
            <select name="jenis" aria-label="Filter jenis beasiswa" style="height:48px;border-radius:12px;border:0;padding:0 14px;min-width:160px;"><option value="">Semua jenis</option>@foreach($scholarshipTypes as $type)<option value="{{ $type }}" @selected(request('jenis') === $type)>{{ $type }}</option>@endforeach</select>
            <select name="jenjang" aria-label="Filter jenjang" style="height:48px;border-radius:12px;border:0;padding:0 14px;min-width:140px;"><option value="">Semua jenjang</option>@foreach($studyLevels as $level)<option value="{{ $level }}" @selected(request('jenjang') === $level)>{{ $level }}</option>@endforeach</select>
            <button class="btn btn-accent" type="submit" style="height:48px;padding:0 24px;border-radius:12px;">Cari</button>
        </form>
    </div></div>
</section>

<section style="background:var(--gray-100);padding:40px 0;"><div class="container">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:20px;">
        <div><h2 style="font-size:1.2rem;font-weight:750;margin:0 0 4px;">Daftar beasiswa</h2><p style="color:var(--gray-600);font-size:.88rem;margin:0;">{{ number_format($scholarships->total()) }} hasil ditemukan</p></div>
        @if(request()->query())<a href="{{ route('scholarships.index') }}" style="font-size:.85rem;color:var(--primary);font-weight:650;">Hapus filter</a>@endif
    </div>
    <div style="display:flex;flex-direction:column;gap:16px;">
        @forelse($scholarships as $bs)
        <article class="card" style="padding:24px;">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;">
                <div style="flex:1;min-width:230px;">
                    <div style="display:flex;gap:8px;margin-bottom:8px;flex-wrap:wrap;"><span style="background:{{ $bs->background_color }};color:{{ $bs->text_color }};padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;">{{ $bs->scholarship_type }}</span><span style="background:var(--gray-200);color:var(--gray-600);padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:600;">{{ $bs->study_level }}</span></div>
                    <h3 style="font-size:1rem;font-weight:750;color:var(--dark);margin:0 0 4px;">{{ $bs->name }}</h3><p style="font-size:.84rem;color:var(--gray-600);margin:0;">Penyelenggara: {{ $bs->provider }}</p>
                </div>
                <div style="text-align:right;flex-shrink:0;"><div style="font-size:.95rem;font-weight:800;color:{{ $bs->text_color }};">{{ $bs->amount }}</div>@if($bs->recipient_count)<div style="font-size:.75rem;color:var(--gray-500);margin-top:3px;">{{ $bs->recipient_count }} penerima</div>@endif</div>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:16px;padding-top:14px;border-top:1px solid var(--gray-200);flex-wrap:wrap;gap:10px;">
                <div style="font-size:.82rem;color:var(--gray-700);font-weight:600;">Batas waktu: {{ $bs->deadline->format('d/m/Y') }}</div>
                <a href="{{ route('scholarships.show', $bs) }}" class="btn btn-primary" style="padding:8px 16px;border-radius:8px;font-size:.82rem;font-weight:700;">Lihat detail</a>
            </div>
        </article>
        @empty
        <div class="card" style="padding:32px;text-align:center;"><h3 style="font-size:1rem;font-weight:700;">Beasiswa belum ditemukan</h3><p style="color:var(--gray-600);margin:0;">Coba ubah kata kunci atau filter pencarian.</p></div>
        @endforelse
    </div>
    @include('partials.catalog-pagination', ['paginator' => $scholarships])
</div></section>
@endsection
