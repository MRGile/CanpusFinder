{{--
    PARTIAL: Footer
    Usage: @include('partials.footer')

    Props:
      $footerDark (bool)  - default true, footer background gelap
      $footerSimple (bool)- jika true, tampilkan versi ringkas (hanya bottom bar)
--}}



@if(isset($footerSimple) && $footerSimple)
{{--  SIMPLE FOOTER (Auth pages, dll)  --}}
<footer style="background:var(--dark);padding:20px 0;border-top:1px solid rgba(255,255,255,0.06);">
    <div class="container">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <p style="font-size:0.8rem;color:rgba(255,255,255,0.45);">
                &copy; {{ date('Y') }} CampusFinder. All rights reserved.
            </p>
            <div style="display:flex;gap:16px;">
                <a href="/privasi" style="font-size:0.78rem;color:rgba(255,255,255,0.4);transition:color 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">Privasi</a>
                <a href="/syarat"  style="font-size:0.78rem;color:rgba(255,255,255,0.4);transition:color 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">Syarat</a>
                <a href="/kontak"  style="font-size:0.78rem;color:rgba(255,255,255,0.4);transition:color 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">Kontak</a>
            </div>
        </div>
    </div>
</footer>

@else
{{--  FULL FOOTER  --}}
<footer class="footer" role="contentinfo">
    <div class="container">

        {{--  TOP SECTION  --}}
        <div class="footer-grid">

            {{-- Brand & About --}}
            <div class="footer-brand">
                <a href="/" class="navbar-brand" style="color:white;display:inline-flex;margin-bottom:16px;">
                    <img class="brand-logo" src="{{ asset('images/campusfinder-logo.png') }}" alt="" width="42" height="42">
                    Campus<span class="highlight">Finder</span>
                </a>

                <p>Platform terlengkap untuk menemukan kampus impianmu di Indonesia. Kami membantu calon mahasiswa membuat keputusan akademik yang tepat.</p>

                {{-- Social Icons --}}
                                

                {{-- App badges --}}
                <div style="display:flex;gap:10px;margin-top:20px;flex-wrap:wrap;">
                    <a href="#" style="display:flex;align-items:center;gap:8px;background:rgba(255,255,255,0.06);
                                       border:1px solid rgba(255,255,255,0.12);border-radius:10px;
                                       padding:8px 14px;transition:background 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                       onmouseout="this.style.background='rgba(255,255,255,0.06)'">
                        
                        <div>
                            <div style="font-size:0.6rem;color:rgba(255,255,255,0.6);line-height:1;">Download on the</div>
                            <div style="font-size:0.8rem;font-weight:700;color:white;line-height:1.3;">App Store</div>
                        </div>
                    </a>
                    <a href="#" style="display:flex;align-items:center;gap:8px;background:rgba(255,255,255,0.06);
                                       border:1px solid rgba(255,255,255,0.12);border-radius:10px;
                                       padding:8px 14px;transition:background 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                       onmouseout="this.style.background='rgba(255,255,255,0.06)'">
                        
                        <div>
                            <div style="font-size:0.6rem;color:rgba(255,255,255,0.6);line-height:1;">Get it on</div>
                            <div style="font-size:0.8rem;font-weight:700;color:white;line-height:1.3;">Google Play</div>
                        </div>
                    </a>
                </div>
            </div>

                        <div class="footer-col">
                <h4>Platform</h4>
                <nav class="footer-links" aria-label="Platform">
                    <a href="/kampus">Cari Kampus</a>
                    <a href="/program-studi">Program Studi</a>
                    <a href="/bandingkan">Bandingkan Kampus</a>
                    <a href="/beasiswa">Info Beasiswa</a>
                </nav>
            </div>
            <div class="footer-col">
                <h4>Informasi</h4>
                <nav class="footer-links" aria-label="Informasi">
                    <a href="/blog">Blog &amp; Artikel</a>
                    <a href="/tips">Tips Masuk Kampus</a>
                    <a href="/snbt">Info SNBT</a>
                    <a href="/faq">FAQ</a>
                </nav>
            </div>
            <div class="footer-col">
                <h4>Perusahaan</h4>
                <nav class="footer-links" aria-label="Perusahaan">
                    <a href="/tentang">Tentang Kami</a>
                    <a href="/karir">Karir</a>
                    <a href="/partnership">Partnership</a>
                    <a href="/kontak">Hubungi Kami</a>
                </nav>
            </div>

        </div>{{-- /.footer-grid --}}

        {{--  NEWSLETTER  --}}
        <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);
                    border-radius:16px;padding:28px 32px;margin-bottom:40px;
                    display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap;">
            <div>
                <h4 style="font-size:1rem;font-weight:700;color:white;margin-bottom:4px;">
                     Dapatkan Info Terbaru
                </h4>
                <p style="font-size:0.83rem;color:rgba(255,255,255,0.55);">
                    Notifikasi jadwal pendaftaran, beasiswa baru, dan tips masuk kampus.
                </p>
            </div>
            <form style="display:flex;gap:10px;flex-wrap:wrap;" onsubmit="handleNewsletter(event)">
                <input type="email" placeholder="Masukkan email kamu..."
                       required
                       style="padding:10px 16px;border-radius:10px;border:1px solid rgba(255,255,255,0.15);
                              background:rgba(255,255,255,0.07);color:white;font-size:0.875rem;
                              outline:none;min-width:240px;font-family:var(--font-body);"
                       onfocus="this.style.borderColor='var(--primary)'"
                       onblur="this.style.borderColor='rgba(255,255,255,0.15)'"
                       placeholder="Masukkan email kamu...">
                <button type="submit"
                        style="padding:10px 24px;background:var(--primary);color:white;border:none;
                               border-radius:10px;font-size:0.875rem;font-weight:600;cursor:pointer;
                               transition:var(--transition);white-space:nowrap;"
                        onmouseover="this.style.background='var(--primary-dark)'"
                        onmouseout="this.style.background='var(--primary)'">
                    Berlangganan
                </button>
            </form>
        </div>

        {{--  BOTTOM BAR  --}}
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} CampusFinder. All rights reserved. Made with ️ in Indonesia.</p>
            <div class="footer-bottom-links">
                <a href="/privasi">Kebijakan Privasi</a>
                <a href="/syarat">Syarat & Ketentuan</a>
                <a href="/cookie">Cookie Policy</a>
            </div>
        </div>

    </div>{{-- /.container --}}
</footer>

<script>
function handleNewsletter(e) {
    e.preventDefault();
    var input = e.target.querySelector('input[type="email"]');
    var btn   = e.target.querySelector('button[type="submit"]');
    btn.textContent = ' Terdaftar!';
    btn.style.background = 'var(--success)';
    input.value = '';
    setTimeout(function () {
        btn.textContent = 'Berlangganan';
        btn.style.background = '';
    }, 3000);
}
</script>

@endif{{-- /footer type --}}
