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

        $currentUser = auth()->user();

        $userName = $currentUser?->name ?? 'Pengguna';
        $userEmail = $currentUser?->email ?? '';

        $siteInitial = mb_strtoupper(
            mb_substr($resolvedSiteName, 0, 1)
        );

        $userInitials = collect(
            preg_split('/\s+/', trim($userName))
        )
            ->filter()
            ->take(2)
            ->map(
                fn (string $word): string =>
                    mb_strtoupper(mb_substr($word, 0, 1))
            )
            ->implode('');

        $genderLabel = $currentUser?->gender_label ?? '-';

        $ageLabel = filled($currentUser?->age)
            ? $currentUser->age . ' tahun'
            : '-';

        $heightLabel = filled($currentUser?->height_cm)
            ? number_format(
                (float) $currentUser->height_cm,
                0,
                ',',
                '.'
            ) . ' cm'
            : '-';

        $weightLabel = filled($currentUser?->weight_kg)
            ? number_format(
                (float) $currentUser->weight_kg,
                1,
                ',',
                '.'
            ) . ' kg'
            : '-';

        $activityLabel = $currentUser?->activity_level_label ?? '-';
    @endphp

    <title>
        @yield('title', $resolvedSiteName)
    </title>

    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/user-stitch.css') }}"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])

    @livewireStyles
    @stack('styles')
</head>

