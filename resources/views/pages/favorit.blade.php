@extends('layouts.dashboard')

@section('title', 'Kampus Favorit - CampusFinder')
@php $activeMenu = 'favorit'; @endphp

@section('content')
<div class="dashboard-header">
    <h1>Kampus Favorit</h1>
    <p>Daftar kampus yang kamu simpan untuk dibandingkan nanti.</p>
</div>

<div style="display:flex;flex-direction:column;gap:12px;">
    @forelse($campuses as $campus)
    <div class="card" style="display:flex;align-items:center;gap:14px;padding:16px;">
        <div style="width:44px;height:44px;border-radius:10px;background:{{ $campus->logo_color }};color:{{ $campus->logo_text_color }};display:flex;align-items:center;justify-content:center;font-weight:800;font-size:0.82rem;flex-shrink:0;overflow:hidden;">@if($campus->logo_path)<img src="{{ asset('storage/'.$campus->logo_path) }}" alt="Logo {{ $campus->name }}" style="width:100%;height:100%;object-fit:contain;padding:3px;">@else{{ $campus->abbreviation }}@endif</div>
        <div style="flex:1;">
            <h2 style="font-size:0.9rem;font-weight:700;">{{ $campus->name }}</h2>
            <p style="font-size:0.78rem;color:var(--gray-500);">{{ $campus->city }} · Akreditasi {{ $campus->accreditation }}</p>
        </div>
        <a href="/kampus/{{ $campus->slug }}" class="btn btn-primary btn-sm">Lihat Detail</a>
        <form method="POST" action="{{ route('campus.favorite.toggle', $campus->slug) }}">@csrf<button class="btn btn-sm" type="submit">Hapus</button></form>
    </div>
    @empty
    <div class="card" style="padding:20px;">Belum ada kampus favorit. Simpan kampus dari halaman katalog.</div>
    @endforelse
</div>
@endsection
