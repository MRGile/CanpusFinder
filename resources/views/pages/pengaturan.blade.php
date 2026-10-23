{{-- @extends('layouts.dashboard')

@section('title', 'Pengaturan - CampusFinder')
@php $activeMenu = 'pengaturan'; @endphp

@section('content')
<div class="dashboard-header">
    <h1>Pengaturan</h1>
    <p>Kelola informasi akun dan keamanan akunmu.</p>
</div>

<div class="card" style="padding:24px;max-width:680px;">
    <h2 style="font-size:1rem;font-weight:700;margin-bottom:16px;">Informasi akun</h2>
    <div style="display:flex;flex-direction:column;gap:14px;font-size:0.85rem;">
        <div style="display:flex;justify-content:space-between;gap:16px;border-bottom:1px solid var(--gray-200);padding-bottom:12px;">
            <span style="color:var(--gray-500);">Email akun</span><span>{{ auth()->user()->email }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;gap:16px;border-bottom:1px solid var(--gray-200);padding-bottom:12px;">
            <span style="color:var(--gray-500);">Kata sandi</span><span>••••••••</span>
        </div>
    </div>
    <a href="/profil" class="btn btn-primary" style="margin-top:20px;">Lihat Profil</a>
</div>
@endsection --}}