<body>
    <div class="ux-app">
        <aside
            id="userSidebar"
            class="ux-sidebar"
            aria-label="Navigasi utama"
        >
            <div>
                <a
                    href="{{ route('user.dashboard') }}"
                    class="ux-brand"
                    aria-label="Buka beranda {{ $resolvedSiteName }}"
                >
                    <div class="ux-brand-logo">
                        @if ($resolvedLogoUrl)
                            <img
                                src="{{ $resolvedLogoUrl }}"
                                alt="Logo {{ $resolvedSiteName }}"
                            >
                        @else
                            <span>{{ $siteInitial }}</span>
                        @endif
                    </div>

                    <div class="ux-brand-copy">
                        <p class="ux-brand-title">
                            {{ $resolvedSiteName }}
                        </p>

                        <p class="ux-brand-subtitle">
                            {{ $resolvedSiteSubtitle }}
                        </p>
                    </div>
                </a>

                <p class="ux-nav-label">
                    Menu Utama
                </p>

                <nav class="ux-nav">
                    <a
                        href="{{ route('user.dashboard') }}"
                        class="ux-nav-link {{
                            request()->routeIs(
                                'user.dashboard',
                                'user.beranda.*'
                            )
                                ? 'is-active'
                                : ''
                        }}"
                    >
                        <span class="ux-nav-icon">
                            <x-heroicon-o-home />
                        </span>

                        <span>Beranda</span>
                    </a>

                    <a
                        href="{{ route('user.makanan') }}"
                        class="ux-nav-link {{
                            request()->routeIs(
                                'user.makanan',
                                'user.makanan.*'
                            )
                                ? 'is-active'
                                : ''
                        }}"
                    >
                        <span class="ux-nav-icon">
                            <x-heroicon-o-cake />
                        </span>

                        <span>Makanan</span>
                    </a>

                    <a
                        href="{{ route('user.meal-plan') }}"
                        class="ux-nav-link {{
                            request()->routeIs(
                                'user.meal-plan',
                                'user.meal-plan.*'
                            )
                                ? 'is-active'
                                : ''
                        }}"
                    >
                        <span class="ux-nav-icon">
                            <x-heroicon-o-calendar-days />
                        </span>

                        <span>Meal Plan</span>
                    </a>

                    <a
                        href="{{ route('user.daftar-belanja') }}"
                        class="ux-nav-link {{
                            request()->routeIs(
                                'user.daftar-belanja',
                                'user.daftar-belanja.*'
                            )
                                ? 'is-active'
                                : ''
                        }}"
                    >
                        <span class="ux-nav-icon">
                            <x-heroicon-o-shopping-cart />
                        </span>

                        <span>Belanja</span>
                    </a>

                    <a
                        href="{{ route('user.profil') }}"
                        class="ux-nav-link {{
                            request()->routeIs(
                                'user.profil',
                                'user.profil.*',
                                'user.profile*',
                                'user.data-user*'
                            )
                                ? 'is-active'
                                : ''
                        }}"
                    >
                        <span class="ux-nav-icon">
                            <x-heroicon-o-user-circle />
                        </span>

                        <span>Profil</span>
                    </a>
                </nav>

                @if (request()->routeIs('user.dashboard', 'user.beranda.*'))
                    <section class="ux-body-summary">
                        <h2 class="ux-body-summary-title">
                            Data Tubuh
                        </h2>

                        <div class="ux-body-summary-list">
                            <div class="ux-body-summary-row">
                                <span>Gender</span>
                                <strong>{{ $genderLabel }}</strong>
                            </div>

                            <div class="ux-body-summary-row">
                                <span>Usia</span>
                                <strong>{{ $ageLabel }}</strong>
                            </div>

                            <div class="ux-body-summary-row">
                                <span>Tinggi Badan</span>
                                <strong>{{ $heightLabel }}</strong>
                            </div>

                            <div class="ux-body-summary-row">
                                <span>Berat Badan</span>
                                <strong>{{ $weightLabel }}</strong>
                            </div>

                            <div class="ux-body-summary-row">
                                <span>Aktivitas</span>
                                <strong>{{ $activityLabel }}</strong>
                            </div>
                        </div>
                    </section>
                @endif
            </div>

            <div class="ux-sidebar-footer">
                <section class="ux-user-card">
                    <div class="ux-user-profile">
                        <div class="ux-user-avatar">
                            @if ($currentUser?->google_avatar)
                                <img
                                    src="{{ $currentUser->google_avatar }}"
                                    alt="Foto profil {{ $userName }}"
                                    referrerpolicy="no-referrer"
                                >
                            @else
                                <span>{{ $userInitials ?: 'U' }}</span>
                            @endif
                        </div>

                        <div class="ux-user-copy">
                            <p class="ux-user-name">
                                {{ $userName }}
                            </p>

                            <p
                                class="ux-user-email"
                                title="{{ $userEmail }}"
                            >
                                {{ $userEmail }}
                            </p>
                        </div>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                        class="ux-logout-form"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="ux-logout-button"
                        >
                            <x-heroicon-o-arrow-right-on-rectangle />

                            <span>Logout</span>
                        </button>
                    </form>
                </section>
            </div>
        </aside>

        <div
            id="userSidebarOverlay"
            class="ux-sidebar-overlay"
            aria-hidden="true"
        ></div>

        <div class="ux-main">
            <header class="ux-mobile-header">
                <div class="ux-mobile-brand">
                    <div class="ux-mobile-brand-logo">
                        @if ($resolvedLogoUrl)
                            <img
                                src="{{ $resolvedLogoUrl }}"
                                alt="Logo {{ $resolvedSiteName }}"
                            >
                        @else
                            <span>{{ $siteInitial }}</span>
                        @endif
                    </div>

                    <div class="ux-mobile-brand-copy">
                        <p class="ux-mobile-brand-title">
                            {{ $resolvedSiteName }}
                        </p>

                        <p class="ux-mobile-brand-subtitle">
                            {{ $resolvedSiteSubtitle }}
                        </p>
                    </div>
                </div>

                <button
                    type="button"
                    id="userSidebarButton"
                    class="ux-mobile-menu"
                    aria-label="Buka menu navigasi"
                    aria-controls="userSidebar"
                    aria-expanded="false"
                >
                    <x-heroicon-o-bars-3 />
                </button>
            </header>

            <main class="ux-content">
                {{ $slot }}
            </main>
        </div>

        <nav
            class="ux-mobile-nav"
            aria-label="Navigasi seluler"
        >
            <a
                href="{{ route('user.dashboard') }}"
                class="ux-mobile-nav-link {{
                    request()->routeIs(
                        'user.dashboard',
                        'user.beranda.*'
                    )
                        ? 'is-active'
                        : ''
                }}"
            >
                <x-heroicon-o-home />
                <span>Beranda</span>
            </a>

            <a
                href="{{ route('user.makanan') }}"
                class="ux-mobile-nav-link {{
                    request()->routeIs(
                        'user.makanan',
                        'user.makanan.*'
                    )
                        ? 'is-active'
                        : ''
                }}"
            >
                <x-heroicon-o-cake />
                <span>Makanan</span>
            </a>

            <a
                href="{{ route('user.meal-plan') }}"
                class="ux-mobile-nav-link {{
                    request()->routeIs(
                        'user.meal-plan',
                        'user.meal-plan.*'
                    )
                        ? 'is-active'
                        : ''
                }}"
            >
                <x-heroicon-o-calendar-days />
                <span>Meal Plan</span>
            </a>

            <a
                href="{{ route('user.daftar-belanja') }}"
                class="ux-mobile-nav-link {{
                    request()->routeIs(
                        'user.daftar-belanja',
                        'user.daftar-belanja.*'
                    )
                        ? 'is-active'
                        : ''
                }}"
            >
                <x-heroicon-o-shopping-cart />
                <span>Belanja</span>
            </a>

            <a
                href="{{ route('user.profil') }}"
                class="ux-mobile-nav-link {{
                    request()->routeIs(
                        'user.profil',
                        'user.profil.*',
                        'user.profile*',
                        'user.data-user*'
                    )
                        ? 'is-active'
                        : ''
                }}"
            >
                <x-heroicon-o-user-circle />
                <span>Profil</span>
            </a>
        </nav>
    </div>

    @livewireScripts
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('userSidebar');
            const overlay = document.getElementById('userSidebarOverlay');
            const button = document.getElementById('userSidebarButton');

            if (!sidebar || !overlay || !button) {
                return;
            }

            function openSidebar() {
                sidebar.classList.add('is-open');
                overlay.classList.add('is-visible');

                button.setAttribute('aria-expanded', 'true');
                button.setAttribute(
                    'aria-label',
                    'Tutup menu navigasi'
                );

                document.body.classList.add(
                    'ux-sidebar-locked'
                );
            }

            function closeSidebar() {
                sidebar.classList.remove('is-open');
                overlay.classList.remove('is-visible');

                button.setAttribute('aria-expanded', 'false');
                button.setAttribute(
                    'aria-label',
                    'Buka menu navigasi'
                );

                document.body.classList.remove(
                    'ux-sidebar-locked'
                );
            }

            button.addEventListener('click', function () {
                if (sidebar.classList.contains('is-open')) {
                    closeSidebar();
                    return;
                }

                openSidebar();
            });

            overlay.addEventListener('click', closeSidebar);

            sidebar
                .querySelectorAll('a')
                .forEach(function (link) {
                    link.addEventListener('click', function () {
                        if (window.innerWidth <= 1024) {
                            closeSidebar();
                        }
                    });
                });

            window.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth > 1024) {
                    closeSidebar();
                }
            });
        });
    </script>
</body>
</html>