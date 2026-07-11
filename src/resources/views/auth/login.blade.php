<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - {{ $siteSetting->site_name }}</title>

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

        .auth-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(520px, 1fr);
        }

        .auth-visual {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
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
            pointer-events: none;
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
            padding: 0;
            overflow: hidden;
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
            padding: 48px 28px;
        }

        .auth-card {
            width: 100%;
            max-width: 610px;
            padding: 48px;
            border: 1px solid rgba(236, 111, 159, .18);
            border-radius: 34px;
            background: rgba(255, 255, 255, .92);
            box-shadow: 0 24px 80px rgba(217, 79, 132, .16);
        }

        .auth-icon {
            width: 76px;
            height: 76px;
            display: grid;
            place-items: center;
            margin-bottom: 30px;
            border-radius: 28px;
            color: #e24f8c;
            background: #fff0f6;
            font-size: 32px;
        }

        .auth-title {
            margin: 0;
            color: #171827;
            font-size: clamp(32px, 4vw, 42px);
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -1.8px;
        }

        .auth-subtitle {
            margin: 16px 0 32px;
            color: #6b7084;
            font-size: 16px;
            line-height: 1.65;
            font-weight: 700;
        }

        .alert-error,
        .alert-success {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 18px;
            font-size: 13px;
            font-weight: 800;
        }

        .alert-error {
            border: 1px solid #ffd2df;
            color: #c72f5d;
            background: #fff0f4;
        }

        .alert-success {
            border: 1px solid #b7efc5;
            color: #2f7d4d;
            background: #f0fff5;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 9px;
            color: #161827;
            font-size: 14px;
            font-weight: 950;
        }

        .input-wrap {
            position: relative;
        }

        .form-input {
            width: 100%;
            min-height: 64px;
            padding: 0 58px;
            border: 1px solid #ead7df;
            border-radius: 999px;
            outline: none;
            color: #202231;
            background: rgba(255, 255, 255, .9);
            font-size: 15px;
            font-weight: 800;
            transition: .2s ease;
        }

        .form-input::placeholder {
            color: #aaa2ae;
        }

        .form-input:focus {
            border-color: #ec6f9f;
            box-shadow: 0 0 0 5px rgba(236, 111, 159, .12);
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 22px;
            transform: translateY(-50%);
            color: #aaa2ae;
            font-size: 18px;
            pointer-events: none;
        }

        .input-right {
            position: absolute;
            top: 50%;
            right: 22px;
            transform: translateY(-50%);
            color: #aaa2ae;
            font-size: 16px;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 20px;
            width: 34px;
            height: 34px;
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
            font-weight: 800;
        }

        .auth-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin: 8px 0 28px;
            color: #6b7084;
            font-size: 13px;
            font-weight: 800;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 9px;
        }

        .remember input {
            width: 17px;
            height: 17px;
            accent-color: #ec6f9f;
        }

        .forgot-link {
            color: #e24f8c;
            text-decoration: none;
            font-weight: 950;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .btn-primary {
            width: 100%;
            min-height: 66px;
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

        .auth-google-after {
            margin-top: 14px;
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

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 34px;
        }

        .info-card {
            display: flex;
            gap: 13px;
            padding: 18px;
            border: 1px solid #f4d9e3;
            border-radius: 20px;
            background: #fff9fc;
        }

        .info-icon {
            width: 42px;
            height: 42px;
            flex: 0 0 auto;
            display: grid;
            place-items: center;
            border-radius: 16px;
            color: #e24f8c;
            background: #fff0f6;
            font-size: 18px;
        }

        .info-icon.green {
            color: #3f8f61;
            background: #edf9f0;
        }

        .info-title {
            margin: 0 0 4px;
            color: #232638;
            font-size: 13px;
            font-weight: 950;
        }

        .info-text {
            margin: 0;
            color: #6b7084;
            font-size: 12px;
            line-height: 1.45;
            font-weight: 800;
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

            .info-grid {
                grid-template-columns: 1fr;
            }

            .auth-options {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
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
                    <span>Hidup Lebih Sehat</span>
                </div>

                <h2 class="hero-title">
                    Transformasi Kesehatan Dimulai dari Piring Anda
                </h2>

                <p class="hero-description">
                    Kelola rencana nutrisi harian dengan presisi berbasis data
                    untuk mencapai target kesehatan Anda dengan lebih mudah
                    dan menyenangkan.
                </p>
            </div>
        </section>

        <section class="auth-content">
            <div class="auth-card">
                <div class="auth-icon">♡</div>

                <h2 class="auth-title">
                    Selamat Datang Kembali
                </h2>

                <p class="auth-subtitle">
                    Silakan masuk untuk melanjutkan perjalanan sehat Anda dan
                    memantau perkembangan nutrisi harian.
                </p>

                @if (session('status'))
                    <div class="alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-error">
                        Login belum berhasil. Silakan periksa kembali data yang
                        Anda masukkan.
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">
                            Email
                        </label>

                        <div class="input-wrap">
                            <span class="input-icon">✉</span>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-input"
                                placeholder="nama@email.com"
                                autocomplete="email"
                                autofocus
                                required
                            >

                            <span class="input-right">⌘</span>
                        </div>

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
                        </label>

                        <div class="input-wrap">
                            <span class="input-icon">⌕</span>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-input"
                                placeholder="Masukkan kata sandi"
                                autocomplete="current-password"
                                required
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

                    <div class="auth-options">
                        <label class="remember">
                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                @checked(old('remember'))
                            >

                            <span>Ingat saya</span>
                        </label>

                        <a
                            href="{{ route('password.request') }}"
                            class="forgot-link"
                        >
                            Lupa password?
                        </a>
                    </div>

                    <button type="submit" class="btn-primary">
                        Masuk →
                    </button>

                    <a
                        href="{{ route('google.redirect') }}"
                        class="btn-google auth-google-after"
                    >
                        <span class="google-mark">G</span>
                        <span>Masuk dengan Google</span>
                    </a>
                </form>

                <p class="auth-switch">
                    Belum punya akun?
                    <a href="{{ route('register') }}">
                        Daftar sekarang
                    </a>
                </p>

                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-icon">♧</div>

                        <div>
                            <p class="info-title">User Baru</p>

                            <p class="info-text">
                                Daftar akun dan isi data tubuh untuk menghitung
                                kalori otomatis.
                            </p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon green">♡</div>

                        <div>
                            <p class="info-title">Admin</p>

                            <p class="info-text">
                                Admin dapat mengelola makanan, user, meal plan,
                                dan bahan makanan.
                            </p>
                        </div>
                    </div>
                </div>
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