<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Register - {{ config('app.name', 'Meal Planner') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f8fafc;
            color: #111827;
        }

        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 460px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 22px;
        }

        .auth-title {
            margin: 0;
            font-size: 36px;
            line-height: 1.2;
            font-weight: 800;
            color: #111827;
        }

        .auth-subtitle {
            margin: 8px 0 0;
            font-size: 16px;
            color: #6b7280;
        }

        .auth-card {
            width: 100%;
            padding: 28px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }

        .alert {
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 14px;
        }

        .alert ul {
            margin: 0;
            padding-left: 18px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 700;
            color: #374151;
        }

        .form-input {
            display: block;
            width: 100%;
            height: 46px;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            background: #ffffff;
            color: #111827;
            font-size: 15px;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .form-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 4px 0 20px;
        }

        .auth-link {
            font-size: 14px;
            font-weight: 700;
            color: #2563eb;
            text-decoration: none;
        }

        .auth-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        .submit-button {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 12px;
            background: #2563eb;
            color: #ffffff;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            transition: background 0.15s ease, transform 0.15s ease;
        }

        .submit-button:hover {
            background: #1d4ed8;
        }

        .submit-button:active {
            transform: scale(0.99);
        }

        .auth-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 13px;
            color: #9ca3af;
        }

        @media (max-width: 480px) {
            .auth-page {
                padding: 16px;
            }

            .auth-title {
                font-size: 30px;
            }

            .auth-card {
                padding: 22px;
            }
        }
    </style>
</head>
<body>
    <main class="auth-page">
        <div class="auth-wrapper">
            <div class="auth-header">
                <h1 class="auth-title">
                    Meal Planner
                </h1>

                <p class="auth-subtitle">
                    Buat akun untuk mulai menyusun rencana makan.
                </p>
            </div>

            <section class="auth-card">
                @if ($errors->any())
                    <div class="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">
                            Nama
                        </label>

                        <input
                            id="name"
                            class="form-input"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Nama lengkap"
                            required
                            autofocus
                            autocomplete="name"
                        >
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            Email
                        </label>

                        <input
                            id="email"
                            class="form-input"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="email@example.com"
                            required
                            autocomplete="email"
                        >
                    </div>

                    <div class="form-group">
                        <label for="daily_calorie_target" class="form-label">
                            Target Kalori Harian
                        </label>

                        <input
                            id="daily_calorie_target"
                            class="form-input"
                            type="number"
                            name="daily_calorie_target"
                            value="{{ old('daily_calorie_target', 2000) }}"
                            placeholder="Contoh: 2000"
                            min="1"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            Password
                        </label>

                        <input
                            id="password"
                            class="form-input"
                            type="password"
                            name="password"
                            placeholder="Minimal 8 karakter"
                            required
                            autocomplete="new-password"
                        >
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            Konfirmasi Password
                        </label>

                        <input
                            id="password_confirmation"
                            class="form-input"
                            type="password"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            required
                            autocomplete="new-password"
                        >
                    </div>

                    <div class="form-row">
                        <a href="{{ route('login') }}" class="auth-link">
                            Sudah punya akun?
                        </a>
                    </div>

                    <button type="submit" class="submit-button">
                        Register
                    </button>
                </form>
            </section>

            <p class="auth-footer">
                &copy; {{ date('Y') }} Meal Planner
            </p>
        </div>
    </main>
</body>
</html>