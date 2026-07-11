<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Password - {{ $siteSetting->site_name }}</title>

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
                linear-gradient(
                    rgba(255, 247, 251, .84),
                    rgba(255, 247, 251, .94)
                ),
                url("{{ $siteSetting->auth_background_url }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        input,
        button {
            font: inherit;
        }

        .auth-shell {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 28px;
        }

        .auth-card {
            width: 100%;
            max-width: 560px;
            padding: 46px;
            border: 1px solid rgba(236, 111, 159, .18);
            border-radius: 34px;
            background: rgba(255, 255, 255, .94);
            box-shadow: 0 24px 80px rgba(217, 79, 132, .16);
            backdrop-filter: blur(18px);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 34px;
        }

        .brand-logo {
            width: 70px;
            height: 70px;
            flex: 0 0 auto;
            overflow: hidden;
            border: 3px solid #ffffff;
            border-radius: 50%;
            background: #ffffff;
            box-shadow: 0 14px 30px rgba(217, 79, 132, .16);
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
        }

        .brand-title {
            margin: 0;
            color: #171827;
            font-size: 24px;
            font-weight: 950;
            letter-spacing: -.8px;
        }

        .brand-subtitle {
            margin-top: 5px;
            color: #6b7084;
            font-size: 13px;
            font-weight: 800;
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
            line-height: 1.08;
            font-weight: 950;
            letter-spacing: -1.8px;
        }

        .auth-subtitle {
            margin: 16px 0 30px;
            color: #6b7084;
            font-size: 15px;
            line-height: 1.7;
            font-weight: 700;
        }

        .alert-error {
            margin-bottom: 18px;
            padding: 14px 16px;
            border: 1px solid #ffd2df;
            border-radius: 18px;
            color: #c72f5d;
            background: #fff0f4;
            font-size: 13px;
            line-height: 1.6;
            font-weight: 800;
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

        .input-icon {
            position: absolute;
            top: 50%;
            left: 22px;
            transform: translateY(-50%);
            color: #aaa2ae;
            font-size: 18px;
            pointer-events: none;
        }

        .form-input {
            width: 100%;
            min-height: 64px;
            padding: 0 58px;
            border: 1px solid #ead7df;
            border-radius: 999px;
            outline: none;
            color: #202231;
            background: rgba(255, 255, 255, .92);
            font-size: 15px;
            font-weight: 800;
            transition: .2s ease;
        }

        .form-input.has-toggle {
            padding-right: 66px;
        }

        .form-input::placeholder {
            color: #aaa2ae;
        }

        .form-input:focus {
            border-color: #ec6f9f;
            box-shadow: 0 0 0 5px rgba(236, 111, 159, .12);
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 18px;
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
            margin-top: 8px;
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

        @media (max-width: 720px) {
            .auth-shell {
                padding: 18px;
            }

            .auth-card {
                padding: 30px 22px;
                border-radius: 28px;
            }
        }
    </style>
</head>
<body>
    <main class="auth-shell">
        <section class="auth-card">
            <div class="brand">
                <div class="brand-logo">
                    <img
                        src="{{ $siteSetting->logo_url }}"
                        alt="Logo {{ $siteSetting->site_name }}"
                    >
                </div>

                <div>
                    <h1 class="brand-title">
                        {{ $siteSetting->site_name }}
                    </h1>

                    <div class="brand-subtitle">
                        {{ $siteSetting->site_subtitle }}
                    </div>
                </div>
            </div>

            <div class="auth-icon">🔐</div>

            <h2 class="auth-title">
                Reset Password
            </h2>

            <p class="auth-subtitle">
                Buat password baru untuk akun Anda. Gunakan minimal delapan
                karakter dan pastikan konfirmasi password sama.
            </p>

            @if ($errors->any())
                <div class="alert-error">
                    Reset password belum berhasil. Periksa kembali email,
                    password baru, dan konfirmasi password.
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input
                    type="hidden"
                    name="token"
                    value="{{ $token }}"
                >

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
                            value="{{ old('email', $email) }}"
                            class="form-input"
                            placeholder="nama@email.com"
                            autocomplete="email"
                            required
                        >
                    </div>

                    @error('email')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        Password Baru
                    </label>

                    <div class="input-wrap">
                        <span class="input-icon">⌕</span>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-input has-toggle"
                            placeholder="Minimal 8 karakter"
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('password', this)"
                            aria-label="Tampilkan atau sembunyikan password baru"
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
                        Konfirmasi Password Baru
                    </label>

                    <div class="input-wrap">
                        <span class="input-icon">⌕</span>

                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="form-input has-toggle"
                            placeholder="Ulangi password baru"
                            autocomplete="new-password"
                            required
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

                <button type="submit" class="btn-primary">
                    Simpan Password Baru →
                </button>
            </form>

            <p class="auth-switch">
                Kembali ke

                <a href="{{ route('login') }}">
                    halaman login
                </a>
            </p>
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