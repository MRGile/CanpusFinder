@extends('layouts.dashboard')

@section('title', 'Notifikasi - CampusFinder')
@php $activeMenu = 'notifikasi'; @endphp

@section('content')
<div class="dashboard-header">
    <h1>Notifikasi</h1>
    <p>Informasi terbaru terkait kampus dan beasiswa.</p>
</div>

<div style="display:flex;flex-direction:column;gap:12px;">
    @forelse($notifications as $notification)
    <div class="card" style="display:flex;gap:14px;padding:18px;">
        
        <div>
            <h2 style="font-size:0.9rem;font-weight:700;margin-bottom:5px;">{{ $notification->title }}</h2>
            <p style="font-size:0.82rem;color:var(--gray-600);margin-bottom:7px;">{{ $notification->body }}</p>
            <span style="font-size:0.72rem;color:var(--gray-500);">{{ $notification->category }}</span>
        </div>
    </div>
    @empty
    <div class="card" style="padding:20px;">Belum ada notifikasi.</div>
    @endforelse
</div>
@endsection
