<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pengaturan['nama_situs'] ?? 'Readora' }} - @yield('title', 'Home')</title>
    <meta name="description" content="{{ $pengaturan['deskripsi_situs'] ?? '' }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-grad: linear-gradient(45deg, #f77062, #fe5196);
            --primary: #f77062;
            --purple: #311567;
            --purple-light: #5e33d1;
            --purple-dark: #1e0b3d;
            --body-text: #212529;
            --text-muted: #6c757d;
            --bg-light: #f8f9fa;
            --white: #ffffff;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.12);
            --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--body-text);
            background-color: var(--white);
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
            color: var(--purple);
            font-weight: 800;
        }

        a { text-decoration: none; color: inherit; transition: var(--transition); }
        ul { list-style: none; }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-padding { padding: 100px 0; }

        /* Buttons */
        .btn-cmn {
            display: inline-block;
            padding: 14px 34px;
            border-radius: 50px;
            background: var(--primary-grad);
            color: var(--white);
            font-weight: 700;
            font-size: 16px;
            border: none;
            cursor: pointer;
            text-align: center;
            box-shadow: 0 6px 20px rgba(247, 112, 98, 0.3);
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .btn-cmn::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(45deg, #fe5196, #f77062);
            z-index: -1;
            opacity: 0;
            transition: var(--transition);
        }

        .btn-cmn:hover::before { opacity: 1; }
        .btn-cmn:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(247, 112, 98, 0.4); color: #fff; }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
            box-shadow: none;
        }
        .btn-outline:hover { background: var(--primary); color: var(--white); }

        /* Header / Navbar */
        header {
            position: fixed;
            top: 0; width: 100%;
            padding: 20px 0;
            z-index: 1000;
            transition: var(--transition);
        }

        header.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            padding: 15px 0;
            box-shadow: 0 5px 25px rgba(0,0,0,0.05);
        }

        header.scrolled .logo,
        header.scrolled .nav-link {
            color: var(--purple);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 28px;
            font-weight: 900;
            color: var(--white);
            letter-spacing: -1px;
        }

        .logo span { color: var(--primary); }

        .nav-menu { display: flex; align-items: center; gap: 35px; }

        .nav-link {
            font-weight: 600;
            font-size: 16px;
            color: var(--white);
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px; left: 0; width: 0; height: 2px;
            background: var(--primary-grad);
            transition: var(--transition);
        }

        .nav-link:hover::after { width: 100%; }
        .nav-link:hover { color: var(--primary); }

        /* Footer */
        footer {
            background: var(--purple-dark);
            color: rgba(255,255,255,0.8);
            padding: 80px 0 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 50px;
            margin-bottom: 50px;
        }

        .footer-widget h4 { color: var(--white); margin-bottom: 25px; font-size: 20px; }
        .footer-links li { margin-bottom: 15px; }
        .footer-links a:hover { color: var(--primary); padding-left: 5px; }

        .social-icons { display: flex; gap: 15px; margin-top: 25px; }
        .social-icons a {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: var(--white);
            transition: var(--transition);
        }
        .social-icons a:hover { background: var(--primary-grad); transform: translateY(-5px); }

        .footer-bottom {
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .nav-menu { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 575px) {
            .footer-grid { grid-template-columns: 1fr; }
        }

        /* Animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .animate-float { animation: float 4s ease-in-out infinite; }
    </style>
    @yield('styles')
</head>
<body>

    <header id="main-header">
        <div class="container">
            <div class="navbar">
                <a href="/" class="logo">
                     @if(isset($pengaturan['logo']) && $pengaturan['logo'])
                        <img src="/storage/{{ $pengaturan['logo'] }}" alt="Logo" style="max-height: 45px;">
                    @else
                        Rea<span>dora.</span>
                    @endif
                </a>

                <ul class="nav-menu">
                    <li><a href="/#home" class="nav-link">Home</a></li>
                    <li><a href="/#services" class="nav-link">Services</a></li>
                    <li><a href="/#portfolio" class="nav-link">Portfolio</a></li>
                    <li><a href="/#faq" class="nav-link">FAQ</a></li>
                    <li><a href="/kontak" class="btn-cmn">Contact Me</a></li>
                </ul>

                <div class="mobile-toggle" style="display: none;">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>
    </header>

    @yield('konten')

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-widget">
                    <a href="/" class="logo" style="color: #fff; margin-bottom: 25px; display: block;">
                         @if(isset($pengaturan['logo']) && $pengaturan['logo'])
                            <img src="/storage/{{ $pengaturan['logo'] }}" alt="Logo" style="max-height: 40px;">
                        @else
                            Rea<span>dora.</span>
                        @endif
                    </a>
                    <p>{{ $pengaturan['deskripsi_situs'] ?? 'Creating digital experiences that inspire and connect.' }}</p>
                    <div class="social-icons">
                        @if(isset($pengaturan['sosmed_facebook']) && $pengaturan['sosmed_facebook'])
                            <a href="{{ $pengaturan['sosmed_facebook'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if(isset($pengaturan['sosmed_twitter']) && $pengaturan['sosmed_twitter'])
                            <a href="{{ $pengaturan['sosmed_twitter'] }}" target="_blank"><i class="fab fa-twitter"></i></a>
                        @endif
                        @if(isset($pengaturan['sosmed_instagram']) && $pengaturan['sosmed_instagram'])
                            <a href="{{ $pengaturan['sosmed_instagram'] }}" target="_blank"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if(isset($pengaturan['sosmed_linkedin']) && $pengaturan['sosmed_linkedin'])
                            <a href="{{ $pengaturan['sosmed_linkedin'] }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        @endif
                        @if(isset($pengaturan['sosmed_youtube']) && $pengaturan['sosmed_youtube'])
                            <a href="{{ $pengaturan['sosmed_youtube'] }}" target="_blank"><i class="fab fa-youtube"></i></a>
                        @endif
                    </div>
                </div>
                <div class="footer-widget">
                    <h4>Explore</h4>
                    <ul class="footer-links">
                        <li><a href="/">Home</a></li>
                        <li><a href="/berita">Portfolio</a></li>
                        <li><a href="/artikel">Blog</a></li>
                        <li><a href="/tentang">About Me</a></li>
                    </ul>
                </div>
                <div class="footer-widget">
                    <h4>Utility</h4>
                    <ul class="footer-links">
                        <li><a href="/syarat">Terms & Conditions</a></li>
                        <li><a href="/kebijakan">Privacy Policy</a></li>
                        <li><a href="/kontak">Support</a></li>
                        <li><a href="/redaksi">Team</a></li>
                    </ul>
                </div>
                <div class="footer-widget">
                    <h4>Contact Info</h4>
                    <p style="margin-bottom: 15px;"><i class="fas fa-envelope" style="color: var(--primary); margin-right: 10px;"></i> {{ $pengaturan['email_admin'] ?? 'hello@readora.com' }}</p>
                    <p><i class="fas fa-map-marker-alt" style="color: var(--primary); margin-right: 10px;"></i> {{ $pengaturan['alamat'] ?? 'Jakarta, Indonesia' }}</p>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} {{ $pengaturan['nama_situs'] ?? 'Readora' }}. All rights reserved. Designed by Rumah Cyber.
            </div>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', function() {
            const header = document.getElementById('main-header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>
    @yield('scripts')

</body>
</html>
