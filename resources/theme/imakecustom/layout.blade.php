<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $pengaturan['nama_situs'] ?? 'iMakeCustom')</title>
    <meta name="description" content="@yield('description', $pengaturan['deskripsi_situs'] ?? 'Premium Bespoke Design & Manufacturing')">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('theme/imakecustom/css/style.css') }}">
    
    @yield('styles')
</head>
<body>
    <header id="header">
        <nav class="container">
            <div class="logo">
                <a href="/">
                    @php
                        $siteName = $pengaturan['nama_situs'] ?? 'iMake Custom';
                        if (str_contains($siteName, ' ')) {
                            $parts = explode(' ', $siteName);
                            $first = $parts[0];
                            $second = $parts[1] ?? '';
                        } elseif (str_contains($siteName, 'Custom') && $siteName !== 'Custom') {
                            $first = str_replace('Custom', '', $siteName);
                            $second = 'Custom';
                        } else {
                            $first = $siteName;
                            $second = '';
                        }
                    @endphp
                    {{ $first }}<span>{{ $second }}</span>
                </a>
            </div>
            <ul class="nav-links">
                @foreach($headerMenus as $m)
                    <li><a href="{{ $m->url }}">{{ $m->label }}</a></li>
                @endforeach
                <li><a href="/#contact" class="btn-primary">Get Started</a></li>
            </ul>
            <div class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <main>
        @yield('konten')
    </main>

    <footer>
        <div class="container footer-grid">
            <div class="footer-info">
                <div class="logo">
                    <a href="/">{{ $first }}<span>{{ $second }}</span></a>
                </div>
                <p>{{ $pengaturan['deskripsi_situs'] ?? 'Redefining custom manufacturing through innovation and precision.' }}</p>
            </div>
            <div class="footer-links">
                <h4>Footer Menu</h4>
                <ul>
                    @foreach($footerMenus as $fm)
                        <li><a href="{{ $fm->url }}">{{ $fm->label }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="footer-links">
                <h4>Support</h4>
                <ul>
                    @if(isset($supportMenus) && $supportMenus->isNotEmpty())
                        @foreach($supportMenus as $sm)
                            <li><a href="{{ $sm->url }}">{{ $sm->label }}</a></li>
                        @endforeach
                    @else
                        <li><a href="#">Documentation</a></li>
                        <li><a href="/privacy.html">Privacy Policy</a></li>
                    @endif
                </ul>
            </div>
            @if(!empty($pengaturan['sosmed_linkedin']) || !empty($pengaturan['sosmed_twitter']) || !empty($pengaturan['sosmed_facebook']) || !empty($pengaturan['sosmed_instagram']) || !empty($pengaturan['sosmed_youtube']))
            <div class="footer-social">
                <h4>Follow Us</h4>
                <div class="social-icons">
                    @if(!empty($pengaturan['sosmed_linkedin']) && $pengaturan['sosmed_linkedin'] !== '#')
                        <a href="{{ $pengaturan['sosmed_linkedin'] }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    @endif
                    @if(!empty($pengaturan['sosmed_twitter']) && $pengaturan['sosmed_twitter'] !== '#')
                        <a href="{{ $pengaturan['sosmed_twitter'] }}" target="_blank"><i class="fab fa-twitter"></i></a>
                    @endif
                    @if(!empty($pengaturan['sosmed_facebook']) && $pengaturan['sosmed_facebook'] !== '#')
                        <a href="{{ $pengaturan['sosmed_facebook'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if(!empty($pengaturan['sosmed_instagram']) && $pengaturan['sosmed_instagram'] !== '#')
                        <a href="{{ $pengaturan['sosmed_instagram'] }}" target="_blank"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if(!empty($pengaturan['sosmed_youtube']) && $pengaturan['sosmed_youtube'] !== '#')
                        <a href="{{ $pengaturan['sosmed_youtube'] }}" target="_blank"><i class="fab fa-youtube"></i></a>
                    @endif
                </div>
            </div>
            @endif
        </div>
        <div class="footer-bottom container">
            <p>&copy; {{ date('Y') }} {{ $pengaturan['nama_situs'] ?? 'iMakeCustom' }}. All rights reserved.</p>
        </div>
    </footer>

    <!-- Contact Modal -->
    <div id="contactModal" class="modal">
        <div class="modal-content reveal">
            <span class="close-modal">&times;</span>
            <div class="modal-header">
                <h2>Request a <span>Quote</span></h2>
                <p>Tell us about your project and we'll get back to you within 24 hours.</p>
                @if(session('berhasil'))
                    <div class="alert alert-success" style="margin-top: 1rem; padding: 1rem; background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; color: #10b981; border-radius: 10px;">
                        {{ session('berhasil') }}
                    </div>
                @endif
            </div>
            <form action="/kontak" method="POST" class="glass-form">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="nama" required placeholder="John Doe">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" required placeholder="john@example.com">
                    </div>
                </div>
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" name="perihal" required placeholder="Project Inquiry">
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea name="pesan" rows="4" required placeholder="Describe your custom part requirements..."></textarea>
                </div>
                <button type="submit" class="btn-primary" style="width: 100%;">Send Inquiry</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('theme/imakecustom/js/main.js') }}"></script>
    @yield('scripts')
    
    @if(session('berhasil'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('contactModal');
            if(modal) {
                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';
                modal.querySelector('.modal-content').classList.add('visible');
            }
        });
    </script>
    @endif
    
    <script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = '{{ $pengaturan['chat_widget_url'] ?? 'https://help.imakecustom.com/app-assets/chat_js' }}';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'best-support-system-chat'));
    </script>
</body>
</html>
