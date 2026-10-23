{{--
    PARTIAL: Navbar
    Usage: @include('partials.navbar')

    Props via $navTransparent (bool) - jika true, navbar transparan di atas hero
--}}

@php
    $currentRoute = request()->path();
@endphp

<nav class="navbar {{ isset($navTransparent) && $navTransparent ? 'navbar--transparent' : '' }}" id="navbar" role="navigation" aria-label="Navigasi utama">
    <div class="container">
        <div class="navbar-inner">

            {{--  BRAND  --}}
            <a href="/" class="navbar-brand" aria-label="CampusFinder - Halaman Utama">
                <img class="brand-logo" src="{{ asset('images/campusfinder-logo.png') }}" alt="" width="42" height="42">
                Campus<span class="highlight">Finder</span>
            </a>

            {{--  DESKTOP NAV  --}}
            <ul class="navbar-nav" role="menubar">
                <li role="none">
                    <a href="/" role="menuitem" class="{{ $currentRoute === '/' ? 'active' : '' }}" @if($currentRoute === '/') aria-current="page" @endif>Beranda</a>
                </li>
                <li role="none">
                    <a href="/kampus" role="menuitem" class="{{ request()->is('kampus*') ? 'active' : '' }}" @if(request()->is('kampus*')) aria-current="page" @endif>Cari Kampus</a>
                </li>
                <li role="none">
                    <a href="/program-studi" role="menuitem" class="{{ request()->is('program-studi*') ? 'active' : '' }}" @if(request()->is('program-studi*')) aria-current="page" @endif>Program Studi</a>
                </li>
                <li role="none">
                    <a href="/beasiswa" role="menuitem" class="{{ request()->is('beasiswa*') ? 'active' : '' }}" @if(request()->is('beasiswa*')) aria-current="page" @endif>Beasiswa</a>
                </li>
                <li role="none">
                    <a href="/bandingkan" role="menuitem" class="{{ request()->is('bandingkan*') ? 'active' : '' }}" @if(request()->is('bandingkan*')) aria-current="page" @endif>Bandingkan</a>
                </li>
                <li role="none">
                    <a href="/blog" role="menuitem" class="{{ request()->is('blog*') ? 'active' : '' }}" @if(request()->is('blog*')) aria-current="page" @endif>Blog</a>
                </li>
            </ul>

            {{--  ACTIONS  --}}
            <div class="navbar-actions">
                @auth
                    {{-- Logged-in: Avatar dropdown --}}
                    <div class="nav-user-menu" style="position:relative;">
                        <button class="nav-user-btn" id="userMenuBtn"
                                aria-haspopup="true" aria-expanded="false"
                                style="display:flex;align-items:center;gap:10px;padding:6px 14px 6px 6px;
                                       border-radius:50px;border:1.5px solid var(--gray-300);background:white;
                                       cursor:pointer;transition:var(--transition);"
                                onmouseover="this.style.borderColor='var(--primary)'"
                                onmouseout="this.style.borderColor='var(--gray-300)'">
                            <div style="width:32px;height:32px;border-radius:50%;background:var(--primary);
                                        color:white;display:flex;align-items:center;justify-content:center;
                                        font-weight:700;font-size:0.85rem;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span style="font-size:0.85rem;font-weight:600;color:var(--dark);">
                                {{ Str::limit(auth()->user()->name, 12) }}
                            </span>
                            
                        </button>

                        {{-- Dropdown --}}
                        <div class="nav-user-dropdown" id="userDropdown"
                             style="display:none;position:absolute;right:0;top:calc(100% + 8px);
                                    min-width:200px;background:white;border-radius:14px;
                                    box-shadow:var(--shadow-lg);border:1px solid var(--gray-200);
                                    overflow:hidden;z-index:1000;">
                            <div style="padding:14px 16px;border-bottom:1px solid var(--gray-200);
                                        background:var(--gray-100);">
                                <div style="font-size:0.85rem;font-weight:700;color:var(--dark);">
                                    {{ auth()->user()->name }}
                                </div>
                                <div style="font-size:0.75rem;color:var(--gray-500);margin-top:2px;">
                                    {{ auth()->user()->email }}
                                </div>
                            </div>
                            <a href="/profil"
                               style="display:flex;align-items:center;gap:12px;padding:12px 16px;
                                      font-size:0.85rem;color:var(--gray-700);transition:background 0.2s;"
                               onmouseover="this.style.background='var(--gray-100)'"
                               onmouseout="this.style.background=''">
                                
                                Profil Saya
                            </a>
                            <a href="/favorit" style="display:flex;align-items:center;gap:12px;padding:12px 16px;font-size:0.85rem;color:var(--gray-700);transition:background 0.2s;" onmouseover="this.style.background='var(--gray-100)'" onmouseout="this.style.background=''">Favorit</a>
                            <a href="/notifikasi" style="display:flex;align-items:center;gap:12px;padding:12px 16px;font-size:0.85rem;color:var(--gray-700);transition:background 0.2s;" onmouseover="this.style.background='var(--gray-100)'" onmouseout="this.style.background=''">Notifikasi</a>
                            <a href="/dashboard" style="display:flex;align-items:center;gap:12px;padding:12px 16px;font-size:0.85rem;color:var(--gray-700);transition:background 0.2s;" onmouseover="this.style.background='var(--gray-100)'" onmouseout="this.style.background=''">Dashboard</a>
                            <div style="border-top:1px solid var(--gray-200);">
                                <form method="POST" action="/keluar">
                                    @csrf
                                    <button type="submit"
                                            style="display:flex;align-items:center;gap:12px;width:100%;
                                                   padding:12px 16px;font-size:0.85rem;color:var(--danger);
                                                   background:none;border:none;cursor:pointer;text-align:left;
                                                   transition:background 0.2s;"
                                            onmouseover="this.style.background='#FEE2E2'"
                                            onmouseout="this.style.background=''">
                                        
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="/masuk"  class="btn-nav-login">Masuk</a>
                    <a href="/daftar" class="btn-nav-register">Daftar Gratis</a>
                @endauth
            </div>

            {{--  HAMBURGER  --}}
            <button class="navbar-toggler" id="navToggler"
                    aria-label="Buka menu" aria-controls="mobileMenu" aria-expanded="false">Menu</button>

        </div>{{-- /.navbar-inner --}}
    </div>{{-- /.container --}}
