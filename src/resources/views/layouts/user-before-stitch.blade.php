<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    @php
        $resolvedSiteName = data_get(
            $siteSetting ?? null,
            'site_name',
            'Pola Makan Sehat'
        );

        $resolvedSiteSubtitle = data_get(
            $siteSetting ?? null,
            'site_subtitle',
            'Meal Planner & Kalori Harian'
        );

        $resolvedLogoUrl = data_get(
            $siteSetting ?? null,
            'logo_url'
        );

        $siteInitial = mb_strtoupper(
            mb_substr($resolvedSiteName, 0, 1)
        );

        $currentUser = auth()->user();

        $currentUserName = $currentUser?->name ?? 'User';

        $currentUserEmail = $currentUser?->email ?? '';

        $currentUserInitial = mb_strtoupper(
            mb_substr($currentUserName, 0, 1)
        );
    @endphp

    <title>
        {{ $resolvedSiteName }}
    </title>

    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap"
        rel="stylesheet"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])

    @livewireStyles

    <style>
        :root {
            --sidebar-width: 282px;

            --pink-50: #fff8fb;
            --pink-100: #fff0f6;
            --pink-200: #f8dce7;
            --pink-300: #f1b9ce;
            --pink-500: #e65491;
            --pink-600: #d9407f;

            --green-50: #f2fbf5;
            --green-100: #e5f7ea;
            --green-500: #4e9a69;

            --text-main: #20252a;
            --text-soft: #737b76;

            --border: #eedce4;
            --white: #ffffff;

            --shadow-soft:
                0 18px 45px rgba(103, 67, 83, .08);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
            color: var(--text-main);
            background:
                radial-gradient(
                    circle at 88% 8%,
                    rgba(236, 111, 159, .13),
                    transparent 27%
                ),
                radial-gradient(
                    circle at 16% 92%,
                    rgba(114, 184, 139, .10),
                    transparent 30%
                ),
                #fffafb;
            font-family:
                Figtree,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        a {
            color: inherit;
        }

        [x-cloak] {
            display: none !important;
        }

        .user-app {
            min-height: 100vh;
        }

        /*
        |--------------------------------------------------------------------------
        | Sidebar
        |--------------------------------------------------------------------------
        */

        .user-sidebar {
            position: fixed;
            z-index: 50;
            top: 0;
            bottom: 0;
            left: 0;
            width: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            padding: 24px 20px;
            border-right: 1px solid rgba(236, 111, 159, .16);
            background:
                linear-gradient(
                    180deg,
                    rgba(255, 255, 255, .98),
                    rgba(255, 252, 253, .98)
                );
            box-shadow: 12px 0 38px rgba(85, 56, 69, .04);
            transition:
                transform .25s ease,
                box-shadow .25s ease;
        }

        .sidebar-brand {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 14px;
            border: 1px solid rgba(236, 111, 159, .23);
            border-radius: 22px;
            background:
                linear-gradient(
                    135deg,
                    rgba(255, 248, 251, .98),
                    rgba(241, 252, 244, .97)
                );
            box-shadow: var(--shadow-soft);
        }

        .sidebar-brand-logo {
            width: 54px;
            height: 54px;
            flex: 0 0 54px;
            overflow: hidden;
            display: grid;
            place-items: center;
            border: 3px solid #ffffff;
            border-radius: 18px;
            background: #ffffff;
            box-shadow:
                0 10px 22px rgba(217, 79, 132, .13);
        }

        .sidebar-brand-logo img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
        }

        .sidebar-brand-placeholder {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            color: var(--pink-600);
            background:
                linear-gradient(
                    135deg,
                    var(--pink-100),
                    var(--green-100)
                );
            font-size: 22px;
            font-weight: 950;
        }

        .sidebar-brand-copy {
            min-width: 0;
        }

        .sidebar-brand-name {
            margin: 0;
            overflow: hidden;
            color: #202329;
            font-size: 16px;
            line-height: 1.25;
            font-weight: 950;
            letter-spacing: -.35px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sidebar-brand-subtitle {
            margin: 5px 0 0;
            overflow: hidden;
            color: #7a817c;
            font-size: 11px;
            line-height: 1.35;
            font-weight: 800;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sidebar-section-label {
            margin: 26px 10px 10px;
            color: #9a9299;
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .7px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            display: grid;
            gap: 8px;
        }

        .sidebar-link {
            min-height: 56px;
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 10px 14px;
            border: 1px solid transparent;
            border-radius: 17px;
            color: #59625d;
            text-decoration: none;
            font-size: 14px;
            font-weight: 900;
            transition:
                color .2s ease,
                background .2s ease,
                transform .2s ease,
                border-color .2s ease,
                box-shadow .2s ease;
        }

        .sidebar-link:hover {
            transform: translateX(2px);
            border-color: rgba(236, 111, 159, .14);
            color: var(--pink-600);
            background: var(--pink-50);
        }

        .sidebar-link.active {
            color: #ffffff;
            background:
                linear-gradient(
                    135deg,
                    #eb6299,
                    #db3f80
                );
            box-shadow:
                0 14px 28px rgba(220, 63, 130, .22);
        }

        .sidebar-link-icon {
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            color: inherit;
            background: rgba(236, 111, 159, .08);
            font-size: 18px;
        }

        .sidebar-link.active .sidebar-link-icon {
            background: rgba(255, 255, 255, .18);
        }

        .sidebar-user {
            margin-top: auto;
            padding-top: 28px;
        }

        .sidebar-user-card {
            padding: 15px;
            border: 1px solid var(--border);
            border-radius: 22px;
            background: rgba(255, 255, 255, .95);
            box-shadow: var(--shadow-soft);
        }

        .sidebar-user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-user-avatar {
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            display: grid;
            place-items: center;
            border-radius: 16px;
            color: var(--pink-600);
            background:
                linear-gradient(
                    135deg,
                    var(--pink-100),
                    var(--green-50)
                );
            font-size: 18px;
            font-weight: 950;
        }

        .sidebar-user-copy {
            min-width: 0;
        }

        .sidebar-user-name {
            margin: 0;
            overflow: hidden;
            color: #272b2e;
            font-size: 13px;
            font-weight: 950;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sidebar-user-email {
            margin: 4px 0 0;
            overflow: hidden;
            color: #7b837e;
            font-size: 10px;
            line-height: 1.4;
            font-weight: 700;
            text-overflow: ellipsis;
            overflow-wrap: anywhere;
        }

        .logout-form {
            margin-top: 14px;
        }

        .logout-button {
            width: 100%;
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1px solid rgba(236, 111, 159, .30);
            border-radius: 999px;
            color: var(--pink-600);
            background: var(--pink-50);
            cursor: pointer;
            font-size: 12px;
            font-weight: 950;
            transition:
                transform .2s ease,
                background .2s ease,
                color .2s ease;
        }

        .logout-button:hover {
            transform: translateY(-1px);
            color: #ffffff;
            background: var(--pink-600);
        }

        /*
        |--------------------------------------------------------------------------
        | Main content
        |--------------------------------------------------------------------------
        */

        .user-main {
            min-height: 100vh;
            margin-left: var(--sidebar-width);
        }

        .mobile-header {
            display: none;
        }

        .user-content {
            width: 100%;
            min-height: 100vh;
            padding: 24px;
        }

        /*
        |--------------------------------------------------------------------------
        | Mobile sidebar
        |--------------------------------------------------------------------------
        */

        .sidebar-overlay {
            position: fixed;
            z-index: 40;
            inset: 0;
            display: none;
            background: rgba(27, 22, 25, .42);
            backdrop-filter: blur(3px);
        }

        .sidebar-overlay.visible {
            display: block;
        }

        .mobile-brand {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mobile-brand-logo {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            overflow: hidden;
            display: grid;
            place-items: center;
            border: 2px solid #ffffff;
            border-radius: 14px;
            background: #ffffff;
            box-shadow:
                0 8px 20px rgba(217, 79, 132, .12);
        }

        .mobile-brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mobile-brand-placeholder {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            color: var(--pink-600);
            background:
                linear-gradient(
                    135deg,
                    var(--pink-100),
                    var(--green-100)
                );
            font-size: 17px;
            font-weight: 950;
        }

        .mobile-brand-name {
            margin: 0;
            overflow: hidden;
            color: #24282b;
            font-size: 14px;
            font-weight: 950;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .mobile-menu-button {
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            display: grid;
            place-items: center;
            border: 1px solid var(--border);
            border-radius: 15px;
            color: var(--pink-600);
            background: #ffffff;
            cursor: pointer;
            font-size: 21px;
            box-shadow: var(--shadow-soft);
        }

        @media (max-width: 1024px) {
            .user-sidebar {
                transform: translateX(-105%);
            }

            .user-sidebar.open {
                transform: translateX(0);
                box-shadow:
                    22px 0 50px rgba(43, 29, 35, .18);
            }

            .user-main {
                margin-left: 0;
            }

            .mobile-header {
                position: sticky;
                z-index: 30;
                top: 0;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 14px;
                min-height: 72px;
                padding: 12px 18px;
                border-bottom: 1px solid rgba(236, 111, 159, .16);
                background: rgba(255, 255, 255, .92);
                backdrop-filter: blur(18px);
            }

            .user-content {
                padding: 18px;
            }
        }

        @media (max-width: 640px) {
            :root {
                --sidebar-width: min(86vw, 290px);
            }

            .user-sidebar {
                padding: 18px 16px;
            }

            .user-content {
                padding: 14px;
            }

            .mobile-header {
                padding: 10px 14px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="user-app">
        <aside
            id="userSidebar"
            class="user-sidebar"
            aria-label="Navigasi utama"
        >
            <a
                href="{{ route('user.dashboard') }}"
                class="sidebar-brand"
                aria-label="Kembali ke beranda"
            >
                <div class="sidebar-brand-logo">
                    @if ($resolvedLogoUrl)
                        <img
                            src="{{ $resolvedLogoUrl }}"
                            alt="Logo {{ $resolvedSiteName }}"
                        >
                    @else
                        <span class="sidebar-brand-placeholder">
                            {{ $siteInitial }}
                        </span>
                    @endif
                </div>

                <div class="sidebar-brand-copy">
                    <h1 class="sidebar-brand-name">
                        {{ $resolvedSiteName }}
                    </h1>

                    <p class="sidebar-brand-subtitle">
                        {{ $resolvedSiteSubtitle }}
                    </p>
                </div>
            </a>

            <p class="sidebar-section-label">
                Menu Utama
            </p>

            <nav class="sidebar-nav">
                <a
                    href="{{ route('user.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('user.dashboard', 'user.beranda.*') ? 'active' : '' }}"
                >
                    <span class="sidebar-link-icon">🏠</span>
                    <span>Beranda</span>
                </a>

                <a
                    href="{{ route('user.makanan') }}"
                    class="sidebar-link {{ request()->routeIs('user.makanan', 'user.makanan.*') ? 'active' : '' }}"
                >
                    <span class="sidebar-link-icon">🥬</span>
                    <span>Makanan</span>
                </a>

                <a
                    href="{{ route('user.meal-plan') }}"
                    class="sidebar-link {{ request()->routeIs('user.meal-plan', 'user.meal-plan.*') ? 'active' : '' }}"
                >
                    <span class="sidebar-link-icon">🍽️</span>
                    <span>Meal Plan</span>
                </a>

                <a
                    href="{{ route('user.daftar-belanja') }}"
                    class="sidebar-link {{ request()->routeIs('user.daftar-belanja', 'user.daftar-belanja.*') ? 'active' : '' }}"
                >
                    <span class="sidebar-link-icon">🛒</span>
                    <span>Belanja</span>
                </a>

                <a
                    href="{{ route('user.profil') }}"
                    class="sidebar-link {{ request()->routeIs('user.profil', 'user.profil.*', 'user.profile*', 'user.data-user*') ? 'active' : '' }}"
                >
                    <span class="sidebar-link-icon">👤</span>
                    <span>Profil</span>
                </a>
            </nav>

            <div class="sidebar-user">
                <div class="sidebar-user-card">
                    <div class="sidebar-user-profile">
                        <div class="sidebar-user-avatar">
                            {{ $currentUserInitial }}
                        </div>

                        <div class="sidebar-user-copy">
                            <p class="sidebar-user-name">
                                {{ $currentUserName }}
                            </p>

                            <p class="sidebar-user-email">
                                {{ $currentUserEmail }}
                            </p>
                        </div>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                        class="logout-form"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="logout-button"
                        >
                            <span>↗</span>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div
            id="sidebarOverlay"
            class="sidebar-overlay"
            aria-hidden="true"
        ></div>

        <main class="user-main">
            <header class="mobile-header">
                <div class="mobile-brand">
                    <div class="mobile-brand-logo">
                        @if ($resolvedLogoUrl)
                            <img
                                src="{{ $resolvedLogoUrl }}"
                                alt="Logo {{ $resolvedSiteName }}"
                            >
                        @else
                            <span class="mobile-brand-placeholder">
                                {{ $siteInitial }}
                            </span>
                        @endif
                    </div>

                    <p class="mobile-brand-name">
                        {{ $resolvedSiteName }}
                    </p>
                </div>

                <button
                    type="button"
                    id="mobileMenuButton"
                    class="mobile-menu-button"
                    aria-label="Buka menu"
                    aria-expanded="false"
                >
                    ☰
                </button>
            </header>

            <div class="user-content">
                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('userSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const button = document.getElementById('mobileMenuButton');

            if (!sidebar || !overlay || !button) {
                return;
            }

            function openSidebar() {
                sidebar.classList.add('open');
                overlay.classList.add('visible');

                button.setAttribute('aria-expanded', 'true');
                button.setAttribute('aria-label', 'Tutup menu');

                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                overlay.classList.remove('visible');

                button.setAttribute('aria-expanded', 'false');
                button.setAttribute('aria-label', 'Buka menu');

                document.body.style.overflow = '';
            }

            button.addEventListener('click', function () {
                if (sidebar.classList.contains('open')) {
                    closeSidebar();
                    return;
                }

                openSidebar();
            });

            overlay.addEventListener('click', closeSidebar);

            sidebar
                .querySelectorAll('a.sidebar-link')
                .forEach(function (link) {
                    link.addEventListener('click', function () {
                        if (window.innerWidth <= 1024) {
                            closeSidebar();
                        }
                    });
                });

            window.addEventListener('resize', function () {
                if (window.innerWidth > 1024) {
                    closeSidebar();
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>