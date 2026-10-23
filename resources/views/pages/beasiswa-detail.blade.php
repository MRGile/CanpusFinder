@extends('layouts.app')

@section('title', $scholarship->name.' - Beasiswa CampusFinder')

@section('content')
<section class="page-hero" style="background:linear-gradient(135deg,#064E3B 0%,#065F46 50%,#047857 100%);">
    <div class="container"><div class="page-hero-content">
        <div class="section-badge" style="display:inline-flex;background:rgba(255,255,255,.1);color:white;border:1px solid rgba(255,255,255,.2);">Detail beasiswa</div>
        <h1 class="page-hero-title">{{ $scholarship->name }}</h1>
        <p class="page-hero-subtitle">Penyelenggara: {{ $scholarship->provider }}</p>
    </div></div>
</section>

<section style="background:var(--gray-100);padding:40px 0;"><div class="container" style="max-width:960px;">
    <p style="margin:0 0 18px;"><a href="{{ route('scholarships.index') }}" style="font-size:.88rem;color:var(--primary);font-weight:650;">&larr; Kembali ke daftar beasiswa</a></p>
    <article class="card" style="padding:clamp(20px,4vw,32px);">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:24px;">
            <div>
                <div style="display:flex;gap:8px;margin-bottom:10px;flex-wrap:wrap;">
                    <span style="background:{{ $scholarship->background_color }};color:{{ $scholarship->text_color }};padding:4px 11px;border-radius:20px;font-size:.76rem;font-weight:700;">{{ $scholarship->scholarship_type }}</span>
                    <span style="background:var(--gray-200);color:var(--gray-600);padding:4px 11px;border-radius:20px;font-size:.76rem;font-weight:600;">{{ $scholarship->study_level }}</span>
                </div>
                <h2 style="font-size:1.15rem;font-weight:750;margin:0;">Informasi beasiswa</h2>
            </div>
            <div style="font-size:1rem;font-weight:800;color:{{ $scholarship->text_color }};">{{ $scholarship->amount }}</div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;margin-bottom:24px;">
            <div style="padding:14px;background:var(--gray-100);border-radius:10px;"><div style="font-size:.75rem;color:var(--gray-500);margin-bottom:4px;">Batas waktu</div><div style="font-size:.88rem;font-weight:700;color:var(--dark);">{{ $scholarship->deadline->format('d/m/Y') }}</div></div>
            <div style="padding:14px;background:var(--gray-100);border-radius:10px;"><div style="font-size:.75rem;color:var(--gray-500);margin-bottom:4px;">Kampus yang bisa mendaftar</div><div style="font-size:.88rem;font-weight:700;color:var(--dark);">{{ $scholarship->eligibleUniversitiesLabel() }}</div></div>
            @if($scholarship->recipient_count)<div style="padding:14px;background:var(--gray-100);border-radius:10px;"><div style="font-size:.75rem;color:var(--gray-500);margin-bottom:4px;">Jumlah penerima</div><div style="font-size:.88rem;font-weight:700;color:var(--dark);">{{ $scholarship->recipient_count }}</div></div>@endif
        </div>

        @if($scholarship->description)
            <section style="margin-bottom:22px;"><h3 style="font-size:.95rem;font-weight:750;margin:0 0 8px;">Deskripsi</h3><div style="font-size:.9rem;line-height:1.7;color:var(--gray-700);white-space:pre-line;">{{ $scholarship->description }}</div></section>
        @endif
        @if($scholarship->requirements)
            <section style="margin-bottom:22px;"><h3 style="font-size:.95rem;font-weight:750;margin:0 0 8px;">Persyaratan</h3><div style="font-size:.9rem;line-height:1.7;color:var(--gray-700);white-space:pre-line;">{{ $scholarship->requirements }}</div></section>
        @endif
        @if($scholarship->benefits)
            <section style="margin-bottom:22px;"><h3 style="font-size:.95rem;font-weight:750;margin:0 0 8px;">Benefit</h3><div style="font-size:.9rem;line-height:1.7;color:var(--gray-700);white-space:pre-line;">{{ $scholarship->benefits }}</div></section>
        @endif
        @if($scholarship->required_documents)
            <section style="margin-bottom:22px;"><h3 style="font-size:.95rem;font-weight:750;margin:0 0 8px;">Dokumen yang dibutuhkan</h3><div style="font-size:.9rem;line-height:1.7;color:var(--gray-700);white-space:pre-line;">{{ $scholarship->required_documents }}</div></section>
        @endif

        <div style="padding-top:18px;border-top:1px solid var(--gray-200);">
            @if($scholarship->application_url)
                <a href="{{ $scholarship->application_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary">Info dan pendaftaran <span aria-hidden="true">↗</span></a>
            @else
                <span style="font-size:.85rem;color:var(--gray-500);">Tautan pendaftaran belum ditambahkan.</span>
            @endif
        </div>
    </article>
</div></section>
@endsection
