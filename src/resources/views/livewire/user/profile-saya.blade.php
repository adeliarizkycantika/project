<div>
    <style>
        .profile-page {
            max-width: 1120px;
        }

        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 18px;
            margin-bottom: 28px;
        }

        .profile-title {
            margin: 0;
            font-size: 42px;
            line-height: 1.1;
            font-weight: 950;
            color: #111827;
            letter-spacing: -0.05em;
        }

        .profile-subtitle {
            margin: 10px 0 0;
            color: #64748b;
            font-size: 17px;
            font-weight: 700;
        }

        .profile-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-height: 50px;
            padding: 0 18px;
            border-radius: 999px;
            background: #fff1f7;
            border: 1px solid #fbcfe8;
            color: #be185d;
            font-size: 14px;
            font-weight: 950;
            white-space: nowrap;
        }

        .alert-success-profile {
            margin-bottom: 22px;
            padding: 16px 18px;
            border-radius: 18px;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            font-size: 15px;
            font-weight: 850;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(320px, 0.65fr);
            gap: 22px;
            align-items: start;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid rgba(244, 114, 182, 0.18);
            border-radius: 28px;
            box-shadow: 0 18px 42px rgba(244, 114, 182, 0.10);
            overflow: hidden;
        }

        .profile-card-header {
            padding: 26px 28px 20px;
            border-bottom: 1px solid rgba(244, 114, 182, 0.14);
        }

        .profile-card-title {
            margin: 0;
            color: #111827;
            font-size: 24px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -0.03em;
        }

        .profile-card-subtitle {
            margin: 8px 0 0;
            color: #64748b;
            font-size: 15px;
            line-height: 1.5;
            font-weight: 650;
        }

        .profile-card-body {
            padding: 28px;
        }

        .profile-form-grid {
            display: grid;
            gap: 20px;
        }

        .profile-form-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .profile-field {
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .profile-label {
            color: #334155;
            font-size: 15px;
            font-weight: 950;
        }

        .profile-input {
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

        .profile-input:focus {
            border-color: #f472b6;
            box-shadow: 0 0 0 5px rgba(244, 114, 182, 0.14);
        }

        .profile-input::placeholder {
            color: #94a3b8;
            font-weight: 650;
        }

        .profile-error {
            margin: 0;
            color: #dc2626;
            font-size: 13px;
            font-weight: 850;
        }

        .profile-actions {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 12px;
            margin-top: 8px;
        }

        .profile-button {
            min-height: 52px;
            padding: 0 24px;
            border: none;
            border-radius: 18px;
            background: linear-gradient(135deg, #f472b6, #fb7185);
            color: #ffffff;
            font-size: 15px;
            font-weight: 950;
            cursor: pointer;
            box-shadow: 0 14px 26px rgba(244, 114, 182, 0.22);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .profile-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 32px rgba(244, 114, 182, 0.26);
        }

        .profile-button.secondary {
            background: #22c55e;
            box-shadow: 0 14px 26px rgba(34, 197, 94, 0.16);
        }

        .profile-info-card {
            padding: 26px;
            position: relative;
            overflow: hidden;
            min-height: 245px;
        }

        .profile-info-card::after {
            content: "";
            position: absolute;
            right: -46px;
            bottom: -46px;
            width: 150px;
            height: 150px;
            border-radius: 999px;
            background: rgba(252, 231, 243, 0.75);
            z-index: 0;
        }

        .profile-avatar {
            position: relative;
            z-index: 2;
            width: 74px;
            height: 74px;
            border-radius: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f9a8d4, #fb7185);
            color: #ffffff;
            font-size: 30px;
            font-weight: 950;
            box-shadow: 0 16px 30px rgba(244, 114, 182, 0.24);
            margin-bottom: 18px;
        }

        .profile-info-name {
            position: relative;
            z-index: 2;
            margin: 0;
            color: #111827;
            font-size: 25px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -0.03em;
        }

        .profile-info-email {
            position: relative;
            z-index: 2;
            margin: 8px 0 0;
            color: #64748b;
            font-size: 15px;
            line-height: 1.4;
            font-weight: 700;
            word-break: break-word;
        }

        .profile-info-stat {
            position: relative;
            z-index: 2;
            margin-top: 22px;
            padding: 16px;
            border-radius: 20px;
            background: #fff7fb;
            border: 1px solid #fbcfe8;
        }

        .profile-info-stat-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 950;
        }

        .profile-info-stat-value {
            margin-top: 8px;
            color: #be185d;
            font-size: 28px;
            line-height: 1;
            font-weight: 950;
        }

        .profile-info-stat-unit {
            margin-top: 5px;
            color: #64748b;
            font-size: 13px;
            font-weight: 800;
        }

        .password-card {
            margin-top: 22px;
        }

        @media (max-width: 1100px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .profile-info-card {
                min-height: auto;
            }
        }

        @media (max-width: 720px) {
            .profile-header {
                flex-direction: column;
            }

            .profile-title {
                font-size: 34px;
            }

            .profile-form-row {
                grid-template-columns: 1fr;
            }

            .profile-card-header,
            .profile-card-body,
            .profile-info-card {
                padding: 22px;
            }

            .profile-button {
                width: 100%;
            }

            .profile-actions {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>

    <div class="profile-page">
        <div class="profile-header">
            <div>
                <h1 class="profile-title">
                    Profile Saya
                </h1>

                <p class="profile-subtitle">
                    Kelola data akun dan target kalori harian kamu.
                </p>
            </div>

            <div class="profile-badge">
                👤 Akun Pengguna
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert-success-profile">
                {{ session('success') }}
            </div>
        @endif

        <div class="profile-grid">
            <div>
                <div class="profile-card">
                    <div class="profile-card-header">
                        <h2 class="profile-card-title">
                            Informasi Profile
                        </h2>

                        <p class="profile-card-subtitle">
                            Perbarui nama, email, dan target kalori harian. Target ini akan dipakai di halaman Beranda.
                        </p>
                    </div>

                    <div class="profile-card-body">
                        <form wire:submit.prevent="updateProfile">
                            <div class="profile-form-grid">
                                <div class="profile-form-row">
                                    <div class="profile-field">
                                        <label class="profile-label" for="name">
                                            Nama
                                        </label>

                                        <input
                                            id="name"
                                            type="text"
                                            wire:model="name"
                                            class="profile-input"
                                            placeholder="Masukkan nama lengkap"
                                        >

                                        @error('name')
                                            <p class="profile-error">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div class="profile-field">
                                        <label class="profile-label" for="email">
                                            Email
                                        </label>

                                        <input
                                            id="email"
                                            type="email"
                                            wire:model="email"
                                            class="profile-input"
                                            placeholder="email@example.com"
                                        >

                                        @error('email')
                                            <p class="profile-error">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="profile-field">
                                    <label class="profile-label" for="daily_calorie_target">
                                        Target Kalori Harian
                                    </label>

                                    <input
                                        id="daily_calorie_target"
                                        type="number"
                                        min="1"
                                        max="10000"
                                        wire:model="daily_calorie_target"
                                        class="profile-input"
                                        placeholder="Contoh: 2000"
                                    >

                                    @error('daily_calorie_target')
                                        <p class="profile-error">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="profile-actions">
                                    <button type="submit" class="profile-button">
                                        Simpan Profile
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="profile-card password-card">
                    <div class="profile-card-header">
                        <h2 class="profile-card-title">
                            Ubah Password
                        </h2>

                        <p class="profile-card-subtitle">
                            Gunakan password baru minimal 8 karakter agar akun tetap aman.
                        </p>
                    </div>

                    <div class="profile-card-body">
                        <form wire:submit.prevent="updatePassword">
                            <div class="profile-form-grid">
                                <div class="profile-field">
                                    <label class="profile-label" for="current_password">
                                        Password Lama
                                    </label>

                                    <input
                                        id="current_password"
                                        type="password"
                                        wire:model="current_password"
                                        class="profile-input"
                                        placeholder="Masukkan password lama"
                                    >

                                    @error('current_password')
                                        <p class="profile-error">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="profile-form-row">
                                    <div class="profile-field">
                                        <label class="profile-label" for="password">
                                            Password Baru
                                        </label>

                                        <input
                                            id="password"
                                            type="password"
                                            wire:model="password"
                                            class="profile-input"
                                            placeholder="Minimal 8 karakter"
                                        >

                                        @error('password')
                                            <p class="profile-error">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div class="profile-field">
                                        <label class="profile-label" for="password_confirmation">
                                            Konfirmasi Password
                                        </label>

                                        <input
                                            id="password_confirmation"
                                            type="password"
                                            wire:model="password_confirmation"
                                            class="profile-input"
                                            placeholder="Ulangi password baru"
                                        >
                                    </div>
                                </div>

                                <div class="profile-actions">
                                    <button type="submit" class="profile-button secondary">
                                        Simpan Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <aside class="profile-card profile-info-card">
                <div class="profile-avatar">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                </div>

                <h2 class="profile-info-name">
                    {{ auth()->user()?->name ?? 'User' }}
                </h2>

                <p class="profile-info-email">
                    {{ auth()->user()?->email ?? 'user@example.com' }}
                </p>

                <div class="profile-info-stat">
                    <div class="profile-info-stat-label">
                        Target Kalori Harian
                    </div>

                    <div class="profile-info-stat-value">
                        {{ number_format((int) (auth()->user()?->daily_calorie_target ?? 2000)) }}
                    </div>

                    <div class="profile-info-stat-unit">
                        kalori per hari
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>