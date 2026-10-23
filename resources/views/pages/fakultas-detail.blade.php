@extends('layouts.app')

@section('title', $faculty->name.' - '.$campus->name.' | CampusFinder')

@section('content')
<section class="page-hero" style="background:linear-gradient(135deg,#1E3A5F 0%,#1D4ED8 100%);">
    <div class="container"><div class="page-hero-content">
        <p style="margin:0 0 8px;"><a href="{{ url('/kampus/'.$campus->slug) }}" style="color:rgba(255,255,255,.85);font-size:.86rem;">{{ $campus->name }}</a></p>
        <h1 class="page-hero-title">{{ $faculty->name }}</h1>
        <p class="page-hero-subtitle">Informasi fakultas di {{ $campus->name }}.</p>
    </div></div>
</section>

<section style="background:var(--gray-100);padding:40px 0;"><div class="container" style="max-width:960px;">
    <p style="margin:0 0 18px;"><a href="{{ url('/kampus/'.$campus->slug) }}" style="font-size:.88rem;color:var(--primary);font-weight:650;">&larr; Kembali ke halaman {{ $campus->abbreviation }}</a></p>
    <article class="card" style="padding:clamp(20px,4vw,32px);">
        <h2 style="font-size:1.15rem;font-weight:750;margin:0 0 18px;">Profil fakultas</h2>

        @if($faculty->description)
            <p style="font-size:.95rem;line-height:1.8;color:var(--gray-700);white-space:pre-line;margin:0 0 24px;">{{ $faculty->description }}</p>
        @else
            <p style="font-size:.9rem;color:var(--gray-600);margin:0 0 24px;">Deskripsi fakultas belum tersedia.</p>
        @endif

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:14px;">
            @if($faculty->dean)
                <div style="padding:16px;background:var(--gray-100);border-radius:10px;"><h3 style="font-size:.8rem;color:var(--gray-500);font-weight:600;margin:0 0 5px;">Dekan</h3><p style="font-size:.9rem;color:var(--dark);font-weight:700;margin:0;">{{ $faculty->dean }}</p></div>
            @endif
            @if($faculty->email)
                <div style="padding:16px;background:var(--gray-100);border-radius:10px;"><h3 style="font-size:.8rem;color:var(--gray-500);font-weight:600;margin:0 0 5px;">Email</h3><a href="mailto:{{ $faculty->email }}" style="font-size:.9rem;font-weight:650;overflow-wrap:anywhere;">{{ $faculty->email }}</a></div>
            @endif
            @if($faculty->phone)
                <div style="padding:16px;background:var(--gray-100);border-radius:10px;"><h3 style="font-size:.8rem;color:var(--gray-500);font-weight:600;margin:0 0 5px;">Telepon</h3><a href="tel:{{ $faculty->phone }}" style="font-size:.9rem;font-weight:650;">{{ $faculty->phone }}</a></div>
            @endif
            @if($faculty->website)
                <div style="padding:16px;background:var(--gray-100);border-radius:10px;"><h3 style="font-size:.8rem;color:var(--gray-500);font-weight:600;margin:0 0 5px;">Situs fakultas</h3><a href="{{ $faculty->website }}" target="_blank" rel="noopener noreferrer" style="font-size:.9rem;font-weight:650;overflow-wrap:anywhere;">Kunjungi situs resmi</a></div>
            @endif
        </div>
    </article>
</div></section>
@endsection
