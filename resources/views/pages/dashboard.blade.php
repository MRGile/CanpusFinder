@extends('layouts.dashboard')

@section('title', 'Dashboard - CampusFinder')
@php $activeMenu = 'dashboard'; @endphp

@section('content')
<div class="dashboard-header">
    <h1>Dashboard</h1>
    <p>Selamat datang kembali! Berikut ringkasan aktivitas kampus favoritmu.</p>
</div>

<div class="dashboard-grid">
    <div class="dashboard-stat-card">
        
        <div><h3 style="color:#1D4ED8;">{{ $favoriteCount }}</h3><p>Kampus Favorit</p></div>
    </div>
    <div class="dashboard-stat-card">
        
        <div><h3 style="color:#166534;">{{ $campusCount }}</h3><p>Kampus di Katalog</p></div>
    </div>
    <div class="dashboard-stat-card">
        
        <div><h3 style="color:#B45309;">{{ $scholarshipCount }}</h3><p>Beasiswa Tersedia</p></div>
    </div>
</div>

<div class="card" style="padding:24px;margin-bottom:24px;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <h2 style="font-size:1rem;font-weight:700;"> Kampus Favorit Terakhir Dilihat</h2>
        <a href="/favorit" style="font-size:0.82rem;color:var(--primary);font-weight:600;">Lihat Semua </a>
    </div>
    <div style="display:flex;flex-direction:column;gap:12px;">
        @forelse($favoriteCampuses as $campus)
        <div style="display:flex;align-items:center;gap:14px;padding:12px;background:var(--gray-100);border-radius:10px;">
            <div style="width:40px;height:40px;border-radius:10px;background:{{ $campus->logo_color }};color:{{ $campus->logo_text_color }};display:flex;align-items:center;justify-content:center;font-weight:800;font-size:0.82rem;flex-shrink:0;overflow:hidden;">@if($campus->logo_path)<img src="{{ asset('storage/'.$campus->logo_path) }}" alt="Logo {{ $campus->name }}" style="width:100%;height:100%;object-fit:contain;padding:3px;">@else{{ $campus->abbreviation }}@endif</div>
            <div style="flex:1;">
                <div style="font-size:0.88rem;font-weight:700;">{{ $campus->name }}</div>
                <div style="font-size:0.75rem;color:var(--gray-500);">{{ $campus->city }} · {{ $campus->accreditation }}</div>
            </div>
            <a href="/kampus/{{ $campus->slug }}" style="font-size:0.78rem;color:var(--primary);font-weight:600;white-space:nowrap;">Lihat </a>
        </div>
        @empty
        <div style="padding:12px;background:var(--gray-100);border-radius:10px;color:var(--gray-600);">Kamu belum menyimpan kampus favorit.</div>
        @endforelse
    </div>
</div>

<div class="card" style="padding:24px;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <h2 style="font-size:1rem;font-weight:700;"> Beasiswa</h2>
        <a href="/beasiswa" style="font-size:0.82rem;color:var(--primary);font-weight:600;">Lihat Semua </a>
    </div>
    <div style="display:flex;flex-direction:column;gap:10px;">
        @forelse($scholarships as $scholarship)
        <div style="display:flex;align-items:center;gap:12px;padding:12px;border:1px solid var(--gray-200);border-radius:10px;">
            
            <div style="flex:1;">
                <div style="font-size:0.87rem;font-weight:600;">{{ $scholarship->name }}</div>
                <div style="font-size:0.75rem;color:var(--gray-500);">Deadline: {{ $scholarship->deadline->format('d/m/Y') }}</div>
            </div>
            <span style="background:{{ $scholarship->background_color }};color:{{ $scholarship->text_color }};padding:3px 10px;border-radius:20px;font-size:0.72rem;font-weight:700;">{{ $scholarship->scholarship_type }}</span>
        </div>
        @empty
        <div style="padding:12px;background:var(--gray-100);border-radius:10px;color:var(--gray-600);">Belum ada data beasiswa.</div>
        @endforelse
    </div>
</div>
@endsection
