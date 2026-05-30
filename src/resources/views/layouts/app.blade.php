<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Meal Planner') }}</title>

    @livewireStyles

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --primary: #f472b6;
            --primary-dark: #db2777;
            --primary-soft: #fce7f3;
            --secondary: #fb7185;
            --green: #22c55e;
            --green-soft: #dcfce7;
            --red: #ef4444;
            --red-soft: #fee2e2;
            --yellow: #f59e0b;
            --yellow-soft: #fef3c7;
            --blue: #3b82f6;
            --blue-soft: #dbeafe;
            --purple: #8b5cf6;
            --purple-soft: #ede9fe;
            --text: #111827;
            --muted: #64748b;
            --border: #f3d7e5;
            --bg: #fff7fb;
            --card: #ffffff;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at top left, rgba(252, 231, 243, 0.9), transparent 34%),
                radial-gradient(circle at top right, rgba(255, 228, 230, 0.75), transparent 30%),
                linear-gradient(135deg, #fff7fb 0%, #fffafe 45%, #ffffff 100%);
            color: var(--text);
        }

        a {
            color: inherit;
        }

        button,
        input,
        select,
        textarea {
            font-family: inherit;
        }

        .app-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 280px minmax(0, 1fr);
        }

        .sidebar {
            min-height: 100vh;
            padding: 28px 18px;
            background: rgba(255, 255, 255, 0.78);
            border-right: 1px solid rgba(244, 114, 182, 0.18);
            backdrop-filter: blur(18px);
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px;
            margin-bottom: 36px;
            text-decoration: none;
        }

        .brand-icon {
            width: 46px;
            height: 46px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f9a8d4, #fb7185);
            color: #ffffff;
            font-size: 24px;
            box-shadow: 0 16px 28px rgba(244, 114, 182, 0.26);
        }

        .brand-text {
            font-size: 22px;
            font-weight: 950;
            color: #be185d;
            letter-spacing: -0.04em;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 50px;
            padding: 0 16px;
            border-radius: 18px;
            color: #475569;
            font-size: 15px;
            font-weight: 850;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            background: #fff1f7;
            color: #be185d;
            transform: translateX(2px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #fbcfe8, #ffe4e6);
            color: #be185d;
            box-shadow: 0 12px 24px rgba(244, 114, 182, 0.18);
        }

        .nav-icon {
            width: 30px;
            height: 30px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
        }

        .sidebar-spacer {
            flex: 1;
        }

        .sidebar-card {
            margin-top: 24px;
            padding: 18px;
            border-radius: 26px;
            background: linear-gradient(160deg, #fff1f7, #fff7ed);
            border: 1px solid rgba(244, 114, 182, 0.18);
            box-shadow: 0 16px 36px rgba(244, 114, 182, 0.12);
        }

        .sidebar-card-title {
            margin: 0;
            font-size: 16px;
            font-weight: 950;
            color: #9d174d;
        }

        .sidebar-card-text {
            margin: 8px 0 16px;
            font-size: 13px;
            line-height: 1.5;
            color: #64748b;
            font-weight: 650;
        }

        .bunny-card-illustration {
            width: 100%;
            height: 148px;
            margin-top: 16px;
            border-radius: 24px;
            background:
                radial-gradient(circle at 22% 22%, rgba(252, 231, 243, 0.95), transparent 32%),
                radial-gradient(circle at 82% 18%, rgba(220, 252, 231, 0.9), transparent 30%),
                linear-gradient(135deg, #ffffff, #fff7fb);
            overflow: hidden;
            border: 1px solid rgba(244, 114, 182, 0.16);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.75);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bunny-image {
            width: 128px;
            height: 128px;
            object-fit: contain;
            display: block;
            filter: drop-shadow(0 12px 18px rgba(244, 114, 182, 0.16));
        }

        .logout-form {
            margin-top: 14px;
        }

        .logout-button {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 18px;
            background: #fb7185;
            color: #ffffff;
            font-size: 15px;
            font-weight: 950;
            cursor: pointer;
            box-shadow: 0 12px 24px rgba(251, 113, 133, 0.22);
        }

        .main-area {
            min-width: 0;
        }

        .topbar {
            min-height: 82px;
            padding: 18px 34px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 16px;
            border-bottom: 1px solid rgba(244, 114, 182, 0.14);
            background: rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(14px);
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .topbar-date {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 14px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid rgba(244, 114, 182, 0.18);
            color: #475569;
            font-size: 14px;
            font-weight: 850;
        }

        .topbar-user {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 8px 14px 8px 8px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid rgba(244, 114, 182, 0.18);
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f9a8d4, #fb7185);
            color: #ffffff;
            font-weight: 950;
        }

        .user-name {
            color: #334155;
            font-weight: 900;
            font-size: 14px;
        }

        .content {
            padding: 34px;
            max-width: 1500px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 24px;
        }

        .page-title {
            margin: 0;
            font-size: 38px;
            line-height: 1.1;
            letter-spacing: -0.05em;
            color: #111827;
            font-weight: 950;
        }

        .page-subtitle {
            margin: 10px 0 0;
            color: #64748b;
            font-size: 16px;
            font-weight: 650;
        }

        .section-title {
            margin: 0;
            font-size: 22px;
            font-weight: 950;
            color: #111827;
        }

        .section-subtitle {
            margin: 8px 0 0;
            color: #64748b;
            font-size: 14px;
            font-weight: 650;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(244, 114, 182, 0.16);
            border-radius: 26px;
            box-shadow: 0 18px 42px rgba(244, 114, 182, 0.10);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 16px;
            border-radius: 16px;
            border: none;
            font-size: 14px;
            font-weight: 950;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #f472b6, #fb7185);
            color: #ffffff;
            box-shadow: 0 12px 22px rgba(244, 114, 182, 0.22);
        }

        .btn-success {
            background: #22c55e;
            color: #ffffff;
            box-shadow: 0 12px 22px rgba(34, 197, 94, 0.18);
        }

        .btn-danger {
            background: #fb7185;
            color: #ffffff;
            box-shadow: 0 12px 22px rgba(251, 113, 133, 0.18);
        }

        .btn-outline {
            background: #ffffff;
            color: #334155;
            border: 1px solid #f3d7e5;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 28px;
        }

        .stat-card {
            padding: 22px;
            min-height: 168px;
        }

        .stat-label {
            font-size: 15px;
            color: #64748b;
            font-weight: 900;
            margin-bottom: 16px;
        }

        .stat-value {
            font-size: 40px;
            line-height: 1.05;
            color: #111827;
            font-weight: 950;
            letter-spacing: -0.04em;
        }

        .stat-value.small {
            font-size: 30px;
            line-height: 1.16;
        }

        .meal-plan-note {
            margin-top: 8px;
            color: #64748b;
            font-weight: 700;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 54px;
            padding: 0 26px;
            border-radius: 999px;
            font-weight: 950;
            white-space: nowrap;
        }

        .status-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .status-info {
            background: #dbeafe;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .status-danger {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .section-card {
            overflow: hidden;
        }

        .section-header {
            padding: 24px;
            border-bottom: 1px solid rgba(244, 114, 182, 0.14);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .section-body {
            padding: 24px;
        }

        .pill-group {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            padding: 7px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
        }

        .pill-gray {
            background: #f1f5f9;
            color: #475569;
        }

        .pill-green {
            background: #dcfce7;
            color: #166534;
        }

        .pill-yellow {
            background: #fef3c7;
            color: #92400e;
        }

        .empty-state {
            padding: 38px 24px;
            text-align: center;
            color: #64748b;
        }

        .empty-title {
            margin: 0;
            color: #111827;
            font-size: 20px;
            font-weight: 950;
        }

        .empty-text {
            margin: 8px 0 0;
            color: #64748b;
            font-weight: 650;
        }

        .empty-actions {
            margin-top: 18px;
        }

        @media (max-width: 1180px) {
            .app-shell {
                grid-template-columns: 1fr;
            }

            .sidebar {
                min-height: auto;
                position: static;
                border-right: none;
                border-bottom: 1px solid rgba(244, 114, 182, 0.18);
            }

            .nav-menu {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .sidebar-card {
                display: none;
            }

            .topbar {
                display: none;
            }

            .content {
                padding: 24px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .nav-menu {
                grid-template-columns: 1fr;
            }

            .page-header {
                flex-direction: column;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .content {
                padding: 18px;
            }

            .page-title {
                font-size: 32px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar">
            <a href="{{ route('user.beranda') }}" class="brand">
                <div class="brand-icon">
                    🐰
                </div>

                <div class="brand-text">
                    Meal Planner
                </div>
            </a>

            <nav class="nav-menu">
                <a
                    href="{{ route('user.beranda') }}"
                    class="nav-link {{ request()->routeIs('user.beranda') ? 'active' : '' }}"
                >
                    <span class="nav-icon">🏠</span>
                    Beranda
                </a>

                @if (Route::has('user.makanan-saya'))
                    <a
                        href="{{ route('user.makanan-saya') }}"
                        class="nav-link {{ request()->routeIs('user.makanan-saya') ? 'active' : '' }}"
                    >
                        <span class="nav-icon">🍓</span>
                        Makanan Saya
                    </a>
                @endif

                <a
                    href="{{ route('user.meal-plans') }}"
                    class="nav-link {{ request()->routeIs('user.meal-plans') ? 'active' : '' }}"
                >
                    <span class="nav-icon">📅</span>
                    Meal Plan
                </a>

                <a
                    href="{{ route('user.daftar-belanja') }}"
                    class="nav-link {{ request()->routeIs('user.daftar-belanja') ? 'active' : '' }}"
                >
                    <span class="nav-icon">🛒</span>
                    Daftar Belanja
                </a>

                <a
                    href="{{ route('user.profile') }}"
                    class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}"
                >
                    <span class="nav-icon">👤</span>
                    Profile
                </a>
            </nav>

            <div class="sidebar-spacer"></div>

            <div class="sidebar-card">
                <p class="sidebar-card-title">
                    Yuk, jaga pola makan sehat! 💗
                </p>

                <p class="sidebar-card-text">
                    Kamu bisa mencapai targetmu dengan rencana makan yang rapi.
                </p>

                <div class="bunny-card-illustration">
                    <img
                        src="{{ asset('images/kelinci-stroberi.png') }}"
                        alt="Kelinci imut memegang stroberi"
                        class="bunny-image"
                    >
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf

                <button type="submit" class="logout-button">
                    Keluar
                </button>
            </form>
        </aside>

        <main class="main-area">
            <header class="topbar">
                <div class="topbar-date">
                    🗓️ {{ now()->translatedFormat('l, d F Y') }}
                </div>

                <div class="topbar-user">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                    </div>

                    <div class="user-name">
                        {{ auth()->user()?->name ?? 'User' }}
                    </div>
                </div>
            </header>

            <div class="content">
                {{ $slot ?? '' }}

                @yield('content')
            </div>
        </main>
    </div>

    @livewireScripts

    @stack('scripts')
</body>
</html>