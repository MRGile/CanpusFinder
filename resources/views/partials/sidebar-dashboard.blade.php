{{--
    PARTIAL: Sidebar Dashboard (User)
    Usage: @include('partials.sidebar-dashboard')

    Props:
      $activeMenu (string) - key menu yang sedang aktif, e.g. 'favorit', 'profil', dsb.
--}}

@php
    $activeMenu = $activeMenu ?? '';
    $user = auth()->user();
@endphp

<aside class="dashboard-sidebar" id="dashboardSidebar" aria-label="Navigasi dashboard">

    {{--  User Profile Card  --}}
    <div style="padding:24px 20px;border-bottom:1px solid var(--gray-200);">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
            {{-- Avatar --}}
            <div style="width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));
                        display:flex;align-items:center;justify-content:center;
                        font-weight:800;font-size:1.1rem;color:white;flex-shrink:0;
                        box-shadow:0 4px 12px rgba(37,99,235,0.3);">
                @auth
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @else
                    ?
                @endauth
            </div>
            <div style="min-width:0;">
                <div style="font-size:0.9rem;font-weight:700;color:var(--dark);
                             white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    @auth {{ $user->name }} @else Tamu @endauth
                </div>
                <div style="font-size:0.72rem;color:var(--gray-500);
                             white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    @auth {{ $user->email }} @else - @endauth
                </div>
            </div>
        </div>

        {{-- Progress completion --}}
        <div style="background:var(--gray-100);border-radius:8px;padding:10px 12px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                <span style="font-size:0.72rem;font-weight:600;color:var(--gray-600);">Profil Lengkap</span>
                <span style="font-size:0.72rem;font-weight:700;color:var(--primary);">75%</span>
            </div>
            <div style="height:5px;background:var(--gray-200);border-radius:3px;overflow:hidden;">
                <div style="height:100%;width:75%;background:linear-gradient(to right,var(--primary),var(--secondary));
                             border-radius:3px;transition:width 0.6s ease;"></div>
            </div>
            <a href="/profil" style="display:block;font-size:0.72rem;color:var(--primary);
                                     font-weight:600;margin-top:6px;text-align:right;">
                Lengkapi
            </a>
        </div>
    </div>

    {{--  Navigation Menu  --}}
        <nav style="padding:8px 0;" aria-label="Menu dashboard">
        <div class="sidebar-nav-section">Utama</div>

        @if($user?->role === 'admin')
        <a href="/dashboard" class="sidebar-nav-item {{ $activeMenu === 'dashboard' ? 'active' : '' }}"><span style="flex:1;">Dashboard</span></a>
        <a href="{{ route('admin.universitas.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.universitas.*') ? 'active' : '' }}"><span style="flex:1;">Kelola Universitas</span></a>
        <a href="{{ route('admin.beasiswa.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.beasiswa.*') ? 'active' : '' }}"><span style="flex:1;">Kelola Beasiswa</span></a>
        <a href="{{ route('admin.blog.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}"><span style="flex:1;">Kelola Blog</span></a>
        @else
        <a href="/kampus" class="sidebar-nav-item"><span style="flex:1;">Cari Universitas</span></a>
        @endif

        <a href="/favorit" class="sidebar-nav-item {{ $activeMenu === 'favorit' ? 'active' : '' }}"><span style="flex:1;">Kampus Favorit</span></a>
        {{-- <a href="/bandingkan" class="sidebar-nav-item {{ $activeMenu === 'bandingkan' ? 'active' : '' }}"><span style="flex:1;">Perbandingan</span></a> --}}
        <div class="sidebar-nav-section">Informasi</div>
        <a href="/notifikasi" class="sidebar-nav-item {{ $activeMenu === 'notifikasi' ? 'active' : '' }}"><span style="flex:1;">Notifikasi</span></a>
        <div class="sidebar-nav-section">Akun</div>
        <a href="/profil" class="sidebar-nav-item {{ $activeMenu === 'profil' ? 'active' : '' }}"><span style="flex:1;">Profil Saya</span></a>
        {{-- <a href="/pengaturan" class="sidebar-nav-item {{ $activeMenu === 'pengaturan' ? 'active' : '' }}"><span style="flex:1;">Pengaturan</span></a> --}}
    </nav>

    <div style="margin:12px 16px;padding:16px;border:1px solid var(--gray-200);border-radius:10px;">
        <h4 style="font-size:0.85rem;font-weight:700;margin-bottom:5px;">Jelajahi katalog</h4>
        <p style="font-size:0.75rem;color:var(--gray-600);margin-bottom:10px;">Cari universitas dan fakultas yang sesuai.</p>
        <a href="/kampus" style="font-size:0.8rem;color:var(--primary);font-weight:600;">Buka katalog</a>
    </div>

    {{--  Logout  --}}
    <div style="padding:12px 16px;border-top:1px solid var(--gray-200);margin-top:4px;">
        @auth
        <form method="POST" action="/keluar">
            @csrf
            <button type="submit"
                    class="sidebar-nav-item"
                    style="width:100%;border:none;background:none;cursor:pointer;
                           color:var(--danger);text-align:left;"
                    onmouseover="this.style.background='#FEE2E2'"
                    onmouseout="this.style.background=''">

                <span>Keluar</span>
            </button>
        </form>
        @endauth
    </div>

</aside>

{{-- Mobile sidebar toggle (for responsive) --}}
<button id="dashSidebarToggle"
        style="display:none;position:fixed;bottom:20px;right:20px;
               width:52px;height:52px;border-radius:50%;
               background:var(--primary);color:white;border:none;
               box-shadow:var(--shadow-lg);cursor:pointer;z-index:500;
               align-items:center;justify-content:center;"
        aria-label="Buka menu"
        onclick="toggleDashSidebar()">Menu</button>

<style>
/* Mobile sidebar overlay */
@media (max-width: 992px) {
    #dashSidebarToggle { display: flex !important; }

    .dashboard-sidebar {
        position: fixed !important;
        left: 0; top: 0; bottom: 0;
        z-index: 400;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        box-shadow: var(--shadow-lg);
        height: 100vh !important;
    }
    .dashboard-sidebar.open {
        transform: translateX(0);
    }
    .dashboard-sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 399;
        backdrop-filter: blur(2px);
    }
    .dashboard-sidebar-overlay.show { display: block; }
}
</style>

<script>
(function () {
    /* Create overlay */
    var overlay = document.createElement('div');
    overlay.className = 'dashboard-sidebar-overlay';
    overlay.addEventListener('click', closeDashSidebar);
    document.body.appendChild(overlay);

    window.toggleDashSidebar = function () {
        var sidebar = document.getElementById('dashboardSidebar');
        var open    = sidebar.classList.toggle('open');
        overlay.classList.toggle('show', open);
    };
    window.closeDashSidebar = function () {
        document.getElementById('dashboardSidebar').classList.remove('open');
        overlay.classList.remove('show');
    };
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') window.closeDashSidebar();
    });
}());
</script>
