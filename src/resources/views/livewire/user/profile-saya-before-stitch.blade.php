<div class="profile-page">
    <style>
        .profile-page {
            --pm-primary: #ec6f9f;
            --pm-primary-dark: #d94f84;
            --pm-green: #72b88b;
            --pm-green-dark: #3f8f61;
            --pm-cream: #fff8f2;
            --pm-soft: #fff1f6;
            --pm-border: #f4d9e3;
            --pm-text: #243127;
            --pm-muted: #7b827d;
            --pm-card: #ffffff;

            color: var(--pm-text);
        }

        .profile-hero {
            position: relative;
            overflow: hidden;
            border-radius: 30px;
            padding: 30px;
            margin-bottom: 22px;
            background:
                radial-gradient(circle at 9% 14%, rgba(255, 255, 255, .85) 0, rgba(255, 255, 255, 0) 30%),
                linear-gradient(135deg, #ffe5ef 0%, #fff8f2 45%, #e7f6eb 100%);
            border: 1px solid rgba(236, 111, 159, .22);
            box-shadow: 0 18px 45px rgba(210, 98, 137, .13);
        }

        .profile-hero::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 999px;
            right: -80px;
            bottom: -90px;
            background: rgba(236, 111, 159, .13);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 13px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .72);
            color: var(--pm-primary-dark);
            font-weight: 900;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .hero-title {
            margin: 0;
            font-size: clamp(30px, 4vw, 46px);
            line-height: 1.04;
            letter-spacing: -1.5px;
            color: #232a25;
        }

        .hero-title span {
            color: var(--pm-primary-dark);
        }

        .hero-desc {
            max-width: 720px;
            margin: 14px 0 0;
            color: #66706a;
            font-size: 15px;
            line-height: 1.7;
        }

        .hero-avatar {
            flex: 0 0 auto;
            width: 88px;
            height: 88px;
            border-radius: 30px;
            display: grid;
            place-items: center;
            background: rgba(255, 255, 255, .8);
            border: 1px solid rgba(236, 111, 159, .22);
            box-shadow: 0 12px 30px rgba(37, 44, 39, .08);
            font-size: 40px;
        }

        .btn-main,
        .btn-soft,
        .btn-danger,
        .btn-green {
            border: 0;
            outline: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 42px;
            padding: 11px 16px;
            border-radius: 999px;
            font-weight: 900;
            font-size: 13px;
            transition: .2s ease;
            white-space: nowrap;
        }

        .btn-main {
            color: #fff;
            background: linear-gradient(135deg, var(--pm-primary), var(--pm-primary-dark));
            box-shadow: 0 12px 24px rgba(217, 79, 132, .24);
        }

        .btn-green {
            color: #fff;
            background: linear-gradient(135deg, var(--pm-green), var(--pm-green-dark));
            box-shadow: 0 12px 24px rgba(63, 143, 97, .2);
        }

        .btn-soft {
            color: var(--pm-primary-dark);
            background: rgba(255, 255, 255, .85);
            border: 1px solid rgba(236, 111, 159, .2);
        }

        .btn-danger {
            color: #cf325f;
            background: #fff0f4;
            border: 1px solid #ffd3df;
        }

        .btn-main:hover,
        .btn-green:hover {
            transform: translateY(-1px);
        }

        .btn-main:disabled,
        .btn-green:disabled,
        .btn-soft:disabled,
        .btn-danger:disabled {
            opacity: .65;
            cursor: not-allowed;
            transform: none;
        }

        .alert-success,
        .alert-error,
        .alert-info {
            border-radius: 18px;
            padding: 14px 16px;
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .alert-success {
            background: #edf9f0;
            color: #2f7a4d;
            border: 1px solid #ccebd5;
        }

        .alert-error {
            background: #fff0f4;
            color: #c5325d;
            border: 1px solid #ffd4df;
        }

        .alert-info {
            background: #fff8df;
            color: #987021;
            border: 1px solid #f7e7a8;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 22px;
        }

        .summary-card {
            border-radius: 22px;
            background: #fff;
            border: 1px solid #f0e2e6;
            box-shadow: 0 12px 30px rgba(37, 44, 39, .05);
            padding: 18px;
        }

        .summary-icon {
            width: 42px;
            height: 42px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            background: #fff0f6;
            color: var(--pm-primary-dark);
            font-size: 19px;
            margin-bottom: 12px;
        }

        .summary-value {
            font-size: 24px;
            font-weight: 950;
            color: #242c26;
            letter-spacing: -.5px;
            line-height: 1.15;
        }

        .summary-label {
            margin-top: 7px;
            color: var(--pm-muted);
            font-size: 12px;
            font-weight: 800;
        }

        .content-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(340px, .75fr);
            gap: 22px;
            margin-bottom: 22px;
        }

        .content-card {
            border-radius: 26px;
            background: var(--pm-card);
            border: 1px solid #f0e2e6;
            box-shadow: 0 14px 36px rgba(37, 44, 39, .06);
            overflow: hidden;
            margin-bottom: 22px;
        }

        .card-head {
            padding: 22px 24px;
            border-bottom: 1px solid #f3e6ea;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }

        .card-title {
            margin: 0;
            font-size: 20px;
            line-height: 1.2;
            letter-spacing: -.3px;
            color: #242c26;
        }

        .card-subtitle {
            margin: 7px 0 0;
            color: var(--pm-muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .card-body {
            padding: 22px 24px 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .form-group {
            display: grid;
            gap: 7px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-label {
            color: #424b45;
            font-weight: 900;
            font-size: 13px;
        }

        .form-input,
        .form-select {
            width: 100%;
            border: 1px solid #ead8dd;
            background: #fff;
            color: #27302a;
            border-radius: 16px;
            padding: 12px 14px;
            outline: none;
            font-size: 14px;
            transition: .2s ease;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: rgba(236, 111, 159, .75);
            box-shadow: 0 0 0 4px rgba(236, 111, 159, .12);
        }

        .form-error {
            color: #cf325f;
            font-size: 12px;
            font-weight: 800;
        }

        .radio-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .radio-card {
            border-radius: 18px;
            padding: 14px;
            background: #fffafc;
            border: 1px solid #f3dce5;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            cursor: pointer;
        }

        .radio-card input {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            accent-color: var(--pm-primary);
        }

        .radio-card strong {
            display: block;
            color: #242c26;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .radio-card span {
            display: block;
            color: var(--pm-muted);
            font-size: 12px;
            line-height: 1.45;
        }

        .profile-list {
            display: grid;
            gap: 0;
        }

        .profile-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid #f1e3e7;
        }

        .profile-row:last-child {
            border-bottom: 0;
        }

        .profile-label {
            color: var(--pm-muted);
            font-size: 13px;
            font-weight: 800;
        }

        .profile-value {
            color: #242c26;
            font-weight: 950;
            text-align: right;
        }

        .target-card {
            border-radius: 24px;
            background:
                radial-gradient(circle at 15% 10%, rgba(255, 255, 255, .8), transparent 30%),
                linear-gradient(135deg, #edf9f0, #fff8fb);
            border: 1px solid #d9eedf;
            padding: 20px;
            margin-bottom: 18px;
        }

        .target-label {
            color: var(--pm-muted);
            font-size: 13px;
            font-weight: 900;
        }

        .target-value {
            margin-top: 8px;
            color: var(--pm-green-dark);
            font-size: 36px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: -1px;
        }

        .target-unit {
            margin-top: 5px;
            color: var(--pm-muted);
            font-size: 12px;
            font-weight: 800;
        }

        .small-note {
            margin-top: 9px;
            color: var(--pm-muted);
            font-size: 12px;
            line-height: 1.5;
        }

        @media (max-width: 1100px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .profile-hero,
            .card-head,
            .card-body {
                padding: 18px;
            }

            .hero-content {
                flex-direction: column;
            }

            .hero-avatar {
                width: 76px;
                height: 76px;
                border-radius: 26px;
            }

            .summary-grid,
            .form-grid,
            .radio-grid {
                grid-template-columns: 1fr;
            }

            .profile-row {
                align-items: flex-start;
                flex-direction: column;
            }

            .profile-value {
                text-align: left;
            }
        }
    </style>

    <section class="profile-hero">
        <div class="hero-content">
            <div>
                <div class="hero-eyebrow">
                    <span>👤</span>
                    <span>Profil Saya</span>
                </div>

                <h1 class="hero-title">
                    Lengkapi data tubuh
                    <span>untuk kalori harian.</span>
                </h1>

                <p class="hero-desc">
                    Data usia, tinggi badan, berat badan, gender, dan aktivitas digunakan
                    untuk menghitung target kalori harian secara otomatis.
                </p>
            </div>

            <div class="hero-avatar">
                🥗
            </div>
        </div>
    </section>

    @if (session('profile_success'))
        <div class="alert-success">
            {{ session('profile_success') }}
        </div>
    @endif

    @if (session('password_success'))
        <div class="alert-success">
            {{ session('password_success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-error">
            Periksa kembali form. Ada beberapa data yang belum sesuai.
        </div>
    @endif

    @if (! $daily_calorie_target)
        <div class="alert-info">
            Target kalori harian belum tersedia. Lengkapi semua data tubuh lalu klik simpan profil.
        </div>
    @endif

    <section class="summary-grid">
        <div class="summary-card">
            <div class="summary-icon">🔥</div>
            <div class="summary-value">
                {{ $daily_calorie_target ? number_format((int) $daily_calorie_target, 0, ',', '.') : '-' }}
            </div>
            <div class="summary-label">Target kalori</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon">⚖️</div>
            <div class="summary-value">
                {{ $weight_kg ? number_format((float) $weight_kg, 1, ',', '.') . ' kg' : '-' }}
            </div>
            <div class="summary-label">Berat badan</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon">📏</div>
            <div class="summary-value">
                {{ $height_cm ? $height_cm . ' cm' : '-' }}
            </div>
            <div class="summary-label">Tinggi badan</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon">🎂</div>
            <div class="summary-value">
                {{ $age ? $age . ' tahun' : '-' }}
            </div>
            <div class="summary-label">Usia</div>
        </div>
    </section>

    <section class="content-grid">
        <div class="content-card">
            <div class="card-head">
                <div>
                    <h2 class="card-title">Data Profil & Tubuh</h2>
                    <p class="card-subtitle">
                        Ubah data personal dan data tubuh untuk menghitung ulang kalori.
                    </p>
                </div>

                <button type="button" class="btn-soft" wire:click="resetProfileForm">
                    Reset Form
                </button>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="saveProfile">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="name">Nama Lengkap</label>
                            <input
                                id="name"
                                type="text"
                                class="form-input"
                                wire:model="name"
                                placeholder="Nama lengkap"
                            >
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input
                                id="email"
                                type="email"
                                class="form-input"
                                wire:model="email"
                                placeholder="email@example.com"
                            >
                            @error('email')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label class="form-label">Gender</label>

                            <div class="radio-grid">
                                <label class="radio-card">
                                    <input type="radio" value="male" wire:model="gender">
                                    <span>
                                        <strong>Male</strong>
                                        <span>Digunakan untuk rumus BMR pria.</span>
                                    </span>
                                </label>

                                <label class="radio-card">
                                    <input type="radio" value="female" wire:model="gender">
                                    <span>
                                        <strong>Female</strong>
                                        <span>Digunakan untuk rumus BMR wanita.</span>
                                    </span>
                                </label>
                            </div>

                            @error('gender')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="age">Usia</label>
                            <input
                                id="age"
                                type="number"
                                min="10"
                                max="100"
                                class="form-input"
                                wire:model="age"
                                placeholder="Contoh: 21"
                            >
                            @error('age')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="height_cm">Tinggi Badan</label>
                            <input
                                id="height_cm"
                                type="number"
                                min="100"
                                max="250"
                                class="form-input"
                                wire:model="height_cm"
                                placeholder="cm"
                            >
                            @error('height_cm')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="weight_kg">Berat Badan</label>
                            <input
                                id="weight_kg"
                                type="number"
                                min="25"
                                max="300"
                                step="0.1"
                                class="form-input"
                                wire:model="weight_kg"
                                placeholder="kg"
                            >
                            @error('weight_kg')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="activity_level">Aktivitas</label>
                            <select
                                id="activity_level"
                                class="form-select"
                                wire:model="activity_level"
                            >
                                <option value="">Pilih aktivitas</option>
                                @foreach ($activityOptions as $value => $label)
                                    <option value="{{ $value }}">
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('activity_level')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 18px;">
                        <button type="submit" class="btn-main" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="saveProfile">
                                Simpan Profil
                            </span>
                            <span wire:loading wire:target="saveProfile">
                                Menyimpan...
                            </span>
                        </button>

                        <button type="button" class="btn-soft" wire:click="resetProfileForm">
                            Batalkan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <aside>
            <div class="content-card">
                <div class="card-head">
                    <div>
                        <h2 class="card-title">Ringkasan Kalori</h2>
                        <p class="card-subtitle">
                            Target kalori otomatis berdasarkan data tubuh.
                        </p>
                    </div>
                </div>

                <div class="card-body">
                    <div class="target-card">
                        <div class="target-label">Target Kalori Harian</div>
                        <div class="target-value">
                            {{ $daily_calorie_target ? number_format((int) $daily_calorie_target, 0, ',', '.') : '-' }}
                        </div>
                        <div class="target-unit">kkal / hari</div>
                    </div>

                    <div class="profile-list">
                        <div class="profile-row">
                            <span class="profile-label">Nama</span>
                            <span class="profile-value">{{ $name ?: '-' }}</span>
                        </div>

                        <div class="profile-row">
                            <span class="profile-label">Email</span>
                            <span class="profile-value">{{ $email ?: '-' }}</span>
                        </div>

                        <div class="profile-row">
                            <span class="profile-label">Gender</span>
                            <span class="profile-value">
                                @if ($gender === 'male')
                                    Male
                                @elseif ($gender === 'female')
                                    Female
                                @else
                                    -
                                @endif
                            </span>
                        </div>

                        <div class="profile-row">
                            <span class="profile-label">Aktivitas</span>
                            <span class="profile-value">
                                {{ $activity_level && isset($activityOptions[$activity_level]) ? $activityOptions[$activity_level] : '-' }}
                            </span>
                        </div>
                    </div>

                    <p class="small-note">
                        Setelah profil disimpan, dashboard akan memakai target kalori terbaru.
                    </p>
                </div>
            </div>

            <div class="content-card">
                <div class="card-head">
                    <div>
                        <h2 class="card-title">Ubah Password</h2>
                        <p class="card-subtitle">
                            Gunakan password minimal 8 karakter.
                        </p>
                    </div>
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="updatePassword">
                        <div class="form-grid">
                            <div class="form-group full">
                                <label class="form-label" for="current_password">Password Saat Ini</label>
                                <input
                                    id="current_password"
                                    type="password"
                                    class="form-input"
                                    wire:model="current_password"
                                    placeholder="Masukkan password saat ini"
                                >
                                @error('current_password')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group full">
                                <label class="form-label" for="password">Password Baru</label>
                                <input
                                    id="password"
                                    type="password"
                                    class="form-input"
                                    wire:model="password"
                                    placeholder="Minimal 8 karakter"
                                >
                                @error('password')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group full">
                                <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    class="form-input"
                                    wire:model="password_confirmation"
                                    placeholder="Ulangi password baru"
                                >
                            </div>
                        </div>

                        <div style="margin-top: 18px;">
                            <button type="submit" class="btn-green" wire:loading.attr="disabled" style="width: 100%;">
                                <span wire:loading.remove wire:target="updatePassword">
                                    Simpan Password
                                </span>
                                <span wire:loading wire:target="updatePassword">
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </aside>
    </section>
</div>