@extends('layouts.auth')

@section('title', 'Daftar Gratis - CampusFinder')

@section('content')
<div class="auth-wrapper">
    <!-- Visual Side -->
    <div class="auth-visual">
        <div class="auth-visual-content">
            <a href="/" class="navbar-brand" style="color:white;justify-content:center;margin-bottom:32px;display:inline-flex;gap:10px;">
                
                <span style="font-family:var(--font-main);font-weight:800;font-size:1.35rem;">Campus<span style="color:var(--accent);">Finder</span></span>
            </a>

            <div style="color: white">
                <h2>Mulai Perjalananmu Bersama CampusFinder</h2>
                <p>Bergabung dengan 2 juta+ pelajar yang telah menemukan kampus impian mereka.</p>
            </div>

            <div style="margin-top:40px;display:grid;grid-template-columns:1fr 1fr;gap:16px;text-align:left;">
                <div style="background:rgba(255,255,255,0.1);border-radius:12px;padding:16px;border:1px solid rgba(255,255,255,0.15);">
                    
                    <div style="font-size:0.88rem;font-weight:700;margin-bottom:2px;">Katalog Kampus</div>
                    <div style="font-size:0.75rem;opacity:0.75;">Cari kampus sesuai pilihanmu</div>
                </div>
                <div style="background:rgba(255,255,255,0.1);border-radius:12px;padding:16px;border:1px solid rgba(255,255,255,0.15);"><div style="font-size:0.88rem;font-weight:700;margin-bottom:2px;">Informasi Beasiswa</div><div style="font-size:0.75rem;opacity:0.75;">Temukan program yang sesuai</div></div>
                <div style="background:rgba(255,255,255,0.1);border-radius:12px;padding:16px;border:1px solid rgba(255,255,255,0.15);"><div style="font-size:0.88rem;font-weight:700;margin-bottom:2px;">Bandingkan</div><div style="font-size:0.75rem;opacity:0.75;">Lihat pilihan kampus</div></div>
                <div style="background:rgba(255,255,255,0.1);border-radius:12px;padding:16px;border:1px solid rgba(255,255,255,0.15);"><div style="font-size:0.88rem;font-weight:700;margin-bottom:2px;">Notifikasi</div><div style="font-size:0.75rem;opacity:0.75;">Pantau info terbaru</div></div>
            </div>

            <div style="margin-top:32px;padding:16px;background:rgba(255,255,255,0.08);border-radius:12px;display:flex;align-items:center;gap:12px;">
                
                <div>
                    <div style="font-size:0.78rem;font-weight:700;">100% Gratis!</div>
                    <div style="font-size:0.78rem;opacity:0.8;">Tanpa biaya pendaftaran. Akses penuh selamanya.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Side -->
    <div class="auth-form-wrapper">
        <div class="auth-form-box">
            <div class="auth-header">
                <h2>Buat Akun Baru</h2>
                <p>Sudah punya akun? <a href="/masuk" style="color:var(--primary);font-weight:600;">Masuk di sini</a></p>
            </div>

            <!-- Social Register -->
            <button style="display:flex;align-items:center;justify-content:center;gap:12px;padding:12px;border:1.5px solid var(--gray-300);border-radius:10px;background:white;font-size:0.88rem;font-weight:600;color:var(--dark);cursor:pointer;transition:var(--transition);width:100%;margin-bottom:20px;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--gray-300)'">
                
                Daftar dengan Google
            </button>

            <div class="form-divider">atau daftar dengan email</div>

            <!-- Register Form -->
            <form action="/daftar" method="POST">
                @csrf
                @if ($errors->any())
                    <div role="alert" style="margin-bottom:16px;padding:12px 14px;background:#FEE2E2;color:#991B1B;border-radius:10px;font-size:0.82rem;">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div class="form-group">
                        <label for="first_name">Nama Depan</label>
                        <div class="input-wrap">
                            
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="form-control" placeholder="Nama depan" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Nama Belakang</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="form-control" placeholder="Nama belakang">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrap">
                        
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="nama@email.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Nomor HP</label>
                    <div class="input-wrap">
                        
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="08xx-xxxx-xxxx">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap" style="position:relative;">
                        
                        <input type="password" id="password" name="password" class="form-control" placeholder="Min. 8 karakter" required minlength="8">
                        <button type="button" class="password-toggle" data-target="password" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--gray-500);cursor:pointer;padding:0;">Tampilkan</button>
                    </div>
                    <div id="passwordStrength" style="margin-top:6px;height:4px;border-radius:2px;background:var(--gray-200);overflow:hidden;">
                        <div id="strengthBar" style="height:100%;width:0;border-radius:2px;transition:all 0.3s;"></div>
                    </div>
                    <span id="strengthText" class="form-hint"></span>
                </div>

                <div class="form-group">
                    <label class="form-check" style="align-items:flex-start;gap:10px;">
                        <input type="checkbox" name="agree" value="1" @checked(old('agree')) required style="margin-top:2px;accent-color:var(--primary);width:16px;height:16px;">
                        <span style="font-size:0.82rem;color:var(--gray-700);">Saya setuju dengan <a href="/syarat" style="color:var(--primary);">Syarat & Ketentuan</a> dan <a href="/privasi" style="color:var(--primary);">Kebijakan Privasi</a> CampusFinder</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    Buat Akun Gratis
                    
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('password')?.addEventListener('input', function() {
    const val = this.value;
    const bar = document.getElementById('strengthBar');
    const text = document.getElementById('strengthText');
    let strength = 0;
    if (val.length >= 8) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/[0-9]/.test(val)) strength++;
    if (/[A-Za-z0-9]/.test(val)) strength++;
    if (strength > 0) {
        let color = '#EF4444';
        let label = 'Lemah';
        if (strength === 2) { color = '#F59E0B'; label = 'Sedang'; }
        if (strength === 3) { color = '#10B981'; label = 'Kuat'; }
        if (strength >= 4) { color = '#1D4ED8'; label = 'Sangat Kuat'; }
        bar.style.width = (strength * 25) + '%';
        bar.style.background = color;
        text.textContent = label;
        text.style.color = color;
    } else {
        bar.style.width = '0';
        text.textContent = '';
    }
});
</script>
@endpush
