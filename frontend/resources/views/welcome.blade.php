{{--
    ============================================================
    HALAMAN UTAMA - Perumda Air Minum Tirta Perwira Purbalingga
    ============================================================
    File ini adalah layout utama yang merakit semua partial.
    Setiap section berada di folder: resources/views/partials/

    STRUKTUR:
    partials/
    ├── head.blade.php              → <head>, meta, CSS, JSON-LD
    ├── navbar.blade.php            → Header + navigasi desktop & mobile
    ├── navbar-script.blade.php     → JavaScript navbar & smooth scroll
    ├── hero.blade.php              → Section hero carousel
    ├── quick-actions.blade.php     → Section akses cepat (tagihan, pengaduan)
    ├── about.blade.php             → Section tentang kami + fitur utama
    ├── services.blade.php          → Section layanan utama (cards)
    ├── partnerships.blade.php      → Section mitra pembayaran (slider)
    ├── news.blade.php              → Section berita & pengumuman (tabs)
    ├── faq.blade.php               → Section FAQ accordion
    ├── footer.blade.php            → Footer + copyright + sosial media
    ├── cookie-consent.blade.php    → Banner persetujuan cookie
    └── scripts/
        ├── hero-carousel.blade.php → JS: class HeroCarousel
        ├── news-tabs.blade.php     → JS: tab switcher berita
        ├── faq.blade.php           → JS: accordion FAQ
        └── general.blade.php       → JS: scroll progress, animasi, FontAwesome loader
    ============================================================
--}}

@include('partials.head')

<body class="bg-gray-50 dark:bg-gray-900 dark:text-gray-100 font-sans antialiased">

    {{-- ── NAVIGASI ──────────────────────────────────────────────── --}}
    @include('partials.navbar')
    @include('partials.navbar-script')

    {{-- ── KONTEN UTAMA ───────────────────────────────────────────── --}}
    <main>
        @include('partials.hero')
        @include('partials.quick-actions')
        @include('partials.about')
        @include('partials.services')
        @include('partials.partnerships')
        @include('partials.news')
        @include('partials.faq')

        {{-- Progress bar scroll --}}
        <div id="scroll-progress" class="fixed top-0 left-0 w-full h-1 bg-gray-200 z-50">
            <div id="progress-bar" class="h-full bg-gradient-to-r from-blue-500 to-cyan-500 transition-all duration-150 ease-out" style="width: 0%"></div>
        </div>
    </main>

    {{-- ── FOOTER ─────────────────────────────────────────────────── --}}
    @include('partials.footer')

    {{-- ── JAVASCRIPT ─────────────────────────────────────────────── --}}
    @include('partials.scripts.hero-carousel')
    @include('partials.scripts.news-tabs')
    @include('partials.scripts.faq')
    @include('partials.scripts.general')

    {{-- ── CHATBOT WIDGET ──────────────────────────────────────────── --}}
    @include('components.chatbot')

    {{-- ── COOKIE CONSENT ─────────────────────────────────────────── --}}
    @include('partials.cookie-consent')

</body>
</html>