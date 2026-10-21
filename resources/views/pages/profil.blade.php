@extends('layouts.dashboard')

@section('title', 'Profil Saya - CampusFinder')
@php $activeMenu = 'profil'; @endphp

@section('content')
<div class="dashboard-header">
    <h1>Profil Saya</h1>
    <p>Informasi akun CampusFinder kamu.</p>
</div>

<div class="card" style="padding:24px;max-width:680px;">
    <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;">
        <div style="width:56px;height:56px;border-radius:50%;background:var(--primary);color:white;display:flex;align-items:center;justify-content:center;font-size:1.2rem;font-weight:800;">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
            <h2 style="font-size:1rem;font-weight:700;">{{ auth()->user()->name }}</h2>
            <p style="font-size:0.82rem;color:var(--gray-500);">{{ auth()->user()->email }}</p>
        </div>
    </div>
    <dl style="display:grid;grid-template-columns:160px 1fr;gap:14px;font-size:0.85rem;">
        <dt style="color:var(--gray-500);">Nomor HP</dt><dd>{{ auth()->user()->phone ?: 'Belum ditambahkan' }}</dd>
        <dt style="color:var(--gray-500);">Peran</dt><dd>{{ auth()->user()->role ? str_replace('_', ' ', ucfirst(auth()->user()->role)) : 'Belum dipilih' }}</dd>
    </dl>
</div>
@endsection
