<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPSA - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --orange: #F07B1D;
            --orange-dark: #d9690e;
            --orange-light: #FFF3E8;
            --sidebar-width: 220px;
            --bg: #F4F6F9;
            --text: #1a1a2e;
            --muted: #6c757d;
            --white: #ffffff;
            --card-shadow: 0 2px 12px rgba(0,0,0,0.07);
            --radius: 12px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--white);
            border-right: 1px solid #eee;
            display: flex;
            flex-direction: column;
            z-index: 100;
            box-shadow: 2px 0 8px rgba(0,0,0,0.04);
            transition: transform .3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 20px 16px;
            border-bottom: 1px solid #f0f0f0;
        }

        .brand-icon {
            width: 40px; height: 40px;
            background: var(--orange);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: white;
            font-size: 18px;
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 800;
            color: var(--orange);
            letter-spacing: -0.5px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--muted);
            font-size: 14px;
            font-weight: 500;
            transition: all .2s;
        }

        .nav-item a:hover,
        .nav-item a.active {
            background: var(--orange-light);
            color: var(--orange);
        }

        .nav-item a.active {
            font-weight: 600;
        }

        .nav-item a i { font-size: 16px; }

        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid #f0f0f0;
        }

        .btn-logout {
            width: 100%;
            background: #ff4d4d;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 13px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            gap: 8px;
            transition: background .2s;
            text-decoration: none;
        }

        .btn-logout:hover { background: #e03333; color: white; }

        /* ── MAIN ── */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: var(--white);
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            position: sticky; top: 0;
            z-index: 50;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }

        .topbar-left {
            display: flex; align-items: center; gap: 12px;
        }

        .btn-toggle {
            background: none; border: none; cursor: pointer;
            font-size: 20px; color: var(--muted);
            padding: 4px;
        }

        .topbar-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--text);
        }

        .topbar-right {
            display: flex; align-items: center; gap: 14px;
        }

        .user-info {
            display: flex; align-items: center; gap: 10px;
        }

        .user-avatar {
            width: 34px; height: 34px;
            background: var(--orange-light);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--orange);
            font-size: 16px;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
        }

        .badge-jurusan {
            background: var(--orange);
            color: white;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .cart-btn {
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 22px;
            color: var(--text);
            padding: 4px 6px;
            text-decoration: none;
            transition: color .2s;
        }

        .cart-btn:hover { color: var(--orange); }

        .cart-badge {
            position: absolute;
            top: 0; right: 0;
            background: var(--orange);
            color: white;
            font-size: 10px;
            font-weight: 700;
            min-width: 16px; height: 16px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            line-height: 1;
        }

        /* ── PAGE BODY ── */
        .page-body {
            flex: 1;
            padding: 28px;
        }

        /* ── CARD ── */
        .card-spsa {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            border: 1px solid #eef0f3;
            overflow: hidden;
        }

        .card-header-spsa {
            padding: 18px 22px;
            border-bottom: 1px solid #f0f2f5;
            display: flex; align-items: center; justify-content: space-between;
        }

        .card-header-spsa h5 {
            font-size: 15px;
            font-weight: 700;
            margin: 0;
        }

        /* ── TABLE ── */
        .table-spsa {
            width: 100%;
            border-collapse: collapse;
        }

        .table-spsa thead th {
            background: #FAFBFC;
            padding: 12px 16px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--muted);
            border-bottom: 2px solid #eef0f3;
            text-align: left;
        }

        .table-spsa tbody tr {
            border-bottom: 1px solid #f4f5f7;
            transition: background .15s;
        }

        .table-spsa tbody tr:hover { background: #fafbfc; }

        .table-spsa tbody td {
            padding: 14px 16px;
            font-size: 14px;
            vertical-align: middle;
        }

        .table-spsa tbody tr:last-child { border-bottom: none; }

        /* ── BADGES ── */
        .badge-pinjam {
            background: #22c55e;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            display: inline-flex; align-items: center; gap: 5px;
            text-decoration: none;
            transition: background .2s, transform .1s;
        }

        .badge-pinjam:hover {
            background: #16a34a;
            color: white;
            transform: translateY(-1px);
        }

        .badge-habis {
            background: #ef4444;
            color: white;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-keranjang {
            background: var(--orange);
            color: white;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex; align-items: center; gap: 5px;
            cursor: pointer; border: none;
            font-family: inherit;
            text-decoration: none;
            transition: background .2s;
        }

        .badge-keranjang:hover {
            background: var(--orange-dark);
            color: white;
        }

        /* ── STAT CARDS ── */
        .stat-card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            padding: 20px;
            display: flex; align-items: center; gap: 16px;
            border: 1px solid #eef0f3;
        }

        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
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

        /* ── ALERTS ── */
        .alert-spsa {
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 500;
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 20px;
        }

        /* ── SIDEBAR OVERLAY (mobile) ── */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 99;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-display"></i>
        </div>
        <span class="brand-name">SPSA</span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-item">
            <a href="{{ route('mahasiswa.dashboard') }}"
               class="{{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door-fill"></i> Dashboard
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('mahasiswa.keranjang') }}"
               class="{{ request()->routeIs('mahasiswa.keranjang') ? 'active' : '' }}">
                <i class="bi bi-cart-check"></i> Keranjang
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('mahasiswa.riwayat') }}"
               class="{{ request()->routeIs('mahasiswa.riwayat') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat
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

<!-- MAIN CONTENT -->
<div class="main-content">
    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-left">
            <button class="btn-toggle" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <span class="topbar-title">@yield('page-title', 'Dashboard Pengguna')</span>
        </div>
        <div class="topbar-right">
            <a href="{{ route('mahasiswa.keranjang') }}" class="cart-btn">
                <i class="bi bi-basket2-fill"></i>
                @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                @if($cartCount > 0)
                    <span class="cart-badge">{{ $cartCount }}</span>
                @endif
            </a>
            <div class="user-info">
                <div class="user-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <div class="user-name">{{ Auth::user()->nama ?? 'Pengguna' }}</div>
                </div>
            </div>
            <span class="badge-jurusan">{{ Auth::user()->jurusan ?? '-' }}</span>
        </div>
    </div>

    <!-- PAGE BODY -->
    <div class="page-body">
        @if(session('success'))
            <div class="alert-spsa" style="background:#dcfce7; color:#166534;">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-spsa" style="background:#fee2e2; color:#991b1b;">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        const sb = document.getElementById('sidebar');
        const ov = document.getElementById('sidebarOverlay');
        sb.classList.toggle('open');
        ov.classList.toggle('show');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('show');
    }
</script>
@stack('scripts')
</body>
</html>