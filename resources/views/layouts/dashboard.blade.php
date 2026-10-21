<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') – CampusFinder</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/campusfinder.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    @stack('styles')
</head>
<body class="admin-layout" style="background:#f5f7fb;">

    {{--  TOPBAR  --}}
    <header class="admin-header" style="position:fixed;top:0;left:0;right:0;height:64px;background:white;
                   border-bottom:1px solid var(--gray-200);z-index:500;display:flex;
                   align-items:center;justify-content:space-between;padding:0 24px;
                   box-shadow:var(--shadow-sm);">

        {{-- Brand --}}
        <a href="/" class="navbar-brand d-flex align-items-center gap-2 text-decoration-none">
            <span class="d-inline-flex align-items-center justify-content-center rounded-3 text-white fw-bold" style="width:36px;height:36px;background:#2563eb;">CF</span>
            <span class="fw-bold text-primary-emphasis">CampusFinder</span>
        </a>

        {{-- Search --}}
        <form action="/kampus" method="GET" style="flex:1;max-width:400px;margin:0 32px;position:relative;display:none;"
             class="dash-search-wrap" id="dashSearch">
            <input type="search" name="q" placeholder="Cari universitas..." aria-label="Cari universitas"
                   style="width:100%;padding:9px 16px;border:1.5px solid var(--gray-200);
                          border-radius:10px;font-size:0.875rem;outline:none;background:var(--gray-100);">
        </form>

        {{-- Right: Notif + User --}}
        <div style="display:flex;align-items:center;gap:12px;">

            {{-- Search toggle (mobile) --}}
            <button class="btn btn-outline-secondary btn-sm" style="width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;
                           background:white;display:flex;align-items:center;justify-content:center;
                           cursor:pointer;" aria-label="Cari"
                    onclick="var el=document.getElementById('dashSearch');el.style.display=el.style.display?'':'block'"><i class="bi bi-search"></i></button>

            {{-- Notifications --}}
            <a href="/notifikasi" class="btn btn-outline-secondary btn-sm"
               style="width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;
                      background:white;display:flex;align-items:center;justify-content:center;
                      position:relative;" aria-label="Notifikasi"><i class="bi bi-bell"></i></a>

            {{-- User Avatar --}}
            @auth
            <div style="display:flex;align-items:center;gap:8px;padding:5px 12px;
                        border:1px solid var(--gray-200);border-radius:10px;background:white;">
                    <div style="width:30px;height:30px;border-radius:50%;background:#2563eb;
                            color:white;display:flex;align-items:center;justify-content:center;
                            font-weight:700;font-size:0.82rem;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span style="font-size:0.83rem;font-weight:600;color:var(--dark);">
                    {{ Str::limit(auth()->user()->name, 10) }}
                </span>
            </div>
            @endauth

        </div>
    </header>

    {{--  BODY  --}}
    <div class="admin-wrapper" style="min-height:100vh;padding-top:64px;">

        {{--  SIDEBAR PARTIAL  --}}
        @include('partials.sidebar-dashboard')

        {{--  MAIN CONTENT  --}}
        <main role="main" class="admin-main" style="overflow:hidden;">
            <div class="container-fluid" style="padding:32px;max-width:1400px;">
                @yield('content')
            </div>
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/main.js"></script>
    @stack('scripts')

    <style>
    .admin-header { z-index: 1050 !important; }
    .dashboard-sidebar { position: fixed; top: 64px; left: 0; bottom: 0; width: 260px; overflow-y: auto; background: #fff; border-right: 1px solid #e5e7eb; z-index: 1035; }
    .admin-main { margin-left: 260px; min-height: calc(100vh - 64px); }
    .admin-main .card { border-radius: .75rem; }
    .admin-main .card-header { border-radius: .75rem .75rem 0 0; }
    .admin-main .form-label { font-size: .875rem; font-weight: 600; color: #334155; }
    .admin-main .form-control, .admin-main .form-select { min-height: 44px; border-color: #dbe2ea; border-radius: .5rem; }
    .admin-main textarea.form-control { min-height: auto; }
    @media (max-width: 992px) {
        .dashboard-sidebar { transform: translateX(-100%); transition: transform .25s ease; }
        .dashboard-sidebar.open { transform: translateX(0); }
        .admin-main { margin-left: 0; }
        .admin-main .container-fluid { padding: 24px 16px !important; }
    }
    </style>
</body>
</html>
