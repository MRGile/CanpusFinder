@extends('layouts.app')

@section('title', 'Blog - CampusFinder')

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="section-badge"> Blog CampusFinder</div>
            <h1 class="page-hero-title">Panduan untuk Langkah Berikutnya</h1>
            <p class="page-hero-subtitle">Baca informasi dan tips seputar kuliah, kampus, serta beasiswa.</p>
        </div>
    </div>
</section>

<section style="background:var(--gray-100);padding:40px 0;">
    <div class="container">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:20px;">
            @forelse($articles as $article)
            <article class="card" style="padding:0;overflow:hidden;">
                @if($article->image_path)<img src="{{ asset('storage/'.$article->image_path) }}" alt="{{ $article->title }}" style="width:100%;height:190px;object-fit:cover;">@endif
                <div style="padding:24px;">
                <p style="font-size:0.75rem;color:var(--primary);font-weight:700;margin-bottom:8px;">{{ $article->category }}</p>
                <h2 style="font-size:1rem;font-weight:700;line-height:1.5;margin-bottom:12px;">{{ $article->title }}</h2>
                <p style="font-size:0.78rem;color:var(--gray-500);">{{ Illuminate\Support\Carbon::parse($article->published_at)->translatedFormat('d F Y') }}</p>
                </div>
            </article>
            @empty
            <div class="card" style="padding:24px;">Belum ada artikel.</div>
            @endforelse
        </div>
    </div>
</section>
@endsection
