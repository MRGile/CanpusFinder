@extends('layouts.auth')

@section('title', 'Masuk - CampusFinder')

@section('content')
<div class="auth-wrapper">
    <!-- Visual Side -->
    <div class="auth-visual">
        <div class="auth-visual-content">
            <a href="/" class="navbar-brand" style="color:white;justify-content:center;margin-bottom:32px;display:inline-flex;gap:10px;">

                <span style="font-family:var(--font-main);font-weight:800;font-size:1.35rem;">Campus<span style="color:var(--accent);">Finder</span></span>
            </a>

            <h1 style="font-size:1.5rem; font-weight:700; color:white; ">Selamat Datang Kembali!</h1>
            <p>Masuk untuk mengakses favorit kampus, lacak pendaftaran, dan dapatkan rekomendasi personal.</p>

            <!-- Feature highlights -->
            <div style="margin-top:40px;display:flex;flex-direction:column;gap:16px;text-align:left;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:28px;height:28px;background:rgba(255,255,255,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">

                    </div>
                    <span style="font-size:0.88rem;opacity:0.9;">Akses katalog informasi kampus</span>
                </div>
                <div style="display:flex;align-items:center;gap:12px;"><div style="width:28px;height:28px;background:rgba(255,255,255,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:white;"></div><span style="font-size:0.88rem;opacity:0.9;">Simpan dan bandingkan kampus favorit</span></div>
                <div style="display:flex;align-items:center;gap:12px;"><div style="width:28px;height:28px;background:rgba(255,255,255,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:white;"></div><span style="font-size:0.88rem;opacity:0.9;">Pantau notifikasi kampus dan beasiswa</span></div>
                <div style="display:flex;align-items:center;gap:12px;"><div style="width:28px;height:28px;background:rgba(255,255,255,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:white;"></div><span style="font-size:0.88rem;opacity:0.9;">Temukan panduan beasiswa</span></div>
            </div>

            <!-- Testimonial mini -->
            <div style="margin-top:40px;background:rgba(255,255,255,0.1);border-radius:16px;padding:20px;border:1px solid rgba(255,255,255,0.15);">
                <p style="font-size:0.85rem;opacity:0.9;font-style:italic;margin-bottom:12px;">"CampusFinder membantu saya menemukan kampus dan beasiswa impian dalam waktu singkat!"</p>
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:36px;height:36px;background:var(--accent);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.85rem;">A</div>
                    <div>
                        <div style="font-size:0.82rem;font-weight:700;">Andi Prasetyo</div>
                        <div style="font-size:0.75rem;opacity:0.7;">Mahasiswa ITB, 2024</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Side -->
    <div class="auth-form-wrapper">
        <div class="auth-form-box">
            <div class="auth-header">
                <h2>Masuk ke Akun</h2>
                <p>Belum punya akun? <a href="/daftar" style="color:var(--primary);font-weight:600;">Daftar gratis sekarang</a></p>
            </div>

            <!-- Social Login -->

            <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:20px;">
                <button
                    style="display:flex;align-items:center;justify-content:center;gap:12px;padding:12px;border:1.5px solid var(--gray-300);border-radius:10px;background:white;font-size:0.88rem;font-weight:600;color:var(--dark);cursor:pointer;transition:var(--transition);"
                    onmouseover="this.style.borderColor='var(--primary)'"
                    onmouseout="this.style.borderColor='var(--gray-300)'"
                >
                    <i class="bi bi-google" style="font-size:18px;"></i>
                    Masuk dengan Google
                </button>
            </div>


            <div class="form-divider">atau masuk dengan email</div>

            <!-- Login Form -->
            <form action="/masuk" method="POST">
                @csrf
                @if ($errors->any())
                    <div role="alert" style="margin-bottom:16px;padding:12px 14px;background:#FEE2E2;color:#991B1B;border-radius:10px;font-size:0.82rem;">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrap">

                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="nama@email.com" required autocomplete="email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" style="display:flex;justify-content:space-between;align-items:center;">
                        Password
                        <a href="/lupa-password" style="font-size:0.78rem;color:var(--primary);font-weight:500;">Lupa password?</a>
                    </label>
                    <div class="input-wrap" style="position:relative;">

                        <input type="password" id="password" name="password" class="form-control password-input" placeholder="Masukkan password" required autocomplete="current-password">
                        <button type="button" class="password-toggle" data-target="password" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--gray-500);cursor:pointer;padding:0;">Tampilkan</button>
                    </div>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
                    <label class="form-check">
                        <input type="checkbox" name="remember"> Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    Masuk

                </button>
            </form>

            <p style="text-align:center;margin-top:24px;font-size:0.82rem;color:var(--gray-500);">
                Dengan masuk, kamu setuju dengan <a href="/syarat" style="color:var(--primary);">Syarat & Ketentuan</a> dan <a href="/privasi" style="color:var(--primary);">Kebijakan Privasi</a> kami.
            </p>
        </div>
    </div>
</div>
@endsection
