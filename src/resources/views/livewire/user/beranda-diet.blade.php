<div class="dashboard-page">
    <style>
        .dashboard-page {
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

        .dashboard-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(280px, 0.8fr);
            gap: 22px;
            margin-bottom: 22px;
        }

        .hero-card {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            padding: 30px;
            background:
                radial-gradient(circle at 8% 15%, rgba(255, 255, 255, .9) 0, rgba(255, 255, 255, 0) 30%),
                linear-gradient(135deg, #ffe5ef 0%, #fff8f2 42%, #e7f6eb 100%);
            border: 1px solid rgba(236, 111, 159, .22);
            box-shadow: 0 18px 45px rgba(210, 98, 137, .13);
        }

        .hero-card::after {
            content: "";
            position: absolute;
            width: 190px;
            height: 190px;
            border-radius: 999px;
            right: -60px;
            bottom: -70px;
            background: rgba(236, 111, 159, .13);
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 13px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .7);
            color: var(--pm-primary-dark);
            font-weight: 800;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .hero-title {
            position: relative;
            z-index: 1;
            font-size: clamp(30px, 4vw, 48px);
            line-height: 1.02;
            letter-spacing: -1.6px;
            margin: 0;
            color: #232a25;
        }

        .hero-title span {
            color: var(--pm-primary-dark);
        }

        .hero-desc {
            position: relative;
            z-index: 1;
            max-width: 690px;
            margin: 16px 0 0;
            color: #66706a;
            font-size: 15px;
            line-height: 1.7;
        }

        .hero-actions {
            position: relative;
            z-index: 1;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 22px;
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
            font-weight: 800;
            font-size: 13px;
            transition: .2s ease;
        }

        .btn-main {
            color: #fff;
            background: linear-gradient(135deg, var(--pm-primary), var(--pm-primary-dark));
            box-shadow: 0 12px 24px rgba(217, 79, 132, .24);
        }

        .btn-main:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 30px rgba(217, 79, 132, .3);
        }

        .btn-green {
            color: #fff;
            background: linear-gradient(135deg, var(--pm-green), var(--pm-green-dark));
            box-shadow: 0 12px 24px rgba(63, 143, 97, .2);
        }

        .btn-soft {
            color: var(--pm-primary-dark);
            background: rgba(255, 255, 255, .82);
            border: 1px solid rgba(236, 111, 159, .2);
        }

        .btn-danger {
            color: #cf325f;
            background: #fff0f4;
            border: 1px solid #ffd3df;
        }

        .btn-main:disabled,
        .btn-green:disabled,
        .btn-soft:disabled,
        .btn-danger:disabled {
            opacity: .65;
            cursor: not-allowed;
            transform: none;
        }

        .calorie-card {
            border-radius: 28px;
            padding: 24px;
            background: #fff;
            border: 1px solid rgba(114, 184, 139, .22);
            box-shadow: 0 18px 45px rgba(63, 143, 97, .11);
        }

        .calorie-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 18px;
        }

        .calorie-label {
            color: var(--pm-muted);
            font-size: 13px;
            font-weight: 700;
        }

        .calorie-value {
            font-size: 36px;
            line-height: 1;
            letter-spacing: -1px;
            font-weight: 900;
            color: var(--pm-green-dark);
            margin-top: 6px;
        }

        .calorie-unit {
            font-size: 13px;
            color: var(--pm-muted);
            font-weight: 800;
            margin-top: 4px;
        }

        .calorie-icon {
            width: 54px;
            height: 54px;
            border-radius: 20px;
            display: grid;
            place-items: center;
            background: #edf9f0;
            color: var(--pm-green-dark);
            font-size: 24px;
        }

        .progress-wrap {
            width: 100%;
            height: 14px;
            border-radius: 999px;
            overflow: hidden;
            background: #eef5ef;
            margin-top: 14px;
        }

        .progress-bar {
            height: 100%;
            width: {{ $persentaseKalori }}%;
            border-radius: inherit;
            background: linear-gradient(90deg, var(--pm-green), var(--pm-primary));
        }

        .calorie-meta {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-top: 18px;
        }

        .mini-stat {
            padding: 13px;
            border-radius: 18px;
            background: #fff8fb;
            border: 1px solid #f5dce6;
        }

        .mini-stat strong {
            display: block;
            font-size: 18px;
            color: #242c26;
            margin-bottom: 3px;
        }

        .mini-stat span {
            color: var(--pm-muted);
            font-size: 12px;
            font-weight: 700;
        }

        .section-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.25fr) minmax(320px, .75fr);
            gap: 22px;
            margin-bottom: 22px;
        }

        .content-card {
            border-radius: 26px;
            background: var(--pm-card);
            border: 1px solid #f0e2e6;
            box-shadow: 0 14px 36px rgba(37, 44, 39, .06);
            overflow: hidden;
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

        .alert-success,
        .alert-error,
        .alert-warning {
            border-radius: 18px;
            padding: 14px 16px;
            font-size: 13px;
            font-weight: 700;
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

        .alert-warning {
            background: #fff8df;
            color: #987021;
            border: 1px solid #f7e7a8;
        }

        .meal-list {
            display: grid;
            gap: 12px;
        }

        .meal-item {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 16px;
            align-items: center;
            padding: 16px;
            border-radius: 20px;
            background: #fffafc;
            border: 1px solid #f4dfe7;
        }

        .meal-info {
            display: flex;
            align-items: flex-start;
            gap: 13px;
        }

        .meal-icon {
            flex: 0 0 auto;
            width: 42px;
            height: 42px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            background: #fff0f6;
            color: var(--pm-primary-dark);
            font-size: 18px;
        }

        .meal-name {
            margin: 0;
            font-weight: 900;
            color: #232b25;
        }

        .meal-detail {
            margin-top: 5px;
            color: var(--pm-muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .meal-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-top: 9px;
        }

        .tag {
            display: inline-flex;
            align-items: center;
            padding: 5px 9px;
            border-radius: 999px;
            background: #f5faf6;
            border: 1px solid #dbeee1;
            color: #4c7f5e;
            font-weight: 800;
            font-size: 11px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border-radius: 999px;
            padding: 8px 11px;
            font-weight: 900;
            font-size: 12px;
            white-space: nowrap;
        }

        .status-done {
            background: #edf9f0;
            color: #2e7a4e;
            border: 1px solid #caebd3;
        }

        .status-plan {
            background: #fff4f8;
            color: #c74c7a;
            border: 1px solid #ffd7e4;
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
        .form-select,
        .form-textarea {
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

        .form-textarea {
            min-height: 96px;
            resize: vertical;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: rgba(236, 111, 159, .75);
            box-shadow: 0 0 0 4px rgba(236, 111, 159, .12);
        }

        .form-error {
            color: #cf325f;
            font-size: 12px;
            font-weight: 700;
        }

        .profile-grid {
            display: grid;
            gap: 12px;
        }

        .profile-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 13px 0;
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
            font-weight: 900;
            text-align: right;
        }

        .recommendation-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .menu-card {
            display: flex;
            flex-direction: column;
            min-height: 100%;
            border-radius: 24px;
            background: #fff;
            border: 1px solid #f0dfe5;
            box-shadow: 0 12px 28px rgba(37, 44, 39, .05);
            overflow: hidden;
        }

        .menu-visual {
            height: 118px;
            background:
                radial-gradient(circle at 25% 30%, rgba(255, 255, 255, .8), transparent 25%),
                linear-gradient(135deg, #ffe1ec, #ecf8ee);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
        }

        .menu-content {
            padding: 17px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .menu-name {
            margin: 0;
            font-size: 16px;
            font-weight: 900;
            color: #242c26;
            line-height: 1.35;
        }

        .menu-desc {
            margin: 8px 0 0;
            color: var(--pm-muted);
            font-size: 13px;
            line-height: 1.55;
            flex: 1;
        }

        .menu-nutrition {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            margin: 14px 0;
        }

        .nutrition-box {
            border-radius: 14px;
            background: #fff8fb;
            border: 1px solid #f4dfe7;
            padding: 9px;
        }

        .nutrition-box strong {
            display: block;
            font-size: 14px;
            color: #242c26;
        }

        .nutrition-box span {
            display: block;
            margin-top: 2px;
            font-size: 11px;
            font-weight: 800;
            color: var(--pm-muted);
        }

        .empty-state {
            text-align: center;
            padding: 34px 16px;
            border-radius: 22px;
            background: #fffafc;
            border: 1px dashed #e9ccd6;
        }

        .empty-icon {
            width: 58px;
            height: 58px;
            border-radius: 22px;
            margin: 0 auto 13px;
            display: grid;
            place-items: center;
            background: #fff0f6;
            color: var(--pm-primary-dark);
            font-size: 27px;
        }

        .empty-state h4 {
            margin: 0;
            color: #242c26;
            font-size: 16px;
        }

        .empty-state p {
            margin: 8px auto 0;
            max-width: 420px;
            color: var(--pm-muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .small-note {
            margin-top: 10px;
            color: var(--pm-muted);
            font-size: 12px;
            line-height: 1.5;
        }

        @media (max-width: 1100px) {
            .dashboard-hero,
            .section-grid {
                grid-template-columns: 1fr;
            }

            .recommendation-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .hero-card,
            .calorie-card,
            .card-head,
            .card-body {
                padding: 18px;
            }

            .recommendation-grid,
            .form-grid {
                grid-template-columns: 1fr;
            }

            .meal-item {
                grid-template-columns: 1fr;
            }

            .meal-item .btn-soft,
            .meal-item .btn-danger {
                width: 100%;
            }

            .hero-actions {
                flex-direction: column;
            }

            .hero-actions .btn-main,
            .hero-actions .btn-soft {
                width: 100%;
            }

            .calorie-meta {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <section class="dashboard-hero">
        <div class="hero-card">
            <div class="hero-eyebrow">
                <span>🥗</span>
                <span>{{ $tanggalHariIni ?: now()->translatedFormat('l, d F Y') }}</span>
            </div>

            <h1 class="hero-title">
                Jaga pola makanmu,
                <span>mulai dari hari ini.</span>
            </h1>

            <p class="hero-desc">
                Pantau target kalori harian, jadwal makan, catatan makanan tambahan,
                dan rekomendasi menu sehat dalam satu dashboard yang rapi.
            </p>

            <div class="hero-actions">
                <a href="{{ route('user.meal-plan') }}" class="btn-main">
                    <span>🍽️</span>
                    <span>Buka Meal Plan</span>
                </a>

                <a href="{{ route('user.makanan') }}" class="btn-soft">
                    <span>🥬</span>
                    <span>Kelola Makanan</span>
                </a>
            </div>
        </div>

        <aside class="calorie-card">
            <div class="calorie-top">
                <div>
                    <div class="calorie-label">Target kalori harian</div>
                    <div class="calorie-value">
                        {{ number_format($targetKalori, 0, ',', '.') }}
                    </div>
                    <div class="calorie-unit">kkal / hari</div>
                </div>

                <div class="calorie-icon">
                    🔥
                </div>
            </div>

            <div class="progress-wrap">
                <div class="progress-bar"></div>
            </div>

            <p class="small-note">
                {{ $persentaseKalori }}% dari target harian sudah tercatat.
            </p>

            <div class="calorie-meta">
                <div class="mini-stat">
                    <strong>{{ number_format($kaloriMasuk, 0, ',', '.') }}</strong>
                    <span>Kalori masuk</span>
                </div>

                <div class="mini-stat">
                    <strong>{{ number_format($sisaKalori, 0, ',', '.') }}</strong>
                    <span>Sisa kalori</span>
                </div>

                <div class="mini-stat">
                    <strong>{{ number_format($proteinMasuk, 1, ',', '.') }}g</strong>
                    <span>Protein</span>
                </div>

                <div class="mini-stat">
                    <strong>{{ number_format($karboMasuk, 1, ',', '.') }}g</strong>
                    <span>Karbohidrat</span>
                </div>
            </div>
        </aside>
    </section>

    @if (session('dashboard_success'))
        <div class="alert-success">
            {{ session('dashboard_success') }}
        </div>
    @endif

    @if (session('dashboard_error'))
        <div class="alert-error">
            {{ session('dashboard_error') }}
        </div>
    @endif

    @if (! $dataTubuhLengkap)
        <div class="alert-warning">
            Data tubuh kamu belum lengkap. Lengkapi profil agar target kalori harian bisa dihitung otomatis.
            <a href="{{ route('user.profil') }}" style="color: inherit; font-weight: 900; text-decoration: underline;">
                Lengkapi profil
            </a>
        </div>
    @endif

    <section class="section-grid">
        <div class="content-card">
            <div class="card-head">
                <div>
                    <h2 class="card-title">Jadwal Makan Hari Ini</h2>
                    <p class="card-subtitle">
                        Menu dari meal plan yang sudah kamu susun untuk hari ini.
                    </p>
                </div>
            </div>

            <div class="card-body">
                @if (count($jadwalMakanHariIni) > 0)
                    <div class="meal-list">
                        @foreach ($jadwalMakanHariIni as $item)
                            <div class="meal-item" wire:key="meal-plan-item-{{ $item['id'] ?? $loop->index }}">
                                <div class="meal-info">
                                    <div class="meal-icon">
                                        @php
                                            $mealKey = $item['waktu_makan'] ?? $item['meal_time'] ?? 'sarapan';
                                        @endphp

                                        @if ($mealKey === 'sarapan')
                                            🌤️
                                        @elseif ($mealKey === 'makan_siang')
                                            ☀️
                                        @elseif ($mealKey === 'makan_malam')
                                            🌙
                                        @else
                                            🍓
                                        @endif
                                    </div>

                                    <div>
                                        <p class="meal-name">
                                            {{ $item['nama_makanan'] ?? $item['nama'] ?? 'Menu tanpa nama' }}
                                        </p>

                                        <div class="meal-detail">
                                            {{ $item['waktu_makan_label'] ?? $item['meal_time'] ?? 'Waktu makan' }}
                                            · {{ number_format((float) ($item['porsi'] ?? 1), 1, ',', '.') }} porsi
                                            · {{ number_format((float) ($item['kalori'] ?? 0), 0, ',', '.') }} kkal
                                        </div>

                                        <div class="meal-tags">
                                            <span class="tag">
                                                Protein {{ number_format((float) ($item['protein'] ?? 0), 1, ',', '.') }}g
                                            </span>
                                            <span class="tag">
                                                Karbo {{ number_format((float) ($item['karbohidrat'] ?? $item['karbo'] ?? 0), 1, ',', '.') }}g
                                            </span>
                                            <span class="tag">
                                                Lemak {{ number_format((float) ($item['lemak'] ?? 0), 1, ',', '.') }}g
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <button
                                        type="button"
                                        wire:click="toggleMealPlanItemConsumed({{ (int) ($item['id'] ?? 0) }})"
                                        class="status-pill {{ ! empty($item['is_consumed']) ? 'status-done' : 'status-plan' }}"
                                    >
                                        @if (! empty($item['is_consumed']))
                                            <span>✅</span>
                                            <span>Sudah dimakan</span>
                                        @else
                                            <span>⏳</span>
                                            <span>Belum dimakan</span>
                                        @endif
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">🍽️</div>
                        <h4>Belum ada jadwal makan hari ini</h4>
                        <p>
                            Tambahkan menu dari halaman Meal Plan atau pilih menu rekomendasi di bagian bawah dashboard.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <aside class="content-card">
            <div class="card-head">
                <div>
                    <h2 class="card-title">Data Tubuh</h2>
                    <p class="card-subtitle">
                        Ringkasan data dasar untuk perhitungan kalori.
                    </p>
                </div>
            </div>

            <div class="card-body">
                <div class="profile-grid">
                    <div class="profile-row">
                        <span class="profile-label">Gender</span>
                        <span class="profile-value">
                            {{ $dataTubuh['gender_label'] ?? $dataTubuh['gender'] ?? '-' }}
                        </span>
                    </div>

                    <div class="profile-row">
                        <span class="profile-label">Usia</span>
                        <span class="profile-value">
                            @if (! empty($dataTubuh['age']))
                                {{ $dataTubuh['age'] }} tahun
                            @elseif (! empty($dataTubuh['usia']))
                                {{ $dataTubuh['usia'] }} tahun
                            @else
                                -
                            @endif
                        </span>
                    </div>

                    <div class="profile-row">
                        <span class="profile-label">Tinggi</span>
                        <span class="profile-value">
                            @if (! empty($dataTubuh['height_cm']))
                                {{ $dataTubuh['height_cm'] }} cm
                            @elseif (! empty($dataTubuh['tinggi']))
                                {{ $dataTubuh['tinggi'] }} cm
                            @else
                                -
                            @endif
                        </span>
                    </div>

                    <div class="profile-row">
                        <span class="profile-label">Berat</span>
                        <span class="profile-value">
                            @if (! empty($dataTubuh['weight_kg']))
                                {{ number_format((float) $dataTubuh['weight_kg'], 1, ',', '.') }} kg
                            @elseif (! empty($dataTubuh['berat']))
                                {{ number_format((float) $dataTubuh['berat'], 1, ',', '.') }} kg
                            @else
                                -
                            @endif
                        </span>
                    </div>

                    <div class="profile-row">
                        <span class="profile-label">Aktivitas</span>
                        <span class="profile-value">
                            {{ $dataTubuh['activity_level_label'] ?? $dataTubuh['activity_label'] ?? $dataTubuh['aktivitas'] ?? '-' }}
                        </span>
                    </div>
                </div>

                <div style="margin-top: 18px;">
                    <a href="{{ route('user.profil') }}" class="btn-soft" style="width: 100%;">
                        Edit Profil
                    </a>
                </div>
            </div>
        </aside>
    </section>

    <section class="section-grid">
        <div class="content-card">
            <div class="card-head">
                <div>
                    <h2 class="card-title">Catatan Makanan Tambahan</h2>
                    <p class="card-subtitle">
                        Catat makanan yang kamu konsumsi di luar meal plan.
                    </p>
                </div>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="addCatatanMakananHarian">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="extra_food_date">Tanggal</label>
                            <input
                                id="extra_food_date"
                                type="date"
                                class="form-input"
                                wire:model="extra_food_date"
                            >
                            @error('extra_food_date')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="extra_meal_time">Waktu Makan</label>
                            <select
                                id="extra_meal_time"
                                class="form-select"
                                wire:model="extra_meal_time"
                            >
                                @foreach ($mealTimeOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('extra_meal_time')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label class="form-label" for="extra_food_name">Nama Makanan</label>
                            <input
                                id="extra_food_name"
                                type="text"
                                class="form-input"
                                placeholder="Contoh: Roti gandum, susu rendah lemak"
                                wire:model="extra_food_name"
                            >
                            @error('extra_food_name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="extra_porsi">Porsi</label>
                            <input
                                id="extra_porsi"
                                type="number"
                                step="0.1"
                                min="0.1"
                                class="form-input"
                                wire:model="extra_porsi"
                            >
                            @error('extra_porsi')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="extra_calories">Kalori / Porsi</label>
                            <input
                                id="extra_calories"
                                type="number"
                                min="0"
                                class="form-input"
                                placeholder="Contoh: 250"
                                wire:model="extra_calories"
                            >
                            @error('extra_calories')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="extra_protein">Protein / Porsi</label>
                            <input
                                id="extra_protein"
                                type="number"
                                step="0.1"
                                min="0"
                                class="form-input"
                                placeholder="gram"
                                wire:model="extra_protein"
                            >
                            @error('extra_protein')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="extra_karbohidrat">Karbohidrat / Porsi</label>
                            <input
                                id="extra_karbohidrat"
                                type="number"
                                step="0.1"
                                min="0"
                                class="form-input"
                                placeholder="gram"
                                wire:model="extra_karbohidrat"
                            >
                            @error('extra_karbohidrat')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="extra_lemak">Lemak / Porsi</label>
                            <input
                                id="extra_lemak"
                                type="number"
                                step="0.1"
                                min="0"
                                class="form-input"
                                placeholder="gram"
                                wire:model="extra_lemak"
                            >
                            @error('extra_lemak')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label class="form-label" for="extra_catatan">Catatan</label>
                            <textarea
                                id="extra_catatan"
                                class="form-textarea"
                                placeholder="Opsional, contoh: dimakan setelah olahraga"
                                wire:model="extra_catatan"
                            ></textarea>
                            @error('extra_catatan')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-top: 16px;">
                        <button type="submit" class="btn-main" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="addCatatanMakananHarian">Simpan Catatan</span>
                            <span wire:loading wire:target="addCatatanMakananHarian">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <aside class="content-card">
            <div class="card-head">
                <div>
                    <h2 class="card-title">Riwayat Hari Ini</h2>
                    <p class="card-subtitle">
                        Catatan konsumsi manual yang masuk ke total kalori.
                    </p>
                </div>
            </div>

            <div class="card-body">
                @if (count($catatanMakananHariIni) > 0)
                    <div class="meal-list">
                        @foreach ($catatanMakananHariIni as $catatan)
                            <div class="meal-item" wire:key="catatan-makanan-{{ $catatan['id'] ?? $loop->index }}">
                                <div class="meal-info">
                                    <div class="meal-icon">📝</div>

                                    <div>
                                        <p class="meal-name">
                                            {{ $catatan['nama_makanan'] ?? $catatan['nama'] ?? 'Makanan tambahan' }}
                                        </p>

                                        <div class="meal-detail">
                                            {{ $catatan['waktu_makan_label'] ?? $catatan['meal_time'] ?? 'Waktu makan' }}
                                            · {{ number_format((float) ($catatan['porsi'] ?? 1), 1, ',', '.') }} porsi
                                            · {{ number_format((float) ($catatan['kalori'] ?? 0), 0, ',', '.') }} kkal
                                        </div>

                                        @if (! empty($catatan['catatan']))
                                            <div class="small-note">
                                                {{ $catatan['catatan'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    class="btn-danger"
                                    wire:click="deleteCatatanMakananHarian({{ (int) ($catatan['id'] ?? 0) }})"
                                    wire:confirm="Hapus catatan makanan ini?"
                                >
                                    Hapus
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">📝</div>
                        <h4>Belum ada catatan tambahan</h4>
                        <p>
                            Catatan makanan tambahan yang kamu simpan hari ini akan muncul di sini.
                        </p>
                    </div>
                @endif
            </div>
        </aside>
    </section>

    <section class="content-card">
        <div class="card-head">
            <div>
                <h2 class="card-title">Rekomendasi Menu Sehat</h2>
                <p class="card-subtitle">
                    Pilih menu rekomendasi dan tambahkan langsung ke meal plan.
                </p>
            </div>
        </div>

        <div class="card-body">
            <div style="margin-bottom: 18px;">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="selectedMealPlanDate">Tanggal Meal Plan</label>
                        <input
                            id="selectedMealPlanDate"
                            type="date"
                            class="form-input"
                            wire:model="selectedMealPlanDate"
                        >
                        @error('selectedMealPlanDate')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="selectedMealTime">Waktu Makan</label>
                        <select
                            id="selectedMealTime"
                            class="form-select"
                            wire:model="selectedMealTime"
                        >
                            @foreach ($mealTimeOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('selectedMealTime')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            @if (count($rekomendasiMenu) > 0)
                <div class="recommendation-grid">
                    @foreach ($rekomendasiMenu as $menu)
                        <article class="menu-card" wire:key="rekomendasi-menu-{{ $menu['id'] ?? $loop->index }}">
                            <div class="menu-visual">
                                🥗
                            </div>

                            <div class="menu-content">
                                <h3 class="menu-name">
                                    {{ $menu['nama_makanan'] ?? $menu['nama'] ?? 'Menu sehat' }}
                                </h3>

                                <p class="menu-desc">
                                    {{ $menu['deskripsi'] ?? $menu['recommended_note'] ?? 'Menu sehat yang bisa dimasukkan ke meal plan.' }}
                                </p>

                                <div class="menu-nutrition">
                                    <div class="nutrition-box">
                                        <strong>{{ number_format((float) ($menu['kalori'] ?? 0), 0, ',', '.') }}</strong>
                                        <span>Kalori</span>
                                    </div>

                                    <div class="nutrition-box">
                                        <strong>{{ number_format((float) ($menu['protein'] ?? 0), 1, ',', '.') }}g</strong>
                                        <span>Protein</span>
                                    </div>

                                    <div class="nutrition-box">
                                        <strong>{{ number_format((float) ($menu['karbohidrat'] ?? $menu['karbo'] ?? 0), 1, ',', '.') }}g</strong>
                                        <span>Karbo</span>
                                    </div>

                                    <div class="nutrition-box">
                                        <strong>{{ number_format((float) ($menu['lemak'] ?? 0), 1, ',', '.') }}g</strong>
                                        <span>Lemak</span>
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    class="btn-green"
                                    wire:click="addRekomendasiToMealPlan({{ (int) ($menu['id'] ?? 0) }})"
                                    wire:loading.attr="disabled"
                                    style="width: 100%;"
                                >
                                    Tambah ke Meal Plan
                                </button>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">🥗</div>
                    <h4>Belum ada rekomendasi menu</h4>
                    <p>
                        Tambahkan data makanan dari panel admin atau halaman makanan,
                        lalu tandai sebagai rekomendasi agar muncul di dashboard.
                    </p>
                </div>
            @endif
        </div>
    </section>
</div>