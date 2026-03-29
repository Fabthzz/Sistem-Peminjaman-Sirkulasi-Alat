<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPSA Admin - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1e293b;
            --primary-light: #334155;
            --orange: #F07B1D;
            --orange-dark: #d9690e;
            --orange-light: #FFF3E8;
            --sidebar-width: 230px;
            --bg: #F1F5F9;
            --white: #ffffff;
            --muted: #64748b;
            --card-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
            --radius: 12px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--primary);
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--primary);
            display: flex;
            flex-direction: column;
            z-index: 200;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 22px 20px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: var(--orange);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .brand-name {
            font-size: 13px;
            font-weight: 700;
            color: white;
            line-height: 1.4;
        }

        .brand-sub {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 500;
        }

        .sidebar-section-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.35);
            padding: 16px 20px 6px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 8px 12px;
            overflow-y: auto;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.65);
            font-size: 14px;
            font-weight: 500;
            transition: all .2s;
            margin-bottom: 2px;
        }

        .nav-item a:hover,
        .nav-item a.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-item a.active {
            background: var(--orange);
            color: white;
        }

        .nav-item a i {
            font-size: 16px;
        }

        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .btn-logout {
            width: 100%;
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 13px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all .2s;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: #ef4444;
            color: white;
            border-color: #ef4444;
        }

        /* MAIN */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left .3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        .topbar {
            background: var(--white);
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .topbar-title {
            font-size: 17px;
            font-weight: 700;
        }

        .admin-badge {
            background: var(--primary);
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
        }

        .page-body {
            flex: 1;
            padding: 28px;
        }

        /* CARDS */
        .card-spsa {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .card-header-spsa {
            padding: 18px 22px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .card-header-spsa h5 {
            font-size: 15px;
            font-weight: 700;
            margin: 0;
        }

        /* STAT */
        .stat-card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            border: 1px solid #e2e8f0;
            height: 100%;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .stat-label {
            font-size: 12px;
            color: var(--muted);
            font-weight: 500;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 800;
            line-height: 1.1;
        }

        /* TABLE */
        .table-spsa {
            width: 100%;
            border-collapse: collapse;
        }

        .table-spsa thead th {
            background: #f8fafc;
            padding: 12px 16px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--muted);
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
            white-space: nowrap;
        }

        .table-spsa tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background .15s;
        }

        .table-spsa tbody tr:hover {
            background: #f8fafc;
        }

        .table-spsa tbody td {
            padding: 14px 16px;
            font-size: 14px;
            vertical-align: middle;
        }

        .table-spsa tbody tr:last-child {
            border-bottom: none;
        }

        /* ALERTS */
        .alert-spsa {
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        /* RESPONSIVE */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 20px rgba(0, 0, 0, 0.2);
            }

            .main-content {
                margin-left: 0;
            }

            .page-body {
                padding: 16px;
            }

            .admin-badge {
                display: none;
            }
        }

        @media (min-width: 992px) {
            .sidebar.closed {
                transform: translateX(-100%);
            }
        }

        @media (max-width: 576px) {
            .topbar {
                padding: 10px 14px;
            }

            .topbar-title {
                font-size: 14px;
            }

            .page-body {
                padding: 12px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('image/icons.png') }}" alt="SPSA Logo"
                style="width:38px; height:38px; object-fit:contain; flex-shrink:0;">
            <div>
                <div class="brand-name">Sistem Peminjaman<br>&amp; Sirkulasi Alat</div>
                <div class="brand-sub">Admin Panel</div>
            </div>
        </div>

        <div class="sidebar-section-label">Menu</div>
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.alat.index') }}" class="{{ request()->routeIs('admin.alat.*') ? 'active' : '' }}">
                    <i class="bi bi-tools"></i> Kelola Alat
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.peminjaman.index') }}" class="{{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
                    <i class="bi bi-card-checklist"></i> Persetujuan Alat
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.mahasiswa.index') }}" class="{{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Data Mahasiswa
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.list') }}" class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock"></i>
                    <span>Data Admin</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('mahasiswa.dashboard') }}" class="{{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-cart"></i>
                    <span>Pinjam Alat</span>
                </a>
            </div>
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content" id="mainContent">
        <div class="topbar">
            <div style="display:flex; align-items:center; gap:12px;">
                <button id="toggleBtn" onclick="toggleSidebar()"
                    style="background:none;border:none;cursor:pointer;font-size:20px;color:var(--muted);">
                    <i class="bi bi-list"></i>
                </button>
                <span class="topbar-title">@yield('page-title', 'Dashboard Admin')</span>
            </div>
            <div style="display:flex; align-items:center; gap:12px;">
                <i class="bi bi-person-circle" style="font-size:20px; color:var(--muted);"></i>
                <span style="font-size:13px; font-weight:600;">{{ Auth::user()->nama ?? 'Admin' }}</span>
                <span class="admin-badge">Admin</span>
            </div>
        </div>

        <div class="page-body">
            @if(session('success'))
            <div class="alert-spsa" style="background:#dcfce7; color:#166534;">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert-spsa" style="background:#fee2e2; color:#991b1b;">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
            </div>
            @endif
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('toggleBtn');

        function toggleSidebar() {
            if (window.innerWidth > 991) {
                sidebar.classList.toggle('closed');
                mainContent.classList.toggle('expanded');
            } else {
                sidebar.classList.toggle('open');
            }
        }

        function closeSidebar() {
            if (window.innerWidth > 991) {
                sidebar.classList.add('closed');
                mainContent.classList.add('expanded');
            } else {
                sidebar.classList.remove('open');
            }
        }

        // Klik di luar sidebar (mobile)
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 991 &&
                sidebar.classList.contains('open') &&
                !sidebar.contains(e.target) &&
                !toggleBtn.contains(e.target)) {
                closeSidebar();
            }
        });

        // Reset saat resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 991) {
                sidebar.classList.remove('open');
            } else {
                sidebar.classList.remove('closed');
                mainContent.classList.remove('expanded');
            }
        });
    </script>
    @stack('scripts')
</body>

</html>