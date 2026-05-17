<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.name', 'Meal Planner') }}</title>

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
            max-width: 420px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 24px;
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
            margin-bottom: 20px;
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
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
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
            margin-bottom: 20px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #4b5563;
        }

        .checkbox-input {
            width: 16px;
            height: 16px;
            border-radius: 4px;
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

            .form-row {
                align-items: flex-start;
                flex-direction: column;
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
                    Masuk untuk mengelola meal plan kamu.
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

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf

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
                            autofocus
                            autocomplete="email"
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
                            placeholder="Masukkan password"
                            required
                            autocomplete="current-password"
                        >
                    </div>

                    <div class="form-row">
                        <label class="checkbox-label">
                            <input
                                type="checkbox"
                                name="remember"
                                class="checkbox-input"
                            >

                            <span>Ingat saya</span>
                        </label>

                        <a href="{{ route('register') }}" class="auth-link">
                            Daftar akun
                        </a>
                    </div>

                    <button type="submit" class="submit-button">
                        Login
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