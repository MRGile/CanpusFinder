<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CampusFinder') – Temukan Kampus Impianmu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/campusfinder-logo.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/campusfinder.css">
    @stack('styles')
</head>
<body>

    {{-- Auth pages: simple top bar --}}
    <header style="position:fixed;top:0;left:0;right:0;height:64px;background:white;
                   border-bottom:1px solid var(--gray-200);z-index:1000;display:flex;
                   align-items:center;justify-content:space-between;padding:0 32px;
                   box-shadow:var(--shadow-sm);">
        <a href="/" class="navbar-brand">
            <img class="brand-logo" src="{{ asset('images/campusfinder-logo.png') }}" alt="" width="42" height="42">
            Campus<span class="highlight">Finder</span>
        </a>
        <div style="display:flex;align-items:center;gap:12px;">
            <a href="/" style="font-size:0.85rem;color:var(--gray-600);display:flex;align-items:center;gap:6px;">
                
                Kembali ke Beranda
            </a>
        </div>
    </header>

    <main role="main" style="margin-top:64px;">
        @yield('content')
    </main>

    {{-- Simple footer --}}
    @php $footerSimple = true; @endphp
    @include('partials.footer')

    <script src="/js/main.js"></script>
    @stack('scripts')
</body>
</html>
