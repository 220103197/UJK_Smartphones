<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TechShop')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: #f5f6fa;
            color: #333;
            min-height: 100vh;
        }

        /* ---- NAVBAR ---- */
        .navbar-top {
            background: #fff;
            border-bottom: 2px solid #e8e8e8;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand {
            font-size: 1.4rem;
            font-weight: 800;
            color: #2563eb;
            text-decoration: none;
        }

        .brand span {
            color: #f97316;
        }

        .nav-links {
            display: flex;
            gap: 6px;
        }

        .nav-links a {
            padding: 7px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 600;
            color: #666;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s;
        }

        .nav-links a:hover {
            background: #f0f4ff;
            color: #2563eb;
        }

        .nav-links a.active {
            background: #2563eb;
            color: #fff;
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-chip {
            background: #f0f4ff;
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #2563eb;
        }

        .btn-logout {
            background: #fff;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            padding: 6px 14px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #888;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s;
        }

        .btn-logout:hover {
            border-color: #ef4444;
            color: #ef4444;
        }

        /* ---- CONTENT ---- */
        .main-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 28px 20px;
        }

        /* ---- CARD ---- */
        .card-box {
            background: #fff;
            border: 1.5px solid #e8e8e8;
            border-radius: 14px;
            overflow: hidden;
        }

        .card-head {
            padding: 16px 22px;
            border-bottom: 1.5px solid #e8e8e8;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fafafa;
        }

        .card-head h2 {
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
            color: #222;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-body {
            padding: 22px;
        }

        /* ---- STAT CARDS ---- */
        .stat-box {
            background: #fff;
            border: 1.5px solid #e8e8e8;
            border-radius: 12px;
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .stat-value {
            font-size: 1.6rem;
            font-weight: 800;
            color: #222;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.78rem;
            color: #888;
            margin-top: 3px;
        }

        /* ---- TABLE ---- */
        .simple-table {
            width: 100%;
            border-collapse: collapse;
        }

        .simple-table thead th {
            background: #f8f9fb;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #999;
            padding: 12px 16px;
            border-bottom: 1.5px solid #e8e8e8;
            white-space: nowrap;
        }

        .simple-table tbody tr {
            transition: background 0.1s;
        }

        .simple-table tbody tr:hover {
            background: #fafbff;
        }

        .simple-table td {
            padding: 13px 16px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.88rem;
            vertical-align: middle;
        }

        /* ---- BUTTONS ---- */
        .btn-blue {
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 18px;
            font-family: 'Nunito', sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: all 0.15s;
        }

        .btn-blue:hover {
            background: #1d4ed8;
            color: #fff;
        }

        .btn-outline {
            background: #fff;
            color: #555;
            border: 1.5px solid #d0d0d0;
            border-radius: 8px;
            padding: 7px 14px;
            font-family: 'Nunito', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s;
        }

        .btn-outline:hover {
            border-color: #2563eb;
            color: #2563eb;
        }

        .btn-red {
            background: #fff;
            color: #aaa;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            padding: 7px 12px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-red:hover {
            border-color: #ef4444;
            color: #ef4444;
        }

        /* ---- FORM ---- */
        .form-label {
            font-size: 0.82rem;
            font-weight: 700;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            border: 1.5px solid #d8d8d8;
            border-radius: 8px;
            padding: 9px 13px;
            font-family: 'Nunito', sans-serif;
            font-size: 0.9rem;
            color: #333;
            background: #fff;
            transition: border-color 0.15s;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: #bbb;
        }

        .section-title {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #2563eb;
            padding-bottom: 10px;
            border-bottom: 1.5px solid #e8e8e8;
            margin-bottom: 18px;
        }

        /* ---- BADGES ---- */
        .badge-green {
            background: #dcfce7;
            color: #16a34a;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-yellow {
            background: #fef9c3;
            color: #ca8a04;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-gray {
            background: #f3f4f6;
            color: #6b7280;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-blue {
            background: #dbeafe;
            color: #2563eb;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-orange {
            background: #ffedd5;
            color: #ea580c;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        /* ---- ALERTS ---- */
        .alert-box {
            border-radius: 10px;
            padding: 13px 16px;
            font-size: 0.88rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 18px;
            border: 1.5px solid;
        }

        .alert-success {
            background: #f0fdf4;
            border-color: #86efac;
            color: #166534;
        }

        .alert-danger {
            background: #fef2f2;
            border-color: #fca5a5;
            color: #991b1b;
        }

        .alert-info {
            background: #eff6ff;
            border-color: #93c5fd;
            color: #1d4ed8;
        }

        /* ---- PAGINATION ---- */
        .pagination .page-link {
            background: #fff;
            border-color: #e0e0e0;
            color: #555;
            border-radius: 7px !important;
            margin: 0 2px;
            font-size: 0.85rem;
        }

        .pagination .page-link:hover,
        .pagination .page-item.active .page-link {
            background: #2563eb;
            border-color: #2563eb;
            color: #fff;
        }

        /* ---- SEARCH ---- */
        .search-wrap {
            position: relative;
        }

        .search-wrap i {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #bbb;
            font-size: 0.9rem;
        }

        .search-wrap input {
            padding-left: 34px;
        }

        /* ---- PAGE HEADING ---- */
        .page-heading {
            font-size: 1.35rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <header class="navbar-top">
        <a href="{{ route('smartphones.index') }}" class="brand">Tech<span>Shop</span></a>

        <nav class="nav-links">
            <a href="{{ route('smartphones.index') }}"
                class="{{ request()->routeIs('smartphones.*') ? 'active' : '' }}">
                <i class="bi bi-phone"></i> Smartphone
            </a>
            <a href="{{ route('transaksi.index') }}" class="{{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i> Transaksi
            </a>
        </nav>

        <div class="user-area">
            <span class="user-chip">
                <i class="bi bi-person-fill me-1"></i>{{ Auth::user()->name }}
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i> Keluar
                </button>
            </form>
        </div>
    </header>

    {{-- KONTEN --}}
    <div class="main-wrap">

        {{-- Pesan Flash --}}
        @if (session('success'))
            <div class="alert-box alert-success">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('info'))
            <div class="alert-box alert-info">
                <i class="bi bi-info-circle-fill"></i>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-box alert-danger">
                <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                <div>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
