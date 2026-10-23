<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CampusFinder') – Temukan Kampus Impianmu</title>
    <meta name="description" content="@yield('meta_description', 'Platform terlengkap untuk mencari kampus terbaik di Indonesia.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/campusfinder-logo.png') }}">
{{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    {{-- Global CSS --}}
    <link rel="stylesheet" href="/css/campusfinder.css">

    {{-- Page-specific styles --}}
    @stack('styles')
</head>
<body class="{{ $bodyClass ?? '' }}">

    {{--
         NAVBAR PARTIAL

         Pass $navTransparent = true dari view untuk hero overlap
    --}}
    @include('partials.navbar')

    {{--
         MAIN CONTENT
          --}}
    <main id="main-content" role="main" tabindex="-1">
        @yield('content')
    </main>

    {{--
         FOOTER PARTIAL

         Pass $footerSimple = true dari view untuk versi ringkas
    --}}
    @include('partials.footer')

    {{--
         BACK TO TOP
          --}}
    <button id="backToTop"
            aria-label="Kembali ke atas"
            style="display:none;position:fixed;bottom:28px;right:28px;
                   width:44px;height:44px;border-radius:50%;
                   background:var(--primary);color:white;border:none;
                   box-shadow:var(--shadow-md);cursor:pointer;z-index:300;
                   align-items:center;justify-content:center;
                   transition:var(--transition);"
            onclick="window.scrollTo({top:0,behavior:'smooth'})">Ke atas</button>

    {{-- Global JS --}}
    <script src="/js/main.js"></script>

    {{-- Back to top script --}}
    <script>
    (function () {
        var btn = document.getElementById('backToTop');
        window.addEventListener('scroll', function () {
            btn.style.display = window.scrollY > 400 ? 'flex' : 'none';
        }, { passive: true });
    }());
    </script>

    {{-- Page-specific scripts --}}
    @stack('scripts')

</body>
</html>
