@extends('layouts.app')

@section('title', 'Bandingkan Universitas - CampusFinder')
@section('meta_description', 'Bandingkan informasi universitas yang kamu pilih.')

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="section-badge" style="display:inline-flex;background:rgba(255,255,255,0.1);color:white;border:1px solid rgba(255,255,255,0.2);">Perbandingan</div>
            <h1 class="page-hero-title">Bandingkan Universitas</h1>
            <p class="page-hero-subtitle">Pilih dua atau tiga universitas untuk melihat perbedaannya.</p>
        </div>
    </div>
</section>

<section style="background:var(--gray-100);padding:32px 0 48px;">
    <div class="container" style="max-width:1000px;">
        <form action="{{ route('campus.compare') }}" method="GET" class="card" style="padding:22px;margin-bottom:22px;">
            <h2 style="font-size:1rem;font-weight:700;margin-bottom:14px;">Pilih universitas</h2>
            @if($errors->any())<div role="alert" style="margin-bottom:14px;padding:11px 14px;border-radius:8px;background:#FEE2E2;color:#991B1B;">{{ $errors->first() }}</div>@endif
            @if($campuses->isNotEmpty())
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,210px),1fr));gap:12px;">
                @for($slot = 0; $slot < 3; $slot++)
                <div>
                    <label for="campus-{{ $slot + 1 }}" style="display:block;font-size:.82rem;font-weight:600;margin-bottom:6px;">Universitas {{ $slot + 1 }}{{ $slot < 2 ? ' (wajib)' : ' (opsional)' }}</label>
                    <select id="campus-{{ $slot + 1 }}" name="kampus[]" class="search-select" style="width:100%;height:44px;padding:0 12px;">
                        <option value="">Pilih universitas</option>
                        @foreach($campuses as $campus)
                        <option value="{{ $campus->slug }}" @selected(($selectedSlugs[$slot] ?? '') === $campus->slug)>{{ $campus->name }} · {{ $campus->city }}</option>
                        @endforeach
                    </select>
                </div>
                @endfor
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top:14px;">Bandingkan</button>
            @else
            <p style="color:var(--gray-600);">Belum ada data universitas untuk dibandingkan. Universitas akan muncul di sini setelah admin menambahkannya.</p>
            @endif
        </form>

        @if($selectedCampuses->count() >= 2)
        <div style="overflow-x:auto;background:white;border:1px solid var(--gray-200);border-radius:12px;">
            <table class="compare-table" style="min-width:620px;">
                <thead>
                    <tr>
                        <th>Kriteria</th>
                        @foreach($selectedCampuses as $campus)
                        <th>
                            <div style="display:flex;flex-direction:column;align-items:center;gap:6px;">
                                <div style="width:40px;height:40px;background:{{ $campus->logo_color }};color:{{ $campus->logo_text_color }};border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:800;">{{ $campus->abbreviation }}</div>
                                <span>{{ $campus->name }}</span>
                            </div>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Jenis</td>@foreach($selectedCampuses as $campus)<td>{{ $campus->type }}</td>@endforeach</tr>
                    <tr><td>Akreditasi</td>@foreach($selectedCampuses as $campus)<td>{{ $campus->accreditation }}</td>@endforeach</tr>
                    <tr><td>Kota</td>@foreach($selectedCampuses as $campus)<td>{{ $campus->city }}</td>@endforeach</tr>
                    <tr><td>Jumlah Program Studi</td>@foreach($selectedCampuses as $campus)<td>{{ $campus->program_count }}</td>@endforeach</tr>
                    <tr><td>Rating</td>@foreach($selectedCampuses as $campus)<td>{{ $campus->rating }}</td>@endforeach</tr>
                    <tr><td>Jumlah Ulasan</td>@foreach($selectedCampuses as $campus)<td>{{ number_format($campus->review_count) }}</td>@endforeach</tr>
                    <tr><td>Peringkat</td>@foreach($selectedCampuses as $campus)<td>{{ $campus->rank ?: 'Belum tersedia' }}</td>@endforeach</tr>
                    <tr><td></td>@foreach($selectedCampuses as $campus)<td><a href="/kampus/{{ $campus->slug }}" class="btn btn-primary btn-sm" style="width:100%;justify-content:center;">Lihat Detail</a></td>@endforeach</tr>
                </tbody>
            </table>
        </div>
        @elseif($selectedCampuses->count() === 1)
        <div class="card" role="status" style="padding:18px;color:var(--gray-600);">Pilih satu universitas lagi untuk menampilkan perbandingan.</div>
        @endif
    </div>
</section>
@endsection