</nav>

{{--  MOBILE MENU  --}}
<div class="mobile-menu" id="mobileMenu" role="dialog" aria-label="Menu navigasi mobile">
    <a href="/" class="{{ $currentRoute === '/' ? 'active' : '' }}">Beranda</a>
    <a href="/kampus" class="{{ request()->is('kampus*') ? 'active' : '' }}">Cari Kampus</a>
    <a href="/program-studi" class="{{ request()->is('program-studi*') ? 'active' : '' }}">Program Studi</a>
    <a href="/beasiswa" class="{{ request()->is('beasiswa*') ? 'active' : '' }}">Beasiswa</a>
    <a href="/bandingkan" class="{{ request()->is('bandingkan*') ? 'active' : '' }}">Bandingkan</a>
    <a href="/blog" class="{{ request()->is('blog*') ? 'active' : '' }}">Blog</a>

    <div class="mobile-menu-actions">
        @auth
            <a href="/profil" class="btn-nav-login" style="flex:1;text-align:center;">Profil</a>
            <form method="POST" action="/keluar" style="flex:1;">
                @csrf
                <button type="submit" class="btn-nav-register" style="width:100%;">Keluar</button>
            </form>
        @else
            <a href="/masuk"  class="btn-nav-login">Masuk</a>
            <a href="/daftar" class="btn-nav-register">Daftar</a>
        @endauth
    </div>
</div>

{{--  NAVBAR EXTRA STYLES  --}}
<style>
/* Transparent variant (di atas hero gelap) */
.navbar--transparent:not(.scrolled) {
    background: transparent;
    border-bottom-color: rgba(255,255,255,0.12);
}
.navbar--transparent:not(.scrolled) .navbar-brand { color: white; }
.navbar--transparent:not(.scrolled) .brand-icon   { background: rgba(255,255,255,0.2); }
.navbar--transparent:not(.scrolled) .navbar-nav a { color: rgba(255,255,255,0.85); }
.navbar--transparent:not(.scrolled) .navbar-nav a:hover,
.navbar--transparent:not(.scrolled) .navbar-nav a.active { color: white; }
.navbar--transparent:not(.scrolled) .navbar-nav a::after { background: white; }
.navbar--transparent:not(.scrolled) .btn-nav-login  { color: white; border-color: rgba(255,255,255,0.5); }
.navbar--transparent:not(.scrolled) .btn-nav-login:hover { background: rgba(255,255,255,0.1); }
.navbar--transparent:not(.scrolled) .btn-nav-register { background: rgba(255,255,255,0.2); color: white; }
.navbar--transparent:not(.scrolled) .navbar-toggler span { background: white; }

/* User dropdown toggle */
.nav-user-menu .nav-user-dropdown { transition: opacity 0.2s, transform 0.2s; transform-origin: top right; }
.nav-user-menu .nav-user-dropdown.open {
    display: block !important;
    animation: dropdownIn 0.18s ease;
}
@keyframes dropdownIn {
    from { opacity: 0; transform: scale(0.95) translateY(-6px); }
    to   { opacity: 1; transform: scale(1)    translateY(0); }
}
</style>

{{--  NAVBAR SCRIPT  --}}
<script>
(function () {
    'use strict';

    /*  Scroll effect  */
    var navbar = document.getElementById('navbar');
    function onScroll() {
        if (window.scrollY > 20) navbar.classList.add('scrolled');
        else navbar.classList.remove('scrolled');
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    /*  Mobile toggle  */
    var toggler = document.getElementById('navToggler');
    var menu    = document.getElementById('mobileMenu');
    if (toggler && menu) {
        toggler.addEventListener('click', function () {
            var open = menu.classList.toggle('open');
            toggler.setAttribute('aria-expanded', open);
            var spans = toggler.querySelectorAll('span');
            if (open) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity   = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
            } else {
                spans[0].style.transform = spans[1].style.opacity = spans[2].style.transform = '';
            }
        });
        document.addEventListener('click', function (e) {
            if (!toggler.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('open');
                toggler.setAttribute('aria-expanded', 'false');
                toggler.querySelectorAll('span').forEach(function (s) { s.style = ''; });
            }
        });
        window.addEventListener('resize', function () {
            if (window.innerWidth > 768) {
                menu.classList.remove('open');
                toggler.setAttribute('aria-expanded', 'false');
                toggler.querySelectorAll('span').forEach(function (s) { s.style = ''; });
            }
        });
    }

    /*  User dropdown  */
    var userBtn      = document.getElementById('userMenuBtn');
    var userDropdown = document.getElementById('userDropdown');
    if (userBtn && userDropdown) {
        userBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            var open = userDropdown.classList.toggle('open');
            userBtn.setAttribute('aria-expanded', open);
        });
        document.addEventListener('click', function () {
            userDropdown.classList.remove('open');
            if (userBtn) userBtn.setAttribute('aria-expanded', 'false');
        });
    }
}());
</script>
