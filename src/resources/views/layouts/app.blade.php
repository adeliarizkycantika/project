<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Meal Planner') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            color: #0f172a;
        }

        a {
            text-decoration: none;
        }

        .app-shell {
            min-height: 100vh;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
        }

        .topbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .brand {
            font-size: 28px;
            font-weight: 800;
            color: #1e293b;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .nav-link {
            padding: 10px 14px;
            border-radius: 12px;
            color: #475569;
            font-size: 14px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            background: #eef2ff;
            color: #4f46e5;
        }

        .nav-link.active {
            background: #4f46e5;
            color: #ffffff;
        }

        .nav-user {
            font-size: 14px;
            color: #64748b;
            font-weight: 600;
            margin-left: 4px;
            margin-right: 4px;
        }

        .logout-button {
            border: none;
            background: #ef4444;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            padding: 10px 14px;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .logout-button:hover {
            background: #dc2626;
        }

        .page-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 20px 48px;
        }

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .page-title {
            margin: 0;
            font-size: 36px;
            line-height: 1.2;
            font-weight: 800;
            color: #0f172a;
        }

        .page-subtitle {
            margin: 8px 0 0;
            font-size: 16px;
            color: #64748b;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 800;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
        }

        .status-success {
            color: #166534;
            background: #dcfce7;
            border-color: #bbf7d0;
        }

        .status-info {
            color: #1d4ed8;
            background: #dbeafe;
            border-color: #bfdbfe;
        }

        .status-danger {
            color: #b91c1c;
            background: #fee2e2;
            border-color: #fecaca;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
        }

        .stat-card {
            padding: 20px;
        }

        .stat-label {
            font-size: 14px;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 12px;
        }

        .stat-value {
            font-size: 34px;
            line-height: 1.1;
            font-weight: 800;
            color: #0f172a;
        }

        .stat-value.small {
            font-size: 28px;
        }

        .section-card {
            overflow: hidden;
        }

        .section-header {
            padding: 22px 24px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .section-title {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
        }

        .section-subtitle {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .section-body {
            padding: 24px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 12px;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: #4f46e5;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #4338ca;
        }

        .btn-success {
            background: #16a34a;
            color: #ffffff;
        }

        .btn-success:hover {
            background: #15803d;
        }

        .btn-danger {
            background: #ffffff;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .btn-danger:hover {
            background: #fef2f2;
        }

        .btn-outline {
            background: #ffffff;
            color: #334155;
            border: 1px solid #cbd5e1;
        }

        .btn-outline:hover {
            background: #f8fafc;
        }

        .meal-plan-box {
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 18px;
            margin-bottom: 18px;
            background: #f8fafc;
        }

        .meal-plan-title {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }

        .meal-plan-note {
            margin: 6px 0 0;
            font-size: 14px;
            color: #64748b;
        }

        .meal-item {
            margin-top: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            border-radius: 16px;
            padding: 16px;
        }

        .meal-item-left {
            flex: 1;
            min-width: 240px;
        }

        .pill-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
        }

        .pill-gray {
            background: #e2e8f0;
            color: #334155;
        }

        .pill-green {
            background: #dcfce7;
            color: #166534;
        }

        .pill-yellow {
            background: #fef3c7;
            color: #92400e;
        }

        .meal-item-title {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }

        .meal-item-meta {
            margin: 6px 0 0;
            font-size: 14px;
            color: #64748b;
        }

        .empty-state {
            text-align: center;
            padding: 40px 24px;
            border: 2px dashed #cbd5e1;
            border-radius: 20px;
            background: #f8fafc;
        }

        .empty-title {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
        }

        .empty-text {
            margin: 10px 0 0;
            font-size: 15px;
            color: #64748b;
        }

        .empty-actions {
            margin-top: 18px;
        }

        @media (max-width: 992px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .page-title {
                font-size: 28px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .section-header,
            .section-body,
            .stat-card {
                padding: 18px;
            }

            .brand {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="app-shell">
        <header class="topbar">
            <div class="topbar-inner">
                <a href="{{ route('user.beranda') }}" class="brand">
                    Meal Planner
                </a>

                <div class="nav-menu">
                    <a
                        href="{{ route('user.beranda') }}"
                        class="nav-link {{ request()->routeIs('user.beranda') ? 'active' : '' }}"
                    >
                        Beranda
                    </a>

                    <a
                        href="{{ route('user.meal-plans') }}"
                        class="nav-link {{ request()->routeIs('user.meal-plans') ? 'active' : '' }}"
                    >
                        Meal Plan
                    </a>

                    <a
                        href="{{ route('user.daftar-belanja') }}"
                        class="nav-link {{ request()->routeIs('user.daftar-belanja') ? 'active' : '' }}"
                    >
                        Daftar Belanja
                    </a>

                    <a
                        href="{{ route('user.profile') }}"
                        class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}"
                    >
                        Profile
                    </a>

                    <span class="nav-user">
                        {{ auth()->user()?->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-button">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="page-container">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>