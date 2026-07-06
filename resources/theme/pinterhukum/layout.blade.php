<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pengaturan['nama_situs'] ?? 'Rumah Koalisi' }} - @yield('title', 'Beranda')</title>
    <meta name="description" content="{{ $pengaturan['deskripsi_situs'] ?? '' }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #014A7A;
            --secondary: #f8f8f8;
            --text-main: #333333;
            --text-muted: #718096;
            --accent: #f59e0b;
            --bg-body: #f8f8f8;
            --card-bg: #ffffff;
            --border: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Quicksand', sans-serif;
            font-weight: 700;
        }

        a { text-decoration: none; color: inherit; transition: 0.3s; }

        .container {
            width: 100%;
            max-width: 1320px;
            margin: 0 auto !important;
            padding: 0 30px;
            display: block;
            box-sizing: border-box;
            clear: both;
        }
        
        body {
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Header */
        header {
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .top-bar {
            background: #f1f5f9;
            padding: 8px 0;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .top-bar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .main-nav {
            padding: 15px 0;
        }

        .main-nav .container {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-links {
            display: flex;
            gap: 25px;
            list-style: none;
        }

        .nav-links li a {
            font-weight: 600;
            font-size: 0.95rem;
            color: #4a5568;
            text-transform: uppercase;
        }

        .nav-links li a:hover {
            color: var(--primary);
        }

        .nav-links li a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-links li a:hover::after {
            width: 100%;
        }

        /* Submenu / Dropdown */
        .nav-links li { position: relative; }
        .submenu {
            position: absolute;
            top: 100%;
            left: 0;
            background: #fff;
            min-width: 240px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border-radius: 12px;
            list-style: none;
            padding: 15px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(15px);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            z-index: 1000;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .nav-links li:hover .submenu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .submenu li {
            padding: 0 10px;
        }

        .submenu li a {
            padding: 10px 15px;
            display: block;
            text-transform: none !important;
            font-size: 0.95rem !important;
            font-weight: 500 !important;
            color: #4a5568 !important;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .submenu li a:hover {
            background: #f8fafc;
            color: var(--primary) !important;
            padding-left: 20px;
        }

        .submenu li a::after { display: none; }

        /* Search Overlay */
        .search-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.98);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s ease;
            backdrop-filter: blur(10px);
        }

        .search-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .search-container {
            width: 100%;
            max-width: 800px;
            padding: 20px;
            text-align: center;
            transform: translateY(30px);
            transition: all 0.5s ease;
        }

        .search-overlay.active .search-container {
            transform: translateY(0);
        }

        .search-input-group {
            position: relative;
            margin-bottom: 30px;
        }

        .search-input-group input {
            width: 100%;
            border: none;
            border-bottom: 3px solid #e2e8f0;
            padding: 20px 0;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            background: transparent;
            transition: all 0.3s;
            outline: none;
        }

        .search-input-group input:focus {
            border-color: var(--primary);
        }

        .search-close {
            position: absolute;
            top: 40px;
            right: 40px;
            font-size: 2rem;
            color: #64748b;
            cursor: pointer;
            transition: all 0.3s;
        }

        .search-close:hover {
            color: #ef4444;
            transform: rotate(90deg);
        }

        .search-btn-trigger {
            font-size: 1.2rem;
            color: var(--primary);
            cursor: pointer;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s;
            background: #f1f5f9;
        }

        .search-btn-trigger:hover {
            background: var(--primary);
            color: #fff;
            transform: scale(1.1);
        }

        .submenu li a:hover {
            background: #f8fafc;
            color: var(--primary) !important;
        }

        .has-submenu > a::after {
            content: '\f107';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            margin-left: 5px;
            font-size: 0.8rem;
        }

        /* Hero / Featured */
        .hero {
            margin-top: 30px;
            margin-bottom: 80px;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            height: 450px;
        }

        .hero-main {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            display: block;
            height: 100%;
            background: #e2e8f0;
        }

        .hero-side {
            display: grid;
            grid-template-rows: 1fr 1fr;
            gap: 20px;
        }

        .hero-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .hero-item:hover .hero-img {
            transform: scale(1.05);
        }

        .hero-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 30px;
            background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.4) 30%, rgba(0,0,0,0.9) 100%);
            color: #fff;
            z-index: 2;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            text-shadow: 0 1px 3px rgba(0,0,0,0.5);
        }

        .hero-item:hover .hero-overlay {
            padding-bottom: 40px;
            background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.2) 20%, rgba(0,0,0,1) 100%);
        }

        .hero-tag {
            background: var(--accent);
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-bottom: 10px;
            display: inline-block;
        }

        /* Content Sections */
        .main-content {
            padding: 0;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
        }

        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
            border-bottom: 2px solid var(--border);
            font-size: 1.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 80px;
            height: 2px;
            background: var(--primary);
        }

        .post-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            display: flex;
            gap: 20px;
        }

        .post-card img {
            width: 250px;
            height: 180px;
            object-fit: cover;
        }

        .post-info {
            padding: 20px;
            flex: 1;
        }

        .post-date {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .post-title {
            font-size: 1.25rem;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        /* Sidebar Widgets */
        .widget {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .widget-title {
            font-size: 1.1rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border);
        }

        /* Footer */
        footer {
            background: #fff;
            padding: 60px 0 30px;
            border-top: 1px solid var(--border);
            margin-top: 50px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-text {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-top: 15px;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid var(--border);
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icons a {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }

        .social-icons a:hover {
            background: var(--primary);
            color: #fff;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .hero { grid-template-columns: 1fr; height: auto; }
            .hero-side { grid-template-columns: 1fr 1fr; }
            .main-content { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        /* Mobile Nav */
        .mobile-nav-toggle {
            display: none;
            font-size: 1.5rem;
            color: var(--primary);
            cursor: pointer;
            padding: 10px;
        }

        @media (max-width: 992px) {
            .mobile-nav-toggle {
                display: block;
            }

            .nav-links {
                position: fixed;
                top: 0;
                right: -100%;
                width: 300px;
                height: 100vh;
                background: #fff;
                flex-direction: column;
                padding: 100px 30px;
                box-shadow: -10px 0 30px rgba(0,0,0,0.1);
                transition: right 0.3s ease;
                z-index: 1001;
                gap: 5px;
            }

            .nav-links.active {
                right: 0;
            }

            .nav-links li {
                width: 100%;
            }

            .nav-links li a {
                padding: 15px 0;
                border-bottom: 1px solid #f1f5f9;
                display: block;
                width: 100%;
            }

            .submenu {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                box-shadow: none;
                padding: 0 0 0 20px;
                display: none;
                margin-bottom: 15px;
            }

            .nav-links li.active .submenu {
                display: block;
            }

            .main-nav .container {
                justify-content: space-between;
                gap: 15px;
            }

            .nav-links li a::after {
                display: none;
            }
        }

        @media (max-width: 600px) {
            .hero-side { grid-template-columns: 1fr; }
            .post-card { flex-direction: column; }
            .post-card img { width: 100%; }
            .footer-grid { grid-template-columns: 1fr; gap: 30px; }
            .logo span { font-size: 1.2rem; }
        }
    </style>
    @yield('styles')
</head>
<body>



    <header>
        <div class="main-nav">
            <div class="container">
                <a href="/" class="logo">
                    @if(isset($pengaturan['logo']) && $pengaturan['logo'])
                        <img src="/storage/{{ $pengaturan['logo'] }}" alt="{{ $pengaturan['nama_situs'] ?? 'Logo' }}" style="max-height: 50px;">
                    @else
                        <i class="fas fa-balance-scale"></i>
                        <span>{{ strtoupper($pengaturan['nama_situs'] ?? 'Rumah Koalisi') }}</span>
                    @endif
                </a>
                <ul class="nav-links" style="margin-left: 10px;">
                    <li><a href="/">Beranda</a></li>
                    @foreach($menus as $m)
                        <li class="{{ $m->children->count() > 0 ? 'has-submenu' : '' }}">
                            <a href="{{ $m->url }}" target="{{ $m->target }}">{{ $m->label }}</a>
                            @if($m->children->count() > 0)
                                <ul class="submenu">
                                    @foreach($m->children as $child)
                                        <li><a href="{{ $child->url }}" target="{{ $child->target }}">{{ $child->label }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <div style="display: flex; align-items: center; gap: 5px; margin-left: auto;">
                    <div class="search-btn-trigger" id="toggle-search">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="mobile-nav-toggle" id="mobile-menu-toggle">
                        <i class="fas fa-bars"></i>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Search Overlay -->
    <div class="search-overlay" id="search-overlay">
        <div class="search-close" id="close-search">
            <i class="fas fa-times"></i>
        </div>
        <div class="search-container">
            <form action="/berita" method="GET">
                <div class="search-input-group">
                    <input type="text" name="cari" placeholder="Ketik kata kunci pencarian..." autocomplete="off" autofocus>
                </div>
                <p style="color: #64748b; font-size: 1.1rem;">Tekan <strong>ENTER</strong> untuk mulai mencari</p>
            </form>
        </div>
    </div>

    @yield('konten')

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a href="/" class="logo" style="font-size: 1.4rem;">
                        @if(isset($pengaturan['logo']) && $pengaturan['logo'])
                            <img src="/storage/{{ $pengaturan['logo'] }}" alt="{{ $pengaturan['nama_situs'] ?? 'Logo' }}" style="max-height: 50px;">
                        @else
                            <i class="fas fa-balance-scale"></i> {{ $pengaturan['nama_situs'] ?? 'Rumah Koalisi' }}
                        @endif
                    </a>
                    <p class="footer-text">
                        {{ $pengaturan['deskripsi_situs'] ?? 'Portal informasi hukum dan edukasi terpercaya untuk masyarakat Indonesia.' }}
                    </p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="widget-title">Link Cepat</h4>
                    <ul style="list-style: none; font-size: 0.9rem; line-height: 2;">
                        @foreach($footerMenus as $fm)
                            <li><a href="{{ $fm->url }}" target="{{ $fm->target }}">{{ $fm->label }}</a></li>
                        @endforeach
                        @if($footerMenus->count() == 0)
                            <li><a href="/tentang">Tentang Kami</a></li>
                            <li><a href="/redaksi">Redaksi</a></li>
                            <li><a href="/kebijakan">Kebijakan Privasi</a></li>
                            <li><a href="/syarat">Syarat & Ketentuan</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h4 class="widget-title">Kontak</h4>
                    <ul style="list-style: none; font-size: 0.9rem; line-height: 2; color: var(--text-muted);">
                        <li><i class="fas fa-envelope"></i> {{ $pengaturan['email_admin'] ?? 'kontak@pinterhukum.id' }}</li>
                        <li><i class="fas fa-phone"></i> {{ $pengaturan['no_hp'] ?? '+62 812 3456 789' }}</li>
                        <li><i class="fas fa-map-marker-alt"></i> {{ $pengaturan['alamat'] ?? 'Jakarta, Indonesia' }}</li>
                    </ul>
                </div>
                <div>
                    <h4 class="widget-title">Newsletter</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 15px;">Dapatkan pembaruan hukum langsung ke email Anda.</p>
                    <div style="display: flex;">
                        <input type="email" placeholder="Email Anda" style="padding: 10px; border: 1px solid var(--border); border-radius: 4px 0 0 4px; border-right: none; width: 100%;">
                        <button style="background: var(--primary); color: #fff; border: none; padding: 0 15px; border-radius: 0 4px 4px 0; cursor: pointer;">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} {{ $pengaturan['nama_situs']}}. All Rights Reserved. Powered by Rumah Koalisi.
            </div>
        </div>
    </footer>

    <div id="mobile-overlay" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000;"></div>

    @yield('scripts')
    <script>
        // Mobile Menu Logic
        const mobileToggle = document.getElementById('mobile-menu-toggle');
        const navLinks = document.querySelector('.nav-links');
        const mobileOverlay = document.getElementById('mobile-overlay');
        const hasSubmenu = document.querySelectorAll('.has-submenu > a');

        function toggleMobileMenu() {
            navLinks.classList.toggle('active');
            mobileOverlay.style.display = navLinks.classList.contains('active') ? 'block' : 'none';
            document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : 'auto';
        }

        if (mobileToggle) {
            mobileToggle.addEventListener('click', toggleMobileMenu);
            mobileOverlay.addEventListener('click', toggleMobileMenu);
        }

        hasSubmenu.forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 992) {
                    e.preventDefault();
                    this.parentElement.classList.toggle('active');
                }
            });
        });

        // Search Overlay Logic
        const searchTrigger = document.getElementById('toggle-search');
        const searchOverlay = document.getElementById('search-overlay');
        const searchClose = document.getElementById('close-search');
        const searchInput = searchOverlay.querySelector('input');

        if (searchTrigger) {
            searchTrigger.addEventListener('click', () => {
                searchOverlay.classList.add('active');
                setTimeout(() => searchInput.focus(), 100);
                document.body.style.overflow = 'hidden';
            });
        }

        if (searchClose) {
            searchClose.addEventListener('click', () => {
                searchOverlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            });
        }

        // Close on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && searchOverlay && searchOverlay.classList.contains('active')) {
                searchOverlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    </script>
</body>
</html>
