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
            --primary-light: #f8fafc;
            --bg-body: #f8fafc; /* Slate 50 background for clean, modern workspace */
            --sidebar-bg: #ffffff;
            --card-bg: #ffffff;
            --text-main: #334155; /* Slate 700 main text */
            --text-muted: #64748b; /* Slate 500 muted text */
            --accent: #f1f5f9; /* Slate 100 accent */
            --shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --border: #f1f5f9; /* Slate 100 border - extremely premium, light, and clean */
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-size: 13px;
            letter-spacing: -0.01em;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            width: 220px;
            min-width: 220px;
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
            height: 52px;
            padding: 0 16px;
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 0.8125rem;
            font-weight: 700;
            color: #1a1a2e;
            border-bottom: 1px solid #f0f0f0;
            letter-spacing: -0.02em;
            flex-shrink: 0;
        }

        .sidebar-logo i {
            font-size: 0.9rem;
            color: var(--primary);
        }

        .sidebar-nav {
            flex: 1;
            padding: 10px 10px 10px;
            overflow-y: auto;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 3px;
        }
        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 20px;
        }

        /* Section label — clean, no icon, elegant spacing */
        .nav-header {
            padding: 24px 12px 6px;
            font-size: 0.65rem;
            font-weight: 600;
            color: #94a3b8; /* Slate 400 */
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .nav-header i {
            display: none;
        }

        /* Nav item — Vercel/Notion inspired */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            color: #475569; /* Slate 600 */
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 2px;
            font-weight: 500; /* refined semi-bold feel */
            font-size: 0.8125rem;
            letter-spacing: -0.01em;
            transition: all 0.12s ease-in-out;
            cursor: pointer;
            line-height: 1.4;
            position: relative;
        }

        .nav-item i {
            width: 16px;
            font-size: 0.825rem;
            text-align: center;
            flex-shrink: 0;
            color: #94a3b8; /* Slate 400 */
            transition: color 0.12s ease;
        }

        .nav-item:hover {
            background: #f1f5f9; /* Slate 100 */
            color: #0f172a; /* Slate 900 */
        }

        .nav-item:hover i {
            color: #475569; /* Slate 600 */
        }

        /* Active state — premium pill */
        .nav-item.active {
            background: #f1f5f9; /* Slate 100 */
            color: #0f172a; /* Slate 900 */
            font-weight: 600;
        }

        .nav-item.active i {
            color: var(--primary); /* Keep brand color on active icon */
        }

        /* Submenu — visual guideline like Notion */
        .submenu {
            padding-left: 12px;
            margin-left: 19px;
            margin-top: 2px;
            margin-bottom: 4px;
            border-left: 1.5px solid #e2e8f0; /* Slate 200 guideline */
        }

        .submenu .nav-item {
            font-size: 0.775rem;
            padding: 6px 10px;
            color: #64748b; /* Slate 500 */
            font-weight: 450;
            border-radius: 6px;
        }

        .submenu .nav-item i {
            font-size: 0.65rem;
            width: 13px;
            color: #94a3b8;
        }

        .submenu .nav-item.active {
            color: var(--primary);
            font-weight: 600;
            background: #f1f5f9;
        }

        .submenu .nav-item:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        /* Arrow */
        .arrow-icon {
            margin-left: auto !important;
            font-size: 0.55rem !important;
            width: auto !important;
            transition: transform 0.2s ease !important;
            color: #94a3b8 !important;
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 8px 10px 14px;
            border-top: 1px solid #f0f0f0;
        }

        .sidebar-footer .nav-item {
            color: #ef4444;
            font-size: 0.8125rem;
            font-weight: 400;
        }

        .sidebar-footer .nav-item i {
            color: #fca5a5;
        }

        .sidebar-footer .nav-item:hover {
            background: #fff0f0;
            color: #c53030;
        }

        /* ========== MAIN CONTENT ========== */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .header {
            height: 52px;
            background: #ffffff;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 5;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-brand .dot {
            width: 6px;
            height: 6px;
            background: #22c55e;
            border-radius: 50%;
        }

        .header-brand nav {
            font-size: 0.75rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 12px;
            text-align: right;
        }

        .header-user .info h4 {
            font-size: 0.775rem;
            font-weight: 600;
            color: #1e293b; /* Slate 800 */
            letter-spacing: -0.010em;
        }

        .header-user .info span {
            font-size: 0.675rem;
            color: var(--text-muted);
        }

        /* Avatar */
        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
        }

        .content {
            padding: 24px 28px;
        }

        /* ========== PAGE HEADER ========== */
        .page-header {
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .page-header h1 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1a202c;
            letter-spacing: -0.025em;
        }

        .page-header p {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* ========== CARDS ========== */
        .card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 18px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            margin-bottom: 18px;
        }

        .card h3 {
            font-size: 0.825rem;
            margin-bottom: 14px;
            font-weight: 600;
            color: #1a202c;
        }

        /* ========== BUTTONS ========== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 14px;
            background: var(--primary);
            color: #ffffff;
            border: none;
            border-radius: 7px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.775rem;
            transition: filter 0.15s;
            font-family: inherit;
        }

        .btn:hover {
            filter: brightness(1.08);
        }

        .btn-sm {
            padding: 5px 11px;
            font-size: 0.725rem;
            border-radius: 6px;
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--border);
        }

        .btn-outline:hover {
            background: var(--primary-light);
            filter: none;
        }

        /* ========== FORMS ========== */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="url"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 7px 11px;
            border-radius: 7px;
            border: 1px solid #dde2e8;
            background-color: #ffffff !important;
            color: var(--text-main);
            font-family: inherit;
            font-size: 0.775rem;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.08);
        }

        label {
            font-size: 0.75rem;
            font-weight: 500;
            color: #4a5568;
            display: block;
            margin-bottom: 4px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        /* ========== BADGES ========== */
        .badge {
            padding: 3px 8px;
            border-radius: 5px;
            font-size: 0.675rem;
            font-weight: 600;
            background: var(--accent);
            color: var(--primary);
        }

        /* ========== TABLES ========== */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 9px 13px;
            font-size: 0.7rem;
            color: #718096;
            font-weight: 600;
            border-bottom: 1px solid var(--border);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        td {
            padding: 10px 13px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            font-size: 0.775rem;
            color: #374151;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: #fafbfc;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 14px;
        }

        table {
            min-width: 640px;
        }

        /* ========== ALERTS ========== */
        .alert {
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 18px;
            background: #f0fdf4;
            color: #15803d;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.775rem;
            border: 1px solid #bbf7d0;
        }

        .alert.alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }

        /* ========== STAT GRID ========== */
        .grid-dashboard {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 18px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 16px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow);
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .stat-info .label {
            font-size: 0.675rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.06em;
        }

        .stat-info .value {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1a202c;
            margin-top: 1px;
            letter-spacing: -0.025em;
        }

        /* Clock widget */
        .clock-widget {
            background: var(--primary);
            color: #ffffff;
            padding: 7px 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.775rem;
            font-weight: 600;
        }

        /* ========== MOBILE ========== */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1rem;
            color: var(--primary);
            cursor: pointer;
            padding: 6px;
        }

        @media (max-width: 1024px) {
            .sidebar {
                position: fixed;
                left: -220px;
                transition: left 0.25s ease;
                box-shadow: 4px 0 16px rgba(0,0,0,0.08);
            }

            .sidebar.show {
                left: 0;
            }

            .header {
                padding: 0 16px;
            }

            .mobile-toggle {
                display: block;
            }

            .content {
                padding: 18px 16px;
            }

            .header-user .info {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .grid-dashboard {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            .header-brand nav {
                display: none !important;
            }
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
                <i class="fas fa-chart-line"></i> Statistics
            </a>
            @endif
            @if(in_array('artikel', array_map('strtolower', $modulAktif)))
            <a href="/admin/artikel" class="nav-item {{ request()->is('admin/artikel*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Articles
            </a>
            @endif
            @if(in_array('berita', array_map('strtolower', $modulAktif)))
            <div class="nav-item-group">
                <a href="#" class="nav-item {{ request()->is('admin/berita*') ? 'active' : '' }}" onclick="event.preventDefault(); var sub = document.getElementById('berita-submenu'); var icon = this.querySelector('.arrow-icon'); if(sub.style.display === 'none'){ sub.style.display = 'block'; icon.style.transform = 'rotate(180deg)'; } else { sub.style.display = 'none'; icon.style.transform = 'rotate(0deg)'; }">
                    <i class="fas fa-newspaper"></i>
                    <span style="flex: 1;">News</span>
                    <i class="fas fa-chevron-down arrow-icon" style="font-size: 0.8rem; transition: transform 0.3s; transform: {{ request()->is('admin/berita*') ? 'rotate(180deg)' : 'rotate(0deg)' }}"></i>
                </a>
                <div id="berita-submenu" class="submenu" style="display: {{ request()->is('admin/berita*') ? 'block' : 'none' }}">
                    <a href="/admin/berita" class="nav-item {{ request()->is('admin/berita') || request()->is('admin/berita/tambah') || request()->is('admin/berita/ubah*') ? 'active' : '' }}">
                        <i class="fas fa-list"></i> All News
                    </a>
                    <a href="/admin/berita/kategori" class="nav-item {{ request()->is('admin/berita/kategori*') ? 'active' : '' }}">
                        <i class="fas fa-folder-open"></i> Categories
                    </a>
                </div>
            </div>
            @endif
            @if(in_array('iklan', array_map('strtolower', $modulAktif)))
            <a href="/admin/iklan" class="nav-item {{ request()->is('admin/iklan*') ? 'active' : '' }}">
                <i class="fas fa-ad"></i> Ads
            </a>
            @endif
            @if(in_array('video', array_map('strtolower', $modulAktif)))
            <a href="/admin/video" class="nav-item {{ request()->is('admin/video*') ? 'active' : '' }}">
                <i class="fas fa-video"></i> Videos
            </a>
            @endif
            @if(in_array('slideshow', array_map('strtolower', $modulAktif)))
            <a href="/admin/slideshow" class="nav-item {{ request()->is('admin/slideshow*') ? 'active' : '' }}">
                <i class="fas fa-images"></i> Slideshow
            </a>
            @endif
            @if(in_array('portofolio', array_map('strtolower', $modulAktif)))
            <a href="/admin/portofolio" class="nav-item {{ request()->is('admin/portofolio*') ? 'active' : '' }}">
                <i class="fas fa-briefcase"></i> Portfolio
            </a>
            @endif
            @if(in_array('faq', array_map('strtolower', $modulAktif)))
            <a href="/admin/faq" class="nav-item {{ request()->is('admin/faq*') ? 'active' : '' }}">
                <i class="fas fa-question-circle"></i> FAQ
            </a>
            @endif
            @if(in_array('layanan', array_map('strtolower', $modulAktif)))
            <a href="/admin/layanan" class="nav-item {{ request()->is('admin/layanan*') ? 'active' : '' }}">
                <i class="fas fa-concierge-bell"></i> Services
            </a>
            @endif

            {{-- Support Header Section --}}
            <div class="nav-header"><i class="fas fa-life-ring"></i> Support</div>

            @if(in_array('task', array_map('strtolower', $modulAktif)))
            <a href="/admin/task" class="nav-item {{ request()->is('admin/task*') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i> Task Management
            </a>
            @endif

            @if(in_array('knowledgebase', array_map('strtolower', $modulAktif)))
            <div class="nav-item-group">
                <a href="#" class="nav-item {{ request()->is('admin/kb*') ? 'active' : '' }}" onclick="event.preventDefault(); var sub = document.getElementById('kb-submenu'); var icon = this.querySelector('.arrow-icon'); if(sub.style.display === 'none'){ sub.style.display = 'block'; icon.style.transform = 'rotate(180deg)'; } else { sub.style.display = 'none'; icon.style.transform = 'rotate(0deg)'; }">
                    <i class="fas fa-book-reader"></i>
                    <span style="flex: 1;">Knowledge Base</span>
                    <i class="fas fa-chevron-down arrow-icon" style="font-size: 0.8rem; transition: transform 0.3s; transform: {{ request()->is('admin/kb*') ? 'rotate(180deg)' : 'rotate(0deg)' }}"></i>
                </a>
                <div id="kb-submenu" class="submenu" style="display: {{ request()->is('admin/kb*') ? 'block' : 'none' }}">
                    <a href="/admin/kb/article" class="nav-item {{ request()->is('admin/kb/article*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i> Articles
                    </a>
                    <a href="/admin/kb/category" class="nav-item {{ request()->is('admin/kb/category*') ? 'active' : '' }}">
                        <i class="fas fa-folder-open"></i> Categories
                    </a>
                </div>
            </div>
            @endif

            @if(in_array('tiket', array_map('strtolower', $modulAktif)))
            <div class="nav-item-group">
                <a href="#" class="nav-item {{ request()->is('admin/tiket*') ? 'active' : '' }}" onclick="event.preventDefault(); var sub = document.getElementById('tiket-submenu'); var icon = this.querySelector('.arrow-icon'); if(sub.style.display === 'none'){ sub.style.display = 'block'; icon.style.transform = 'rotate(180deg)'; } else { sub.style.display = 'none'; icon.style.transform = 'rotate(0deg)'; }">
                    <i class="fas fa-ticket-alt"></i>
                    <span style="flex: 1;">Support Tickets</span>
                    <i class="fas fa-chevron-down arrow-icon" style="font-size: 0.8rem; transition: transform 0.3s; transform: {{ request()->is('admin/tiket*') ? 'rotate(180deg)' : 'rotate(0deg)' }}"></i>
                </a>
                <div id="tiket-submenu" class="submenu" style="display: {{ request()->is('admin/tiket*') ? 'block' : 'none' }}">
                    <a href="/admin/tiket" class="nav-item {{ request()->is('admin/tiket') || request()->is('admin/tiket/tambah') || request()->is('admin/tiket/detail*') ? 'active' : '' }}">
                        <i class="fas fa-list"></i> All Tickets
                    </a>
                    <a href="/admin/tiket/kategori" class="nav-item {{ request()->is('admin/tiket/kategori*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i> Categories
                    </a>
                    <a href="/admin/tiket/makro" class="nav-item {{ request()->is('admin/tiket/makro*') ? 'active' : '' }}">
                        <i class="fas fa-bolt"></i> Macro
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
                <div id="chat-submenu" class="submenu" style="display: {{ request()->is('admin/chat*') ? 'block' : 'none' }}">
                    <a href="/admin/chat" class="nav-item {{ request()->is('admin/chat') && !request()->is('admin/chat/sessions') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> Widgets
                    </a>
                    <a href="/admin/chat/sessions" class="nav-item {{ request()->is('admin/chat/sessions*') ? 'active' : '' }}">
                        <i class="fas fa-history"></i> Sessions
                    </a>
                </div>
            </div>
            @endif
            {{-- System Header --}}
            <div class="nav-header"><i class="fas fa-cogs"></i> System Config</div>

            <a href="/admin/modul" class="nav-item {{ request()->is('admin/modul*') ? 'active' : '' }}">
                <i class="fas fa-cubes"></i> Modules
            </a>
            @if(in_array('kontak', array_map('strtolower', $modulAktif)))
            <a href="/admin/kontak" class="nav-item {{ request()->is('admin/kontak*') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Contact Messages
            </a>
            @endif
            @if(in_array('komentar', array_map('strtolower', $modulAktif)))
            <a href="/admin/komentar" class="nav-item {{ request()->is('admin/komentar*') ? 'active' : '' }}">
                <i class="fas fa-comments"></i> Comments
            </a>
            @endif
            @if(in_array('menu', array_map('strtolower', $modulAktif)))
            <a href="/admin/menu" class="nav-item {{ request()->is('admin/menu*') ? 'active' : '' }}">
                <i class="fas fa-list"></i> Menus
            </a>
            @endif
            <a href="/admin/tema" class="nav-item {{ request()->is('admin/tema*') ? 'active' : '' }}">
                <i class="fas fa-palette"></i> Themes
            </a>
            <a href="/admin/pengguna" class="nav-item {{ request()->is('admin/pengguna*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Users
            </a>
            <a href="/admin/client" class="nav-item {{ request()->is('admin/client*') ? 'active' : '' }}">
                <i class="fas fa-user-tie"></i> Clients
            </a>
            <a href="/admin/pengaturan" class="nav-item {{ request()->is('admin/pengaturan*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Settings
            </a>
        </nav>

        <div class="sidebar-footer">
            <form action="/keluar" method="POST" style="width: 100%;">
                @csrf
                <button type="submit" class="nav-item" style="width: 100%; border: none; background: none; text-align: left; font-family: inherit; cursor: pointer; color: #e53e3e;">
                    <i class="fas fa-sign-out-alt" style="color: #e53e3e;"></i> Logout
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
                <nav>
                    <span style="color: var(--text-muted); font-size: 0.725rem;">Admin</span>
                    @php 
                        $segments = request()->segments();
                    @endphp
                    @foreach($segments as $segment)
                        @if($segment != 'admin')
                            <i class="fas fa-chevron-right" style="font-size: 0.55rem; color: #cbd5e0; margin: 0 3px;"></i>
                            <span style="color: #374151; font-weight: 600; font-size: 0.725rem;">{{ ucfirst($segment) }}</span>
                        @endif
                    @endforeach
                </nav>
            </div>

            <div class="header-user">
                <a href="/" target="_blank" title="Lihat Website" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 7px; background: #f5f7fa; color: var(--text-muted); text-decoration: none; transition: all 0.15s; font-size: 0.775rem;" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff';" onmouseout="this.style.background='#f5f7fa'; this.style.color='var(--text-muted)';">
                    <i class="fas fa-globe"></i>
                </a>
                <div class="info">
                    <h4>{{ auth()->user()?->nama ?? 'Administrator' }}</h4>
                    <span>{{ auth()->user()?->email }}</span>
                </div>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()?->nama ?? 'Administrator') }}&background=4e73df&color=fff&size=64" alt="Avatar" style="width: 30px; height: 30px; border-radius: 7px;">
            </div>
        </header>

        <section class="content">
            @if(session('berhasil'))
                <div class="alert">
                    <i class="fas fa-check-circle"></i> {{ session('berhasil') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <div style="margin-bottom: 22px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 style="font-size: 1.15rem; font-weight: 700; color: #1a202c; letter-spacing: -0.02em;">@yield('judul')</h1>
                    <p style="color: var(--text-muted); font-size: 0.75rem; margin-top: 2px;">Selamat pagi, {{ auth()->user()?->nama ?? 'Administrator' }}.</p>
                </div>
                <div class="clock-widget">
                    <i class="far fa-clock" style="font-size: 0.75rem;"></i>
                    <span id="realtime-clock">{{ now()->format('H.i.s') }}</span>
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
