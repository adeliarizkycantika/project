<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - Meal Planner</title>

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --primary: #f472b6;
            --primary-dark: #db2777;
            --secondary: #fb7185;
            --soft-pink: #fff1f7;
            --soft-green: #dcfce7;
            --soft-border: #fbcfe8;
            --text: #111827;
            --muted: #64748b;
            --border: #f3d7e5;
            --card: #ffffff;
            --danger: #dc2626;
            --success: #166534;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 12% 12%, rgba(252, 231, 243, 0.9), transparent 32%),
                radial-gradient(circle at 88% 10%, rgba(255, 228, 230, 0.75), transparent 28%),
                radial-gradient(circle at 50% 100%, rgba(220, 252, 231, 0.55), transparent 32%),
                linear-gradient(135deg, #fff7fb 0%, #fffafe 48%, #ffffff 100%);
        }

        a {
            color: inherit;
        }

        button,
        input {
            font-family: inherit;
        }

        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 34px 22px;
        }

        .auth-shell {
            width: 100%;
            max-width: 1080px;
            display: grid;
            grid-template-columns: 0.95fr 1.05fr;
            border-radius: 34px;
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(244, 114, 182, 0.18);
            box-shadow: 0 28px 70px rgba(244, 114, 182, 0.15);
            overflow: hidden;
            backdrop-filter: blur(18px);
        }

        .auth-hero {
            position: relative;
            min-height: 620px;
            padding: 42px;
            background:
                radial-gradient(circle at 20% 18%, rgba(252, 231, 243, 0.9), transparent 30%),
                radial-gradient(circle at 82% 34%, rgba(220, 252, 231, 0.85), transparent 28%),
                linear-gradient(160deg, #fff1f7 0%, #fff7ed 100%);
            border-right: 1px solid rgba(244, 114, 182, 0.16);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f9a8d4, #fb7185);
            color: #ffffff;
            font-size: 25px;
            box-shadow: 0 16px 30px rgba(244, 114, 182, 0.28);
        }

        .brand-text {
            font-size: 24px;
            line-height: 1;
            font-weight: 950;
            color: #be185d;
            letter-spacing: -0.04em;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            min-height: 42px;
            padding: 0 15px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid rgba(244, 114, 182, 0.20);
            color: #be185d;
            font-size: 13px;
            font-weight: 950;
            margin-bottom: 18px;
            box-shadow: 0 12px 24px rgba(244, 114, 182, 0.10);
        }

        .hero-title {
            margin: 0;
            font-size: 48px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -0.06em;
            color: #111827;
        }

        .hero-text {
            margin: 18px 0 0;
            max-width: 410px;
            color: #64748b;
            font-size: 17px;
            line-height: 1.65;
            font-weight: 700;
        }

        .hero-feature-list {
            display: grid;
            gap: 12px;
            margin-top: 28px;
        }

        .hero-feature {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #334155;
            font-size: 15px;
            font-weight: 850;
        }

        .hero-feature-icon {
            width: 38px;
            height: 38px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 1px solid rgba(244, 114, 182, 0.16);
        }

        .hero-illustration {
            position: relative;
            z-index: 2;
            height: 230px;
            border-radius: 30px;
            background:
                radial-gradient(circle at 20% 24%, rgba(252, 231, 243, 0.95), transparent 30%),
                radial-gradient(circle at 78% 25%, rgba(220, 252, 231, 0.9), transparent 30%),
                linear-gradient(135deg, #ffffff, #fff7fb);
            border: 1px solid rgba(244, 114, 182, 0.16);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.75);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-bunny-image {
            width: 220px;
            height: 220px;
            object-fit: contain;
            display: block;
            filter: drop-shadow(0 18px 24px rgba(244, 114, 182, 0.18));
        }

        .auth-main {
            padding: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.64);
        }

        .auth-form-wrapper {
            width: 100%;
            max-width: 460px;
        }

        .auth-header {
            margin-bottom: 28px;
        }

        .auth-title {
            margin: 0;
            font-size: 42px;
            line-height: 1.08;
            font-weight: 950;
            color: #111827;
            letter-spacing: -0.055em;
        }

        .auth-subtitle {
            margin: 12px 0 0;
            color: #64748b;
            font-size: 16px;
            line-height: 1.55;
            font-weight: 700;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid rgba(244, 114, 182, 0.18);
            border-radius: 28px;
            box-shadow: 0 18px 42px rgba(244, 114, 182, 0.10);
            padding: 30px;
        }

        .alert-success {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 16px;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
            font-size: 14px;
            font-weight: 850;
        }

        .alert-error {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 16px;
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            font-size: 14px;
            font-weight: 850;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 9px;
            color: #334155;
            font-size: 15px;
            font-weight: 950;
        }

        .form-input {
            width: 100%;
            height: 58px;
            padding: 0 18px;
            border: 1px solid #f3d7e5;
            border-radius: 18px;
            background: #ffffff;
            color: #111827;
            font-size: 16px;
            font-weight: 750;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            border-color: #f472b6;
            box-shadow: 0 0 0 5px rgba(244, 114, 182, 0.14);
        }

        .form-input::placeholder {
            color: #94a3b8;
            font-weight: 650;
        }

        .error-text {
            margin: 8px 0 0;
            color: #dc2626;
            font-size: 13px;
            font-weight: 850;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin: 2px 0 24px;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #475569;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
        }

        .remember-checkbox {
            width: 18px;
            height: 18px;
            border-radius: 6px;
            accent-color: #f472b6;
        }

        .auth-link {
            color: #db2777;
            font-size: 14px;
            font-weight: 950;
            text-decoration: none;
        }

        .auth-link:hover {
            text-decoration: underline;
        }

        .auth-button {
            width: 100%;
            height: 56px;
            border: none;
            border-radius: 18px;
            background: linear-gradient(135deg, #f472b6, #fb7185);
            color: #ffffff;
            font-size: 16px;
            font-weight: 950;
            cursor: pointer;
            box-shadow: 0 14px 26px rgba(244, 114, 182, 0.24);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .auth-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 34px rgba(244, 114, 182, 0.30);
        }

        .auth-footer-text {
            margin: 22px 0 0;
            text-align: center;
            color: #64748b;
            font-size: 14px;
            font-weight: 750;
        }

        .auth-footer-text a {
            color: #db2777;
            font-weight: 950;
            text-decoration: none;
        }

        .auth-footer-text a:hover {
            text-decoration: underline;
        }

        .copyright {
            margin-top: 24px;
            text-align: center;
            color: #94a3b8;
            font-size: 14px;
            font-weight: 750;
        }

        @media (max-width: 980px) {
            .auth-shell {
                grid-template-columns: 1fr;
                max-width: 560px;
            }

            .auth-hero {
                min-height: auto;
                padding: 30px;
                gap: 28px;
                border-right: none;
                border-bottom: 1px solid rgba(244, 114, 182, 0.16);
            }

            .hero-title {
                font-size: 38px;
            }

            .hero-illustration {
                height: 190px;
            }

            .hero-bunny-image {
                width: 180px;
                height: 180px;
            }

            .auth-main {
                padding: 30px;
            }
        }

        @media (max-width: 620px) {
            .auth-page {
                padding: 18px;
                align-items: flex-start;
            }

            .auth-shell {
                border-radius: 26px;
            }

            .auth-hero {
                padding: 24px;
            }

            .hero-title {
                font-size: 32px;
            }

            .hero-text {
                font-size: 15px;
            }

            .hero-feature-list {
                gap: 10px;
            }

            .auth-main {
                padding: 24px;
            }

            .auth-card {
                padding: 24px;
                border-radius: 24px;
            }

            .auth-title {
                font-size: 34px;
            }

            .form-options {
                align-items: flex-start;
                flex-direction: column;
            }

            .hero-illustration {
                height: 160px;
            }

            .hero-bunny-image {
                width: 150px;
                height: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-page">
        <div class="auth-shell">
            <aside class="auth-hero">
                <a href="{{ route('login') }}" class="brand">
                    <div class="brand-icon">
                        🐰
                    </div>

                    <div class="brand-text">
                        Meal Planner
                    </div>
                </a>

                <div class="hero-content">
                    <div class="hero-badge">
                        🌸 Cute Pastel Dashboard
                    </div>

                    <h1 class="hero-title">
                        Atur makan sehat dengan tampilan yang manis.
                    </h1>

                    <p class="hero-text">
                        Login untuk melihat target kalori, jadwal makan, daftar belanja, dan progress harian kamu.
                    </p>

                    <div class="hero-feature-list">
                        <div class="hero-feature">
                            <span class="hero-feature-icon">🎯</span>
                            Target kalori harian lebih mudah dipantau
                        </div>

                        <div class="hero-feature">
                            <span class="hero-feature-icon">🍓</span>
                            Simpan menu makanan favorit
                        </div>

                        <div class="hero-feature">
                            <span class="hero-feature-icon">🛒</span>
                            Generate daftar belanja dari meal plan
                        </div>
                    </div>
                </div>

                <div class="hero-illustration">
                    <img
                        src="{{ asset('images/kelinci-stroberi.png') }}"
                        alt="Kelinci imut memegang stroberi"
                        class="hero-bunny-image"
                    >
                </div>
            </aside>

            <main class="auth-main">
                <div class="auth-form-wrapper">
                    <div class="auth-header">
                        <h2 class="auth-title">
                            Selamat Datang 👋
                        </h2>

                        <p class="auth-subtitle">
                            Masuk ke akun kamu untuk melanjutkan mengelola Meal Planner.
                        </p>
                    </div>

                    <div class="auth-card">
                        @if (session()->has('success'))
                            <div class="alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->has('email'))
                            <div class="alert-error">
                                {{ $errors->first('email') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email" class="form-label">
                                    Email
                                </label>

                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-input"
                                    placeholder="email@example.com"
                                    autocomplete="email"
                                    required
                                    autofocus
                                >

                                @error('email')
                                    <p class="error-text">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">
                                    Password
                                </label>

                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="form-input"
                                    placeholder="Masukkan password"
                                    autocomplete="current-password"
                                    required
                                >

                                @error('password')
                                    <p class="error-text">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="form-options">
                                <label class="remember-label" for="remember">
                                    <input
                                        id="remember"
                                        type="checkbox"
                                        name="remember"
                                        value="1"
                                        class="remember-checkbox"
                                    >

                                    Ingat saya
                                </label>

                                <a href="{{ route('register') }}" class="auth-link">
                                    Daftar akun
                                </a>
                            </div>

                            <button type="submit" class="auth-button">
                                Login
                            </button>
                        </form>

                        <p class="auth-footer-text">
                            Belum punya akun?
                            <a href="{{ route('register') }}">
                                Buat akun sekarang
                            </a>
                        </p>
                    </div>

                    <div class="copyright">
                        © {{ date('Y') }} Meal Planner
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>