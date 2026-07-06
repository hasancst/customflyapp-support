<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pengaturan['nama_situs'] ?? 'CMS' }} - @yield('judul')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.6.6/css/flag-icons.min.css" rel="stylesheet">
    
    <!-- jQuery and Summernote -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

    <style>
        :root {
            --primary: #4e73df;
            --primary-light: #f8faff;
            --bg-body: #f4f7fe;
            --sidebar-bg: #ffffff;
            --card-bg: #ffffff;
            --text-main: #2d3748;
            --text-muted: #718096;
            --accent: #ebf1ff;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.04), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
            --border: #edf2f7;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            min-width: 260px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: sticky;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 10;
        }

        .sidebar-logo {
            padding: 30px 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .sidebar-nav {
            flex: 1;
            padding: 0 15px;
            overflow-y: auto;
        }
        
        .sidebar-nav::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 20px;
        }
        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 5px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .nav-item i {
            width: 20px;
            font-size: 1.1rem;
        }

        .nav-item:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .nav-item.active {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(78, 115, 223, 0.2);
        }

        .nav-header {
            padding: 25px 15px 10px 15px;
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            opacity: 0.7;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid var(--border);
        }

        /* Main Content */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .header {
            height: 80px;
            background: #ffffff;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            position: sticky;
            top: 0;
            z-index: 5;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-brand .dot {
            width: 8px;
            height: 8px;
            background: #22c55e;
            border-radius: 50%;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 15px;
            text-align: right;
        }

        .header-user .info h4 {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .header-user .info span {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .content {
            padding: 40px;
        }

        /* Responsive Admin */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary);
            cursor: pointer;
        }

        @media (max-width: 1024px) {
            .sidebar {
                position: fixed;
                left: -260px;
                transition: left 0.3s ease;
                box-shadow: 10px 0 30px rgba(0,0,0,0.1);
            }

            .sidebar.show {
                left: 0;
            }

            .header {
                padding: 0 20px;
            }

            .mobile-toggle {
                display: block;
            }

            .content {
                padding: 20px;
            }

            .header-user .info {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .grid-dashboard {
                grid-template-columns: 1fr !important;
            }
            
            .header-brand nav {
                display: none !important;
            }
        }

        /* UI Elements */
        .card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 25px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            margin-bottom: 30px;
        }

        .card h3 {
            font-size: 1.1rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: var(--primary);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .btn:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="url"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 12px 15px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background-color: #ffffff !important;
            color: var(--text-main);
            font-family: inherit;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
        }

        .badge {
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            background: var(--accent);
            color: var(--primary);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 15px;
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 15px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        /* Responsive Table */
        .table-container {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 20px;
        }

        table {
            min-width: 800px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            background: #dcfce7;
            color: #166534;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Layout Grid */
        .grid-dashboard {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 25px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: var(--shadow);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-info .label {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .stat-info .value {
            font-size: 1.5rem;
            font-weight: 700;
        }
    </style>
    @yield('styles')
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-rocket"></i> {{ $pengaturan['nama_situs'] ?? 'CMS' }}
        </div>
        
        <nav class="sidebar-nav">
            <a href="/admin" class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>

            {{-- Content Header --}}
            <div class="nav-header"><i class="fas fa-layer-group"></i> Content CMS</div>

            @if(in_array('statistik', array_map('strtolower', $modulAktif)))
            <a href="/admin/statistik" class="nav-item {{ request()->is('admin/statistik*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Statistik
            </a>
            @endif
            @if(in_array('artikel', array_map('strtolower', $modulAktif)))
            <a href="/admin/artikel" class="nav-item {{ request()->is('admin/artikel*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Artikel
            </a>
            @endif
            @if(in_array('berita', array_map('strtolower', $modulAktif)))
            <div class="nav-item-group">
                <a href="#" class="nav-item {{ request()->is('admin/berita*') ? 'active' : '' }}" onclick="event.preventDefault(); var sub = document.getElementById('berita-submenu'); var icon = this.querySelector('.arrow-icon'); if(sub.style.display === 'none'){ sub.style.display = 'block'; icon.style.transform = 'rotate(180deg)'; } else { sub.style.display = 'none'; icon.style.transform = 'rotate(0deg)'; }">
                    <i class="fas fa-newspaper"></i>
                    <span style="flex: 1;">Berita</span>
                    <i class="fas fa-chevron-down arrow-icon" style="font-size: 0.8rem; transition: transform 0.3s; transform: {{ request()->is('admin/berita*') ? 'rotate(180deg)' : 'rotate(0deg)' }}"></i>
                </a>
                <div id="berita-submenu" style="display: {{ request()->is('admin/berita*') ? 'block' : 'none' }}; padding-left: 15px; overflow: hidden; transition: all 0.3s;">
                    <a href="/admin/berita" class="nav-item {{ request()->is('admin/berita') || request()->is('admin/berita/tambah') || request()->is('admin/berita/ubah*') ? 'active' : '' }}" style="font-size: 0.9rem;">
                        <i class="fas fa-list" style="width: 18px;"></i> Semua Berita
                    </a>
                    <a href="/admin/berita/kategori" class="nav-item {{ request()->is('admin/berita/kategori*') ? 'active' : '' }}" style="font-size: 0.9rem;">
                        <i class="fas fa-folder-open" style="width: 18px;"></i> Kategori
                    </a>
                </div>
            </div>
            @endif
            @if(in_array('iklan', array_map('strtolower', $modulAktif)))
            <a href="/admin/iklan" class="nav-item {{ request()->is('admin/iklan*') ? 'active' : '' }}">
                <i class="fas fa-ad"></i> Iklan
            </a>
            @endif
            @if(in_array('video', array_map('strtolower', $modulAktif)))
            <a href="/admin/video" class="nav-item {{ request()->is('admin/video*') ? 'active' : '' }}">
                <i class="fas fa-video"></i> Video
            </a>
            @endif
            @if(in_array('slideshow', array_map('strtolower', $modulAktif)))
            <a href="/admin/slideshow" class="nav-item {{ request()->is('admin/slideshow*') ? 'active' : '' }}">
                <i class="fas fa-images"></i> Slideshow
            </a>
            @endif
            @if(in_array('portofolio', array_map('strtolower', $modulAktif)))
            <a href="/admin/portofolio" class="nav-item {{ request()->is('admin/portofolio*') ? 'active' : '' }}">
                <i class="fas fa-briefcase"></i> Portofolio
            </a>
            @endif
            @if(in_array('faq', array_map('strtolower', $modulAktif)))
            <a href="/admin/faq" class="nav-item {{ request()->is('admin/faq*') ? 'active' : '' }}">
                <i class="fas fa-question-circle"></i> FAQ
            </a>
            @endif
            @if(in_array('layanan', array_map('strtolower', $modulAktif)))
            <a href="/admin/layanan" class="nav-item {{ request()->is('admin/layanan*') ? 'active' : '' }}">
                <i class="fas fa-concierge-bell"></i> Layanan
            </a>
            @endif

            {{-- Support Header Section --}}
            <div class="nav-header"><i class="fas fa-life-ring"></i> Support</div>

            @if(in_array('knowledgebase', array_map('strtolower', $modulAktif)))
            <div class="nav-item-group">
                <a href="#" class="nav-item {{ request()->is('admin/kb*') ? 'active' : '' }}" onclick="event.preventDefault(); var sub = document.getElementById('kb-submenu'); var icon = this.querySelector('.arrow-icon'); if(sub.style.display === 'none'){ sub.style.display = 'block'; icon.style.transform = 'rotate(180deg)'; } else { sub.style.display = 'none'; icon.style.transform = 'rotate(0deg)'; }">
                    <i class="fas fa-book-reader"></i>
                    <span style="flex: 1;">Knowledge Base</span>
                    <i class="fas fa-chevron-down arrow-icon" style="font-size: 0.8rem; transition: transform 0.3s; transform: {{ request()->is('admin/kb*') ? 'rotate(180deg)' : 'rotate(0deg)' }}"></i>
                </a>
                <div id="kb-submenu" style="display: {{ request()->is('admin/kb*') ? 'block' : 'none' }}; padding-left: 15px; overflow: hidden; transition: all 0.3s;">
                    <a href="/admin/kb/article" class="nav-item {{ request()->is('admin/kb/article*') ? 'active' : '' }}" style="font-size: 0.9rem;">
                        <i class="fas fa-book" style="width: 18px;"></i> Artikel
                    </a>
                    <a href="/admin/kb/category" class="nav-item {{ request()->is('admin/kb/category*') ? 'active' : '' }}" style="font-size: 0.9rem;">
                        <i class="fas fa-folder-open" style="width: 18px;"></i> Kategori
                    </a>
                </div>
            </div>
            @endif

            @if(in_array('tiket', array_map('strtolower', $modulAktif)))
            <div class="nav-item-group">
                <a href="#" class="nav-item {{ request()->is('admin/tiket*') ? 'active' : '' }}" onclick="event.preventDefault(); var sub = document.getElementById('tiket-submenu'); var icon = this.querySelector('.arrow-icon'); if(sub.style.display === 'none'){ sub.style.display = 'block'; icon.style.transform = 'rotate(180deg)'; } else { sub.style.display = 'none'; icon.style.transform = 'rotate(0deg)'; }">
                    <i class="fas fa-ticket-alt"></i>
                    <span style="flex: 1;">Tiket Support</span>
                    <i class="fas fa-chevron-down arrow-icon" style="font-size: 0.8rem; transition: transform 0.3s; transform: {{ request()->is('admin/tiket*') ? 'rotate(180deg)' : 'rotate(0deg)' }}"></i>
                </a>
                <div id="tiket-submenu" style="display: {{ request()->is('admin/tiket*') ? 'block' : 'none' }}; padding-left: 15px; overflow: hidden; transition: all 0.3s;">
                    <a href="/admin/tiket" class="nav-item {{ request()->is('admin/tiket') || request()->is('admin/tiket/tambah') || request()->is('admin/tiket/detail*') ? 'active' : '' }}" style="font-size: 0.9rem;">
                        <i class="fas fa-list" style="width: 18px;"></i> Semua Tiket
                    </a>
                    <a href="/admin/tiket/kategori" class="nav-item {{ request()->is('admin/tiket/kategori*') ? 'active' : '' }}" style="font-size: 0.9rem;">
                        <i class="fas fa-tags" style="width: 18px;"></i> Kategori
                    </a>
                </div>
            </div>
            @endif

            @if(in_array('chat', array_map('strtolower', $modulAktif)))
            <div class="nav-item-group">
                <a href="#" class="nav-item {{ request()->is('admin/chat*') ? 'active' : '' }}" onclick="event.preventDefault(); var sub = document.getElementById('chat-submenu'); var icon = this.querySelector('.arrow-icon'); if(sub.style.display === 'none'){ sub.style.display = 'block'; icon.style.transform = 'rotate(180deg)'; } else { sub.style.display = 'none'; icon.style.transform = 'rotate(0deg)'; }">
                    <i class="fas fa-comments"></i>
                    <span style="flex: 1;">Chat Widget</span>
                    <i class="fas fa-chevron-down arrow-icon" style="font-size: 0.8rem; transition: transform 0.3s; transform: {{ request()->is('admin/chat*') ? 'rotate(180deg)' : 'rotate(0deg)' }}"></i>
                </a>
                <div id="chat-submenu" style="display: {{ request()->is('admin/chat*') ? 'block' : 'none' }}; padding-left: 15px; overflow: hidden; transition: all 0.3s;">
                    <a href="/admin/chat" class="nav-item {{ request()->is('admin/chat') && !request()->is('admin/chat/sessions') ? 'active' : '' }}" style="font-size: 0.9rem;">
                        <i class="fas fa-cog" style="width: 18px;"></i> Widgets
                    </a>
                    <a href="/admin/chat/sessions" class="nav-item {{ request()->is('admin/chat/sessions*') ? 'active' : '' }}" style="font-size: 0.9rem;">
                        <i class="fas fa-history" style="width: 18px;"></i> Sessions
                    </a>
                </div>
            </div>
            @endif
            {{-- System Header --}}
            <div class="nav-header"><i class="fas fa-cogs"></i> System Config</div>

            <a href="/admin/modul" class="nav-item {{ request()->is('admin/modul*') ? 'active' : '' }}">
                <i class="fas fa-cubes"></i> Modul
            </a>
            @if(in_array('kontak', array_map('strtolower', $modulAktif)))
            <a href="/admin/kontak" class="nav-item {{ request()->is('admin/kontak*') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Pesan Kontak
            </a>
            @endif
            @if(in_array('komentar', array_map('strtolower', $modulAktif)))
            <a href="/admin/komentar" class="nav-item {{ request()->is('admin/komentar*') ? 'active' : '' }}">
                <i class="fas fa-comments"></i> Komentar
            </a>
            @endif
            @if(in_array('menu', array_map('strtolower', $modulAktif)))
            <a href="/admin/menu" class="nav-item {{ request()->is('admin/menu*') ? 'active' : '' }}">
                <i class="fas fa-list"></i> Menu
            </a>
            @endif
            <a href="/admin/tema" class="nav-item {{ request()->is('admin/tema*') ? 'active' : '' }}">
                <i class="fas fa-palette"></i> Tema
            </a>
            <a href="/admin/pengguna" class="nav-item {{ request()->is('admin/pengguna*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Pengguna
            </a>
            <a href="/admin/client" class="nav-item {{ request()->is('admin/client*') ? 'active' : '' }}">
                <i class="fas fa-user-tie"></i> Client
            </a>
            <a href="/admin/pengaturan" class="nav-item {{ request()->is('admin/pengaturan*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Pengaturan
            </a>
        </nav>

        <div class="sidebar-footer">
            <form action="/keluar" method="POST" style="width: 100%;">
                @csrf
                <button type="submit" class="nav-item" style="color: #ef4444; width: 100%; border: none; background: none; text-align: left; font-family: inherit; font-size: inherit; cursor: pointer;">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="main">
        <header class="header">
            <div class="header-brand">
                <button class="mobile-toggle" id="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="dot"></div>
                <nav style="font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 8px;">
                    <span style="color: var(--text-muted);">Admin</span>
                    @php 
                        $segments = request()->segments();
                        $breadcrumb = '';
                    @endphp
                    @foreach($segments as $segment)
                        @if($segment != 'admin')
                            <i class="fas fa-chevron-right" style="font-size: 0.7rem; color: var(--text-muted);"></i>
                            <span style="color: var(--text-main); font-weight: 600;">{{ ucfirst($segment) }}</span>
                        @endif
                    @endforeach
                </nav>
            </div>

            <div class="header-user">
                <a href="/" target="_blank" title="Lihat Website" style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; background: #f8fafc; color: var(--text-muted); text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff';" onmouseout="this.style.background='#f8fafc'; this.style.color='var(--text-muted)';">
                    <i class="fas fa-globe"></i>
                </a>
                <div class="info">
                    <h4>Hi {{ auth()->user()?->nama ?? 'Administrator' }}</h4>
                    <span>{{ auth()->user()?->email }}</span>
                </div>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()?->nama ?? 'Administrator') }}&background=4e73df&color=fff" alt="Avatar" style="width: 45px; height: 45px; border-radius: 12px;">
            </div>
        </header>

        <section class="content">
            @if(session('berhasil'))
                <div class="alert">
                    <i class="fas fa-check-circle"></i> {{ session('berhasil') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert" style="background: #fef2f2; color: #991b1b;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: flex-end;">
                <div>
                    <h1 style="font-size: 1.8rem; font-weight: 700;">@yield('judul')</h1>
                    <p style="color: var(--text-muted);">Selamat pagi, {{ auth()->user()?->nama ?? 'Administrator' }}. Berikut ringkasan sistem hari ini.</p>
                </div>
                <div style="background: var(--primary); color: #ffffff; padding: 10px 20px; border-radius: 12px; display: flex; align-items: center; gap: 10px;">
                    <i class="far fa-clock"></i>
                    <span id="realtime-clock" style="font-weight: 600;">{{ now()->format('H.i.s') }}</span>
                </div>
            </div>

            @yield('konten')
        </section>
    </main>

    <div id="sidebar-overlay" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9;"></div>

    <script>
        // Sidebar Toggle Mobile
        const sidebar = document.querySelector('.sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            overlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);
        }

        // Jam Realtime
        const clockElement = document.getElementById('realtime-clock');
        if (clockElement) {
            setInterval(() => {
                const now = new Date();
                const jam = String(now.getHours()).padStart(2, '0');
                const menit = String(now.getMinutes()).padStart(2, '0');
                const detik = String(now.getSeconds()).padStart(2, '0');
                clockElement.textContent = `${jam}.${menit}.${detik}`;
            }, 1000);
        }
    </script>
    @if(in_array('chat', array_map('strtolower', $modulAktif)))
        @include('chat::admin.agent_widget')
    @endif
    @yield('scripts')
</body>
</html>
