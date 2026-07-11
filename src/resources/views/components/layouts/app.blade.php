<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Sistem Pola Makan Sehat') }}</title>

    @livewireStyles

    <style>
        :root {
            --primary: #f48fb1;
            --primary-dark: #ec6f9f;
            --secondary: #b7e4c7;
            --bg: #fff7fb;
            --surface: #ffffff;
            --surface-soft: #fffafd;
            --text: #2f2f3a;
            --muted: #7b7b8c;
            --border: #f2dce7;
            --shadow: 0 18px 45px rgba(216, 91, 141, 0.10);
            --radius: 28px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at top left, rgba(255, 202, 212, 0.42), transparent 34%),
                radial-gradient(circle at bottom right, rgba(183, 228, 199, 0.42), transparent 34%),
                linear-gradient(135deg, #fff7fb 0%, #f4fff7 100%);
            color: var(--text);
        }

        a {
            color: inherit;
        }

        .app-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 280px minmax(0, 1fr);
        }

        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 24px 18px;
            background: rgba(255, 255, 255, 0.82);
            border-right: 1px solid rgba(242, 220, 231, 0.9);
            backdrop-filter: blur(18px);
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 10px;
            text-decoration: none;
        }

        .brand-icon {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            border-radius: 17px;
            background: #fff0f6;
            color: #d85b8d;
            font-size: 24px;
            box-shadow: inset 0 0 0 1px rgba(244, 143, 177, 0.18);
        }

        .brand-text {
            display: grid;
            gap: 2px;
        }

        .brand-title {
            color: var(--text);
            font-size: 16px;
            font-weight: 950;
            letter-spacing: -0.04em;
        }

        .brand-subtitle {
            color: var(--muted);
            font-size: 12px;
            font-weight: 750;
        }

        .nav-list {
            display: grid;
            gap: 8px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 48px;
            padding: 0 14px;
            border-radius: 18px;
            color: #555568;
            text-decoration: none;
            font-size: 14px;
            font-weight: 850;
            transition: 0.2s ease;
        }

        .nav-link:hover {
            background: #fff0f6;
            color: #d85b8d;
            transform: translateX(2px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #f48fb1, #ec6f9f);
            color: #ffffff;
            box-shadow: 0 14px 28px rgba(236, 111, 159, 0.28);
        }

        .nav-icon {
            width: 26px;
            height: 26px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.44);
            font-size: 15px;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px;
            border-radius: 24px;
            background:
                radial-gradient(circle at top right, rgba(244, 143, 177, 0.18), transparent 35%),
                linear-gradient(145deg, #ffffff, #fff7fb);
            border: 1px solid var(--border);
        }

        .user-mini {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 16px;
            background: #f0fff4;
            color: #2f855a;
            font-size: 15px;
            font-weight: 950;
        }

        .user-name {
            color: var(--text);
            font-size: 14px;
            font-weight: 900;
            line-height: 1.25;
        }

        .user-email {
            margin-top: 2px;
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
            word-break: break-word;
        }

        .logout-button {
            width: 100%;
            min-height: 42px;
            margin-top: 14px;
            border: 0;
            border-radius: 16px;
            background: #fff1f2;
            color: #be123c;
            font-size: 13px;
            font-weight: 900;
            cursor: pointer;
        }

        .main-area {
            min-width: 0;
            padding: 24px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            padding: 16px 18px;
            border-radius: 26px;
            background: rgba(255, 255, 255, 0.76);
            border: 1px solid rgba(242, 220, 231, 0.9);
            box-shadow: var(--shadow);
            backdrop-filter: blur(18px);
        }

        .topbar-title {
            color: var(--text);
            font-size: 18px;
            font-weight: 950;
            letter-spacing: -0.035em;
        }

        .topbar-subtitle {
            margin-top: 3px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 750;
        }

        .topbar-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 40px;
            padding: 0 14px;
            border-radius: 999px;
            background: #fff0f6;
            color: #d85b8d;
            border: 1px solid rgba(244, 143, 177, 0.18);
            font-size: 13px;
            font-weight: 900;
            white-space: nowrap;
        }

        .content {
            min-width: 0;
        }

        @media (max-width: 980px) {
            .app-shell {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: relative;
                height: auto;
                border-right: 0;
                border-bottom: 1px solid rgba(242, 220, 231, 0.9);
            }

            .nav-list {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .sidebar-footer {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .main-area {
                padding: 16px;
            }

            .sidebar {
                padding: 18px 14px;
            }

            .nav-list {
                grid-template-columns: 1fr;
            }

            .topbar {
                display: grid;
            }

            .topbar-pill {
                width: fit-content;
            }
        }
    </style>
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar">
            <a
                href="{{ \Illuminate\Support\Facades\Route::has('user.beranda') ? route('user.beranda') : url('/') }}"
                class="brand"
            >
                <div class="brand-icon">🥗</div>

                <div class="brand-text">
                    <div class="brand-title">Pola Makan Sehat</div>
                    <div class="brand-subtitle">Meal Planner</div>
                </div>
            </a>

            <nav class="nav-list">
                @if (\Illuminate\Support\Facades\Route::has('user.beranda'))
                    <a
                        href="{{ route('user.beranda') }}"
                        class="nav-link {{ request()->routeIs('user.beranda') ? 'active' : '' }}"
                    >
                        <span class="nav-icon">🏠</span>
                        <span>Beranda</span>
                    </a>
                @endif

                @if (\Illuminate\Support\Facades\Route::has('user.makanan-saya'))
                    <a
                        href="{{ route('user.makanan-saya') }}"
                        class="nav-link {{ request()->routeIs('user.makanan-saya') ? 'active' : '' }}"
                    >
                        <span class="nav-icon">🍱</span>
                        <span>Makanan</span>
                    </a>
                @endif

                @if (\Illuminate\Support\Facades\Route::has('user.meal-plans'))
                    <a
                        href="{{ route('user.meal-plans') }}"
                        class="nav-link {{ request()->routeIs('user.meal-plans') ? 'active' : '' }}"
                    >
                        <span class="nav-icon">📅</span>
                        <span>Meal Plan</span>
                    </a>
                @endif

                @if (\Illuminate\Support\Facades\Route::has('user.daftar-belanja'))
                    <a
                        href="{{ route('user.daftar-belanja') }}"
                        class="nav-link {{ request()->routeIs('user.daftar-belanja') ? 'active' : '' }}"
                    >
                        <span class="nav-icon">🛒</span>
                        <span>Daftar Belanja</span>
                    </a>
                @endif

                @if (\Illuminate\Support\Facades\Route::has('user.profile'))
                    <a
                        href="{{ route('user.profile') }}"
                        class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}"
                    >
                        <span class="nav-icon">👤</span>
                        <span>Profil</span>
                    </a>
                @endif
            </nav>

            @auth
                <div class="sidebar-footer">
                    <div class="user-mini">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>

                        <div>
                            <div class="user-name">{{ auth()->user()->name }}</div>
                            <div class="user-email">{{ auth()->user()->email }}</div>
                        </div>
                    </div>

                    @if (\Illuminate\Support\Facades\Route::has('logout'))
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="logout-button">
                                Keluar
                            </button>
                        </form>
                    @endif
                </div>
            @endauth
        </aside>

        <main class="main-area">
            <header class="topbar">
                <div>
                    <div class="topbar-title">
                        Sistem Pola Makan Hidup Sehat
                    </div>

                    <div class="topbar-subtitle">
                        Rekomendasi menu dan perhitungan kalori harian
                    </div>
                </div>

                <div class="topbar-pill">
                    ✨ Dashboard User
                </div>
            </header>

            <section class="content">
                {{ $slot }}
            </section>
        </main>
    </div>

    @livewireScripts
</body>
</html>