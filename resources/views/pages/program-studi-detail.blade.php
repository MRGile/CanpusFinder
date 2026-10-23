@extends('layouts.app')

@section('title', $program->title.' - Program Studi | CampusFinder')
@section('meta_description', 'Informasi '.$program->title.' dan universitas yang menawarkan program studi ini.')

@section('content')
<div class="breadcrumb-section" style="margin-top:72px;">
    <div class="container"><div class="breadcrumb"><a href="/">Beranda</a><span class="sep">/</span><a href="{{ route('programs.index') }}">Program Studi</a><span class="sep">/</span><span class="current">{{ $program->title }}</span></div></div>
</div>

<section class="page-hero"><div class="container"><div class="page-hero-content">
    <div class="section-badge">Program Studi</div>
    <h1 class="page-hero-title">{{ $program->title }}</h1>
    <p class="page-hero-subtitle">Tersedia di {{ $campusPrograms->pluck('campus_id')->unique()->count() }} universitas yang terdaftar di CampusFinder.</p>
</div></div></section>

<section style="background:var(--gray-100);padding:40px 0;"><div class="container">
    @php($descriptions = $campusPrograms->pluck('description')->filter()->unique())
    @if($descriptions->isNotEmpty())
    <section class="card" style="padding:26px;margin-bottom:24px;">
        <h2 style="font-size:1.1rem;font-weight:750;margin:0 0 12px;">Tentang program ini</h2>
        @foreach($descriptions as $description)<p style="line-height:1.75;color:var(--gray-700);margin:0 0 10px;">{{ $description }}</p>@endforeach
    </section>
    @endif

    <div style="display:flex;align-items:end;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:18px;">
        <div><h2 style="font-size:1.2rem;font-weight:750;margin:0 0 4px;">Universitas yang menawarkan</h2><p style="font-size:.88rem;color:var(--gray-600);margin:0;">{{ $campusPrograms->pluck('campus_id')->unique()->count() }} universitas</p></div>
        <a href="{{ route('programs.index') }}" class="btn btn-secondary">Kembali ke semua program studi</a>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,320px),1fr));gap:16px;">
        @foreach($campusPrograms->unique('campus_id') as $campusProgram)
        <article class="card" style="padding:22px;">
            <h3 style="font-size:1rem;font-weight:750;margin:0 0 5px;"><a href="{{ url('/kampus/'.$campusProgram->campus->slug) }}" style="color:var(--dark);text-decoration:none;">{{ $campusProgram->campus->name }}</a></h3>
            <p style="font-size:.84rem;color:var(--gray-600);margin:0 0 14px;">{{ $campusProgram->campus->city }}{{ $campusProgram->campus->province ? ', '.$campusProgram->campus->province : '' }}</p>
            @if($campusProgram->study_level)<p style="font-size:.86rem;margin:0 0 8px;"><strong>Jenjang:</strong> {{ $campusProgram->study_level }}</p>@endif
            @if($campusProgram->faculty)<p style="font-size:.86rem;margin:0 0 8px;"><strong>Fakultas:</strong> {{ $campusProgram->faculty->name }}</p>@endif
            @if($campusProgram->subtitle)<p style="font-size:.86rem;margin:0 0 8px;"><strong>Keterangan:</strong> {{ $campusProgram->subtitle }}</p>@endif
            @if($campusProgram->description)<p style="font-size:.86rem;line-height:1.65;color:var(--gray-700);margin:0 0 8px;">{{ $campusProgram->description }}</p>@endif
            @if($campusProgram->value)<p style="font-size:.86rem;margin:0 0 14px;"><strong>Keterangan:</strong> {{ $campusProgram->value }}</p>@endif
            <a href="{{ url('/kampus/'.$campusProgram->campus->slug) }}" class="btn btn-primary btn-sm" style="align-self:flex-start;">Lihat profil universitas</a>
        </article>
        @endforeach
    </div>
</div></section>
@endsection
