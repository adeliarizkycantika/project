<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - {{ $siteSetting->site_name }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap"
        rel="stylesheet"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Figtree, ui-sans-serif, system-ui, -apple-system,
                BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #171827;
            background:
                radial-gradient(
                    circle at 88% 12%,
                    rgba(236, 111, 159, .16),
                    transparent 32%
                ),
                radial-gradient(
                    circle at 12% 92%,
                    rgba(114, 184, 139, .14),
                    transparent 30%
                ),
                #fff9fc;
        }

        button,
        input,
        select {
            font: inherit;
        }

        .auth-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(620px, 1.08fr);
        }

        .auth-visual {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            padding: 44px 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background:
                linear-gradient(
                    90deg,
                    rgba(40, 22, 30, .68),
                    rgba(40, 22, 30, .32)
                ),
                linear-gradient(
                    180deg,
                    rgba(40, 22, 30, .10),
                    rgba(40, 22, 30, .56)
                ),
                url("{{ $siteSetting->auth_background_url }}");
            background-size: cover;
            background-position: center;
        }

        .auth-visual::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                radial-gradient(
                    circle at 15% 15%,
                    rgba(236, 111, 159, .22),
                    transparent 32%
                ),
                radial-gradient(
                    circle at 85% 85%,
                    rgba(114, 184, 139, .18),
                    transparent 34%
                );
        }

        .brand {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 20px;
            color: #ffffff;
        }

        .brand-logo {
            width: 92px;
            height: 92px;
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 0;
            border: 4px solid rgba(255, 255, 255, .92);
            border-radius: 50%;
            background: rgba(255, 255, 255, .96);
            box-shadow: 0 16px 36px rgba(0, 0, 0, .18);
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            display: block;
            border-radius: 50%;
            object-fit: cover;
            object-position: center;
        }

        .brand-name {
            margin: 0;
            color: #ffffff;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.9px;
            text-shadow: 0 8px 24px rgba(0, 0, 0, .18);
        }

        .brand-subtitle {
            margin-top: 8px;
            color: rgba(255, 255, 255, .92);
            font-size: 16px;
            font-weight: 800;
        }

        .hero-copy {
            position: relative;
            z-index: 1;
            max-width: 680px;
            padding-bottom: clamp(28px, 5vh, 72px);
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-height: 44px;
            margin-bottom: 28px;
            padding: 10px 18px;
            border: 1px solid rgba(255, 255, 255, .28);
            border-radius: 999px;
            color: #ffffff;
            background: rgba(255, 255, 255, .16);
            backdrop-filter: blur(14px);
            font-size: 13px;
            font-weight: 950;
            letter-spacing: .2px;
            text-transform: uppercase;
        }

        .hero-title {
            max-width: 640px;
            margin: 0;
            color: #ffffff;
            font-size: clamp(42px, 5vw, 72px);
            line-height: 1.03;
            font-weight: 950;
            letter-spacing: -3.2px;
            text-shadow: 0 14px 32px rgba(0, 0, 0, .26);
        }

        .hero-description {
            max-width: 640px;
            margin: 28px 0 0;
            color: rgba(255, 255, 255, .93);
            font-size: clamp(16px, 1.5vw, 20px);
            line-height: 1.75;
            font-weight: 700;
            text-shadow: 0 10px 26px rgba(0, 0, 0, .22);
        }

        .auth-content {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 40px 28px;
        }

        .auth-card {
            width: 100%;
            max-width: 780px;
            padding: 44px;
            border: 1px solid rgba(236, 111, 159, .18);
            border-radius: 34px;
            background: rgba(255, 255, 255, .92);
            box-shadow: 0 24px 80px rgba(217, 79, 132, .16);
            backdrop-filter: blur(16px);
        }

        .auth-icon {
            width: 72px;
            height: 72px;
            display: grid;
            place-items: center;
            margin-bottom: 26px;
            border-radius: 28px;
            color: #e24f8c;
            background: #fff0f6;
            font-size: 30px;
        }

        .auth-title {
            margin: 0;
            color: #171827;
            font-size: clamp(30px, 4vw, 42px);
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -1.8px;
        }

        .auth-subtitle {
            margin: 16px 0 30px;
            color: #6b7084;
            font-size: 16px;
            line-height: 1.65;
            font-weight: 700;
        }

        .alert-error,
        .alert-google {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 18px;
            font-size: 13px;
            line-height: 1.6;
            font-weight: 800;
        }

        .alert-error {
            border: 1px solid #ffd2df;
            color: #c72f5d;
            background: #fff0f4;
        }

        .alert-google {
            border: 1px solid #b7efc5;
            color: #2f7d4d;
            background: #f0fff5;
        }

        .google-connected {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 22px;
            padding: 16px;
            border: 1px solid #ccefd7;
            border-radius: 20px;
            color: #306d46;
            background: #f4fff7;
        }

        .google-connected-icon {
            width: 42px;
            height: 42px;
            flex: 0 0 auto;
            display: grid;
            place-items: center;
            border: 1px solid #dce8ff;
            border-radius: 50%;
            color: #4285f4;
            background: #ffffff;
            font-family: Arial, sans-serif;
            font-size: 18px;
            font-weight: 900;
        }

        .google-connected-title {
            margin: 0 0 3px;
            color: #285c3b;
            font-size: 14px;
            font-weight: 950;
        }

        .google-connected-text {
            margin: 0;
            color: #4c7860;
            font-size: 12px;
            line-height: 1.5;
            font-weight: 700;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px 16px;
        }

        .form-group {
            min-width: 0;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            margin-bottom: 9px;
            color: #161827;
            font-size: 14px;
            font-weight: 950;
        }

        .label-note {
            color: #8a8fa2;
            font-size: 11px;
            font-weight: 800;
        }

        .input-wrap {
            position: relative;
        }

        .form-input,
        .form-select {
            width: 100%;
            min-height: 64px;
            border: 1px solid #ead7df;
            border-radius: 18px;
            outline: none;
            color: #202231;
            background: rgba(255, 255, 255, .92);
            font-size: 15px;
            font-weight: 800;
            transition: .2s ease;
        }

        .form-input {
            padding: 0 20px;
        }

        .form-input.has-toggle {
            padding-right: 60px;
        }

        .form-select {
            padding: 0 52px 0 20px;
            appearance: none;
            cursor: pointer;
        }

        .form-input::placeholder {
            color: #aaa2ae;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: #ec6f9f;
            box-shadow: 0 0 0 5px rgba(236, 111, 159, .12);
        }

        .form-input[readonly] {
            color: #697084;
            background: #fff6fa;
            cursor: not-allowed;
        }

        .select-arrow {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            color: #aaa2ae;
            font-size: 14px;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 16px;
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            padding: 0;
            transform: translateY(-50%);
            border: 0;
            border-radius: 999px;
            color: #dc3f82;
            background: #fff4f8;
            cursor: pointer;
            font-size: 15px;
            transition: .2s ease;
        }

        .password-toggle:hover {
            background: #ffe4ef;
            transform: translateY(-50%) scale(1.04);
        }

        .form-error {
            display: block;
            margin-top: 8px;
            color: #c72f5d;
            font-size: 12px;
            line-height: 1.45;
            font-weight: 800;
        }

        .btn-primary {
            width: 100%;
            min-height: 66px;
            margin-top: 26px;
            border: 0;
            border-radius: 999px;
            color: #ffffff;
            background: linear-gradient(135deg, #ec6f9f, #dc3f82);
            box-shadow: 0 18px 34px rgba(220, 63, 130, .24);
            cursor: pointer;
            font-size: 17px;
            font-weight: 950;
            transition: .2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 22px 42px rgba(220, 63, 130, .3);
        }

        .btn-google {
            width: 100%;
            min-height: 62px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 14px;
            border: 1px solid #ead7df;
            border-radius: 999px;
            color: #262837;
            background: #ffffff;
            box-shadow: 0 12px 26px rgba(37, 44, 39, .06);
            text-decoration: none;
            font-size: 15px;
            font-weight: 950;
            transition: .2s ease;
        }

        .btn-google:hover {
            transform: translateY(-1px);
            border-color: rgba(236, 111, 159, .42);
            box-shadow: 0 16px 32px rgba(217, 79, 132, .12);
        }

        .google-mark {
            width: 30px;
            height: 30px;
            display: grid;
            place-items: center;
            border: 1px solid #eeeeee;
            border-radius: 999px;
            color: #4285f4;
            background: #ffffff;
            font-family: Arial, sans-serif;
            font-size: 17px;
            font-weight: 950;
        }

        .auth-switch {
            margin: 28px 0 0;
            color: #6b7084;
            text-align: center;
            font-size: 14px;
            font-weight: 800;
        }

        .auth-switch a {
            color: #e24f8c;
            text-decoration: none;
            font-weight: 950;
        }

        .auth-switch a:hover {
            text-decoration: underline;
        }

        @media (max-width: 1180px) {
            .auth-shell {
                grid-template-columns: 1fr;
            }

            .auth-visual {
                min-height: 520px;
            }

            .auth-content {
                min-height: auto;
            }
        }

        @media (max-width: 720px) {
            .auth-visual {
                min-height: 460px;
                padding: 26px;
            }

            .brand {
                gap: 14px;
            }

            .brand-logo {
                width: 72px;
                height: 72px;
                border-width: 3px;
            }

            .brand-name {
                font-size: 22px;
            }

            .brand-subtitle {
                font-size: 13px;
            }

            .hero-title {
                font-size: clamp(34px, 12vw, 52px);
                letter-spacing: -2px;
            }

            .hero-description {
                font-size: 15px;
                line-height: 1.65;
            }

            .auth-content {
                padding: 22px 16px;
            }

            .auth-card {
                padding: 28px 20px;
                border-radius: 28px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }
        }
    
        /* auth-dashboard-palette-start */

        /*
         * Palet autentikasi disamakan dengan dashboard:
         * biru, lavender, dan mint.
         * Bagian ini hanya mengubah warna.
         */
        :root {
            --pink: #7c9fd3;
            --pink-dark: #5579ad;
            --pink-soft: #e8f1ff;

            --green: #7fc7b2;
            --green-soft: #e6f8f2;

            --blue: #7c9fd3;
            --blue-dark: #5579ad;
            --blue-soft: #e8f1;

            --blue: #7c9fd3;
            --blue-darkff;

            --violet: #a697d6;
            --violet-dark: #7160a5;
            --violet-soft: #f0ecff;

            --mint: #7fc7b2;
            --mint-dark: #438674;
            --mint-soft: #e6f8f2;

            --primary: #7c9fd3;
            --primary-dark: #5579ad;
            --primary-soft: #e8f1ff;

            --accent: #a697d6;
            --accent-dark: #7160a5;
            --accent-soft: #f0ecff;

            --brand: #7c9fd3;
            --brand-dark: #5579ad;
            --brand-soft: #e8f1ff;

            --text: #191c20;
            --muted: #626a76;
            --line: #dfe3eb;

            --surface: rgba(255, 255, 255, 0.90);

            --shadow:
                0 24px 70px
                rgba(85, 121, 173, 0.16);

            --shadow-soft:
                0 14px 35px
                rgba(68, 83, 110, 0.09);
        }

        html,
        body {
            background:
                radial-gradient(
                    circle at 0% 0%,
                    rgba(166, 151, 214, 0.22),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 100% 100%,
                    rgba(127, 199, 178, 0.22),
                    transparent 34%
                ),
                linear-gradient(
                    135deg,
                    #f7f7ff 0%,
                    #f2f7ff 50%,
                    #eefaf7 100%
                ) !important;
        }

        /*
         * Elemen dekoratif halaman.
         */
        .bg-blob.one {
            background:
                rgba(166, 151, 214, 0.20) !important;
        }

        .bg-blob.two {
            background:
                rgba(127, 199, 178, 0.22) !important;
        }

        /*
         * Panel formulir kanan.
         */
        .auth-panel,
        .auth-side,
        .form-panel,
        .login-panel,
        .register-panel,
        .auth-form-panel {
            background:
                rgba(248, 251, 255, 0.88) !important;

            border-color:
                rgba(203, 210, 221, 0.88) !important;

            box-shadow:
                0 24px 70px
                rgba(85, 121, 173, 0.14) !important;
        }

        .auth-card,
        .form-card,
        .login-card,
        .register-card {
            background:
                rgba(255, 255, 255, 0.94) !important;

            border-color:
                rgba(203, 210, 221, 0.78) !important;

            box-shadow:
                0 22px 60px
                rgba(68, 83, 110, 0.09) !important;
        }

        /*
         * Panel gambar kiri tetap memakai foto dinamis.
         * Hanya tint warnanya dibuat biru netral.
         */
        .hero-panel,
        .auth-hero,
        .auth-visual,
        .visual-panel,
        .brand-panel,
        .auth-media {
            border-color:
                rgba(203, 210, 221, 0.76) !important;

            box-shadow:
                0 24px 70px
                rgba(68, 83, 110, 0.16) !important;
        }

        .hero-panel[style*="background"],
        .auth-hero[style*="background"],
        .auth-visual[style*="background"],
        .visual-panel[style*="background"],
        .brand-panel[style*="background"],
        .auth-media[style*="background"] {
            background-color:
                rgba(62, 82, 114, 0.48) !important;

            background-blend-mode:
                multiply !important;
        }

        /*
         * Judul aksen, link, dan badge.
         */
        .brand-subtitle,
        .hero-title span,
        .hero-pill,
        .hero-badge,
        .visual-badge,
        .forgot-link,
        .auth-footer a,
        .auth-link,
        .register-link,
        .login-link,
        .link-primary {
            color: #5579ad !important;
        }

        .hero-pill,
        .hero-badge,
        .visual-badge {
            background:
                rgba(255, 255, 255, 0.90) !important;

            border-color:
                rgba(124, 159, 211, 0.32) !important;

            box-shadow:
                0 10px 24px
                rgba(85, 121, 173, 0.10) !important;
        }

        /*
         * Kotak ikon.
         */
        .auth-icon,
        .form-icon,
        .welcome-icon,
        .header-icon,
        .icon-box,
        .feature-icon.pink {
            color: #5579ad !important;
            background: #e8f1ff !important;
        }

        .feature-icon.green {
            color: #438674 !important;
            background: #e6f8f2 !important;
        }

        /*
         * Input Login dan Register.
         */
        .form-input,
        .form-select,
        .auth-input,
        .auth-select,
        input:not([type="checkbox"]):not([type="radio"]),
        select {
            border-color: #cbd2dd !important;
            background-color: #ffffff !important;
        }

        .form-input:focus,
        .form-select:focus,
        .auth-input:focus,
        .auth-select:focus,
        input:not([type="checkbox"]):not([type="radio"]):focus,
        select:focus {
            border-color: #7c9fd3 !important;

            box-shadow:
                0 0 0 4px
                rgba(124, 159, 211, 0.14) !important;
        }

        input[type="checkbox"],
        input[type="radio"] {
            accent-color: #7c9fd3 !important;
        }

        /*
         * Tombol lihat password.
         */
        .password-eye:hover,
        .password-toggle:hover,
        .toggle-password:hover {
            color: #5579ad !important;
            background: #e8f1ff !important;
        }

        /*
         * Tombol utama Login dan Register.
         */
        .submit-button,
        .auth-submit,
        .primary-button,
        .auth-primary-button,
        .login-button,
        .register-button {
            color: #ffffff !important;

            background:
                linear-gradient(
                    135deg,
                    #7c9fd3 0%,
                    #6f91c6 52%,
                    #5579ad 100%
                ) !important;

            box-shadow:
                0 18px 34px
                rgba(85, 121, 173, 0.25) !important;
        }

        .submit-button:hover,
        .auth-submit:hover,
        .primary-button:hover,
        .auth-primary-button:hover,
        .login-button:hover,
        .register-button:hover {
            background:
                linear-gradient(
                    135deg,
                    #7396cb 0%,
                    #6689be 52%,
                    #4e70a3 100%
                ) !important;

            box-shadow:
                0 22px 40px
                rgba(85, 121, 173, 0.30) !important;
        }

        /*
         * Tombol Google tetap putih, hanya border diselaraskan.
         */
        .google-button,
        .google-login,
        .google-auth-button,
        .oauth-button {
            color: #191c20 !important;
            background: #ffffff !important;
            border-color: #cbd2dd !important;
            box-shadow: none !important;
        }

        .google-button:hover,
        .google-login:hover,
        .google-auth-button:hover,
        .oauth-button:hover {
            background: #f7f9ff !important;
            border-color: #aebed6 !important;
        }

        /*
         * Kartu informasi bagian bawah.
         */
        .mini-info,
        .info-card,
        .auth-info-card {
            background: #f8faff !important;
            border-color: #dfe3eb !important;
        }

        .mini-info:first-child,
        .info-card:first-child,
        .auth-info-card:first-child {
            background:
                linear-gradient(
                    135deg,
                    #f5f2ff,
                    #f8faff
                ) !important;
        }

        .mini-info:last-child,
        .info-card:last-child,
        .auth-info-card:last-child {
            background:
                linear-gradient(
                    135deg,
                    #eefaf7,
                    #f8faff
                ) !important;
        }

        /*
         * Garis dan border yang sebelumnya berwarna pink.
         */
        .feature-card,
        .auth-header,
        .form-divider,
        .auth-divider {
            border-color: #dfe3eb !important;
        }

        /* auth-dashboard-palette-end */

    </style>
</head>
<body>
    @php
        $googleRegister = session('google_register');
        $isGoogleRegister = is_array($googleRegister);
    @endphp

    <main class="auth-shell">
        <section class="auth-visual">
            <div class="brand">
                <div class="brand-logo">
                    <img
                        src="{{ $siteSetting->logo_url }}"
                        alt="Logo {{ $siteSetting->site_name }}"
                    >
                </div>

                <div>
                    <h1 class="brand-name">
                        {{ $siteSetting->site_name }}
                    </h1>

                    <div class="brand-subtitle">
                        {{ $siteSetting->site_subtitle }}
                    </div>
                </div>
            </div>

            <div class="hero-copy">
                <div class="hero-badge">
                    <span>🌿</span>
                    <span>Mulai Hidup Sehat</span>
                </div>

                <h2 class="hero-title">
                    Transformasi Kesehatan Dimulai dari Piring Anda
                </h2>

                <p class="hero-description">
                    Lengkapi data tubuh untuk mendapatkan estimasi kebutuhan
                    kalori harian dan menyusun pola makan yang lebih terarah.
                </p>
            </div>
        </section>

        <section class="auth-content">
            <div class="auth-card">
                <div class="auth-icon">♧</div>

                <h2 class="auth-title">
                    Buat Akun Baru
                </h2>

                <p class="auth-subtitle">
                    Isi data dasar Anda agar sistem dapat menghitung estimasi
                    kebutuhan kalori harian secara otomatis.
                </p>

                @if ($errors->any())
                    <div class="alert-error">
                        Pendaftaran belum berhasil. Periksa kembali data yang
                        Anda masukkan pada form.
                    </div>
                @endif

                @if (session('google_register_success'))
                    <div class="alert-google">
                        {{ session('google_register_success') }}
                    </div>
                @endif

                @if ($isGoogleRegister)
                    <div class="google-connected">
                        <div class="google-connected-icon">
                            G
                        </div>

                        <div>
                            <p class="google-connected-title">
                                Akun Google berhasil terhubung
                            </p>

                            <p class="google-connected-text">
                                Nama dan email telah diambil dari akun Google.
                                Lengkapi data tubuh, lalu klik Daftar Sekarang.
                            </p>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                Nama Lengkap
                            </label>

                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name', $googleRegister['name'] ?? '') }}"
                                class="form-input"
                                placeholder="Nama lengkap"
                                autocomplete="name"
                                autofocus
                                required
                            >

                            @error('name')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                Email
                            </label>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email', $googleRegister['email'] ?? '') }}"
                                class="form-input"
                                placeholder="nama@email.com"
                                autocomplete="email"
                                @readonly($isGoogleRegister)
                                required
                            >

                            @error('email')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror

                            @error('google')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">
                                Password

                                @if ($isGoogleRegister)
                                    <span class="label-note">
                                        (opsional)
                                    </span>
                                @endif
                            </label>

                            <div class="input-wrap">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="form-input has-toggle"
                                    placeholder="{{ $isGoogleRegister ? 'Opsional untuk akun Google' : 'Minimal 8 karakter' }}"
                                    autocomplete="new-password"
                                    @required(! $isGoogleRegister)
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    onclick="togglePassword('password', this)"
                                    aria-label="Tampilkan atau sembunyikan password"
                                >
                                    👁
                                </button>
                            </div>

                            @error('password')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label
                                for="password_confirmation"
                                class="form-label"
                            >
                                Konfirmasi Password

                                @if ($isGoogleRegister)
                                    <span class="label-note">
                                        (opsional)
                                    </span>
                                @endif
                            </label>

                            <div class="input-wrap">
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    class="form-input has-toggle"
                                    placeholder="{{ $isGoogleRegister ? 'Opsional untuk akun Google' : 'Ulangi password' }}"
                                    autocomplete="new-password"
                                    @required(! $isGoogleRegister)
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    onclick="togglePassword('password_confirmation', this)"
                                    aria-label="Tampilkan atau sembunyikan konfirmasi password"
                                >
                                    👁
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gender" class="form-label">
                                Gender
                            </label>

                            <div class="input-wrap">
                                <select
                                    id="gender"
                                    name="gender"
                                    class="form-select"
                                    required
                                >
                                    <option
                                        value=""
                                        disabled
                                        {{ old('gender') ? '' : 'selected' }}
                                    >
                                        Pilih gender
                                    </option>

                                    <option
                                        value="male"
                                        {{ old('gender') === 'male' ? 'selected' : '' }}
                                    >
                                        Laki-laki
                                    </option>

                                    <option
                                        value="female"
                                        {{ old('gender') === 'female' ? 'selected' : '' }}
                                    >
                                        Perempuan
                                    </option>
                                </select>

                                <span class="select-arrow">⌄</span>
                            </div>

                            @error('gender')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="age" class="form-label">
                                Usia
                            </label>

                            <input
                                id="age"
                                type="number"
                                name="age"
                                value="{{ old('age') }}"
                                class="form-input"
                                placeholder="Contoh: 21"
                                min="10"
                                max="100"
                                inputmode="numeric"
                                required
                            >

                            @error('age')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="height_cm" class="form-label">
                                Tinggi Badan
                            </label>

                            <input
                                id="height_cm"
                                type="number"
                                name="height_cm"
                                value="{{ old('height_cm') }}"
                                class="form-input"
                                placeholder="cm"
                                min="100"
                                max="250"
                                inputmode="numeric"
                                required
                            >

                            @error('height_cm')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="weight_kg" class="form-label">
                                Berat Badan
                            </label>

                            <input
                                id="weight_kg"
                                type="number"
                                step="0.1"
                                name="weight_kg"
                                value="{{ old('weight_kg') }}"
                                class="form-input"
                                placeholder="kg"
                                min="25"
                                max="300"
                                inputmode="decimal"
                                required
                            >

                            @error('weight_kg')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="activity_level" class="form-label">
                                Tingkat Aktivitas
                            </label>

                            <div class="input-wrap">
                                <select
                                    id="activity_level"
                                    name="activity_level"
                                    class="form-select"
                                    required
                                >
                                    <option
                                        value=""
                                        disabled
                                        {{ old('activity_level') ? '' : 'selected' }}
                                    >
                                        Pilih tingkat aktivitas
                                    </option>

                                    <option
                                        value="hampir_tidak_pernah_berolahraga"
                                        {{ old('activity_level') === 'hampir_tidak_pernah_berolahraga' ? 'selected' : '' }}
                                    >
                                        Hampir tidak pernah berolahraga
                                    </option>

                                    <option
                                        value="jarang_berolahraga"
                                        {{ old('activity_level') === 'jarang_berolahraga' ? 'selected' : '' }}
                                    >
                                        Jarang berolahraga
                                    </option>

                                    <option
                                        value="sering_berolahraga_atau_aktivitas_fisik_berat"
                                        {{ old('activity_level') === 'sering_berolahraga_atau_aktivitas_fisik_berat' ? 'selected' : '' }}
                                    >
                                        Sering berolahraga atau aktivitas fisik berat
                                    </option>
                                </select>

                                <span class="select-arrow">⌄</span>
                            </div>

                            @error('activity_level')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">
                        Daftar Sekarang →
                    </button>

                    <a
                        href="{{ route('google.redirect', ['flow' => 'register']) }}"
                        class="btn-google"
                    >
                        <span class="google-mark">G</span>
                        <span>Masuk dengan Google</span>
                    </a>
                </form>

                <p class="auth-switch">
                    Sudah punya akun?

                    <a href="{{ route('login') }}">
                        Masuk sekarang
                    </a>
                </p>
            </div>
        </section>
    </main>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);

            if (!input) {
                return;
            }

            const isHidden = input.type === 'password';

            input.type = isHidden ? 'text' : 'password';
            button.textContent = isHidden ? '🙈' : '👁';
        }
    </script>
</body>
</html>