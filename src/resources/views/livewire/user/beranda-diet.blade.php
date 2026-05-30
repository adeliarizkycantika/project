<div>
    @php
        $target = max(1, (int) ($targetKalori ?? 0));
        $kalori = (int) ($kaloriMasuk ?? 0);
        $sisa = $target - $kalori;

        $progressPercent = min(100, round(($kalori / $target) * 100));
        $isOverTarget = $sisa < 0;

        $statusAmount = $isOverTarget
            ? 'Kelebihan ' . number_format(abs($sisa)) . ' kalori'
            : 'Sisa ' . number_format($sisa) . ' kalori';

        $statusCardClass = $isOverTarget ? 'cute-status-danger' : 'cute-status-success';
        $progressColor = $isOverTarget ? '#fb7185' : '#22c55e';

        $todayItems = collect($mealPlans ?? [])
            ->flatMap(fn ($mealPlan) => $mealPlan->items ?? collect());

        $hasItems = $todayItems->isNotEmpty();
    @endphp

    <style>
        .cute-dashboard {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 330px;
            gap: 24px;
        }

        .cute-main {
            min-width: 0;
        }

        .cute-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 24px;
        }

        .cute-title {
            margin: 0;
            font-size: 36px;
            line-height: 1.1;
            font-weight: 950;
            color: #111827;
            letter-spacing: -0.05em;
        }

        .cute-subtitle {
            margin: 10px 0 0;
            color: #64748b;
            font-size: 16px;
            font-weight: 650;
        }

        .cute-mini-date {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid rgba(244, 114, 182, 0.18);
            color: #475569;
            font-size: 14px;
            font-weight: 900;
            box-shadow: 0 16px 32px rgba(244, 114, 182, 0.08);
            white-space: nowrap;
        }

        .cute-top-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 22px;
        }

        .cute-card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(244, 114, 182, 0.18);
            border-radius: 26px;
            box-shadow: 0 18px 42px rgba(244, 114, 182, 0.10);
        }

        .cute-summary-card {
            position: relative;
            min-height: 188px;
            padding: 22px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .cute-summary-card::after {
            content: "";
            position: absolute;
            right: -38px;
            bottom: -38px;
            width: 110px;
            height: 110px;
            border-radius: 999px;
            background: rgba(252, 231, 243, 0.55);
            z-index: 0;
        }

        .cute-summary-content {
            position: relative;
            z-index: 2;
            padding-right: 8px;
            padding-bottom: 58px;
        }

        .cute-summary-label {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            line-height: 1.3;
            font-weight: 950;
        }

        .cute-summary-value {
            margin: 18px 0 0;
            color: #111827;
            font-size: 38px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -0.05em;
        }

        .cute-summary-value.status-value {
            margin-top: 16px;
            max-width: 190px;
            font-size: 27px;
            line-height: 1.08;
            letter-spacing: -0.04em;
        }

        .cute-summary-unit {
            margin: 8px 0 0;
            color: #64748b;
            font-size: 14px;
            font-weight: 850;
        }

        .cute-summary-desc {
            max-width: 150px;
            margin: 12px 0 0;
            color: #334155;
            font-size: 14px;
            line-height: 1.35;
            font-weight: 850;
        }

        .cute-summary-icon {
            position: absolute;
            right: 18px;
            bottom: 18px;
            width: 48px;
            height: 48px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            background: #fce7f3;
            z-index: 3;
        }

        .cute-summary-card.target {
            background: linear-gradient(135deg, #ffffff 0%, #fff7fb 100%);
        }

        .cute-summary-card.intake {
            background: linear-gradient(135deg, #ffffff 0%, #fff7ed 100%);
        }

        .cute-summary-card.remaining {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        }

        .cute-status-success {
            background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
            border-color: #bbf7d0;
        }

        .cute-status-danger {
            background: linear-gradient(135deg, #fff1f2 0%, #ffffff 100%);
            border-color: #fecdd3;
        }

        .cute-status-success .status-value {
            color: #16a34a;
        }

        .cute-status-danger .status-value {
            color: #dc2626;
        }

        .cute-status-success .cute-summary-icon {
            background: #dcfce7;
        }

        .cute-status-danger .cute-summary-icon {
            background: #fee2e2;
        }

        .cute-progress-card {
            padding: 22px;
            margin-bottom: 22px;
        }

        .cute-section-title {
            margin: 0;
            font-size: 22px;
            font-weight: 950;
            color: #111827;
            letter-spacing: -0.03em;
        }

        .cute-section-subtitle {
            margin: 8px 0 0;
            color: #64748b;
            font-size: 14px;
            font-weight: 650;
        }

        .cute-progress-track {
            height: 14px;
            border-radius: 999px;
            background: #f1f5f9;
            overflow: hidden;
            margin-top: 20px;
        }

        .cute-progress-bar {
            width: {{ $progressPercent }}%;
            height: 100%;
            border-radius: 999px;
            background: {{ $progressColor }};
            transition: width 0.25s ease;
        }

        .cute-progress-info {
            display: flex;
            justify-content: space-between;
            margin-top: 12px;
            color: #334155;
            font-size: 14px;
            font-weight: 850;
        }

        .cute-progress-warning {
            margin-top: 12px;
            color: {{ $isOverTarget ? '#dc2626' : '#16a34a' }};
            font-weight: 950;
            font-size: 14px;
        }

        .cute-table-card {
            overflow: hidden;
            margin-bottom: 22px;
        }

        .cute-table-header {
            padding: 22px;
            border-bottom: 1px solid rgba(244, 114, 182, 0.14);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
        }

        .cute-table-wrapper {
            overflow-x: auto;
        }

        .cute-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 740px;
        }

        .cute-table th {
            padding: 14px 18px;
            background: #fff7fb;
            border-bottom: 1px solid rgba(244, 114, 182, 0.14);
            color: #475569;
            font-size: 13px;
            font-weight: 950;
            text-align: left;
        }

        .cute-table td {
            padding: 16px 18px;
            border-bottom: 1px solid rgba(244, 114, 182, 0.10);
            color: #111827;
            font-size: 14px;
            font-weight: 700;
        }

        .cute-table tr:last-child td {
            border-bottom: none;
        }

        .meal-type {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .meal-icon {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fce7f3;
        }

        .meal-name {
            font-weight: 950;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 950;
        }

        .status-done {
            background: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background: #fee2e2;
            color: #dc2626;
        }

        .cute-action-button {
            border: none;
            border-radius: 13px;
            min-height: 38px;
            padding: 0 13px;
            font-size: 13px;
            font-weight: 950;
            cursor: pointer;
        }

        .cute-action-success {
            background: #22c55e;
            color: #ffffff;
        }

        .cute-action-danger {
            background: #fee2e2;
            color: #dc2626;
        }

        .cute-side {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .cute-side-card {
            padding: 22px;
        }

        .donut-row {
            display: flex;
            gap: 18px;
            align-items: center;
            margin-top: 18px;
        }

        .donut {
            width: 126px;
            height: 126px;
            border-radius: 999px;
            background: conic-gradient({{ $progressColor }} {{ $progressPercent }}%, #f1f5f9 0);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .donut-inner {
            width: 78px;
            height: 78px;
            border-radius: 999px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            color: #111827;
            font-weight: 950;
        }

        .donut-inner span {
            margin-top: 2px;
            color: #64748b;
            font-size: 12px;
            font-weight: 800;
        }

        .legend-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .legend-item {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            color: #334155;
            font-size: 13px;
            font-weight: 750;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            margin-top: 4px;
            border-radius: 999px;
            flex-shrink: 0;
        }

        .dot-green {
            background: #22c55e;
        }

        .dot-pink {
            background: #f472b6;
        }

        .dot-gray {
            background: #cbd5e1;
        }

        .water-row {
            display: flex;
            justify-content: center;
            align-items: end;
            gap: 8px;
            margin-top: 18px;
            flex-wrap: nowrap;
        }

        .water-glass {
            position: relative;
            width: 24px;
            height: 42px;
            border-radius: 7px 7px 12px 12px;
            border: 2px solid #bfdbfe;
            background: #ffffff;
            overflow: hidden;
            box-shadow: 0 6px 14px rgba(14, 165, 233, 0.12);
            flex: 0 0 24px;
        }

        .water-glass::before {
            content: "";
            position: absolute;
            left: 3px;
            right: 3px;
            bottom: 3px;
            height: 28px;
            border-radius: 5px 5px 9px 9px;
            background: linear-gradient(180deg, #7dd3fc 0%, #38bdf8 100%);
        }

        .water-glass::after {
            content: "";
            position: absolute;
            left: 6px;
            top: 6px;
            width: 5px;
            height: 22px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.55);
        }

        .water-glass.empty {
            border-color: #e2e8f0;
            background: #ffffff;
            box-shadow: none;
            opacity: 0.75;
        }

        .water-glass.empty::before {
            height: 0;
            background: transparent;
        }

        .water-glass.empty::after {
            background: #f1f5f9;
        }

        .tips-box {
            margin-top: 16px;
            padding: 16px;
            border-radius: 20px;
            background: #fff1f7;
            border: 1px solid #fbcfe8;
            color: #831843;
            line-height: 1.55;
            font-size: 14px;
            font-weight: 750;
        }

        .empty-dashboard {
            padding: 38px 24px;
            text-align: center;
        }

        .empty-dashboard-title {
            margin: 0;
            color: #111827;
            font-size: 20px;
            font-weight: 950;
        }

        .empty-dashboard-text {
            margin: 8px 0 18px;
            color: #64748b;
            font-weight: 650;
        }

        .quick-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 16px;
        }

        @media (max-width: 1280px) {
            .cute-dashboard {
                grid-template-columns: 1fr;
            }

            .cute-side {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .cute-top-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .cute-side {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 720px) {
            .cute-header {
                flex-direction: column;
            }

            .cute-top-grid {
                grid-template-columns: 1fr;
            }

            .cute-title {
                font-size: 30px;
            }

            .cute-summary-card {
                min-height: 170px;
            }

            .cute-summary-content {
                padding-bottom: 48px;
            }

            .cute-summary-value {
                font-size: 34px;
            }

            .cute-summary-value.status-value {
                font-size: 26px;
            }

            .water-row {
                gap: 6px;
            }

            .water-glass {
                width: 22px;
                height: 39px;
                flex-basis: 22px;
            }
        }
    </style>

    <div class="cute-dashboard">
        <main class="cute-main">
            <div class="cute-header">
                <div>
                    <h1 class="cute-title">
                        Hai, {{ auth()->user()?->name ?? 'User' }} 👋
                    </h1>

                    <p class="cute-subtitle">
                        Semangat untuk pola makan sehat hari ini!
                    </p>
                </div>

                <div class="cute-mini-date">
                    🗓️ {{ $tanggalHariIni }}
                </div>
            </div>

            <div class="cute-top-grid">
                <div class="cute-card cute-summary-card {{ $statusCardClass }}">
                    <div class="cute-summary-content">
                        <p class="cute-summary-label">
                            Status Diet Hari Ini
                        </p>

                        <div class="cute-summary-value status-value">
                            {{ $statusDiet }}
                        </div>

                        <p class="cute-summary-desc">
                            {{ $statusAmount }}
                        </p>
                    </div>

                    <div class="cute-summary-icon">
                        {{ $isOverTarget ? '☹️' : '😊' }}
                    </div>
                </div>

                <div class="cute-card cute-summary-card target">
                    <div class="cute-summary-content">
                        <p class="cute-summary-label">
                            Target Kalori
                        </p>

                        <div class="cute-summary-value">
                            {{ number_format($targetKalori) }}
                        </div>

                        <p class="cute-summary-unit">
                            kalori
                        </p>
                    </div>

                    <div class="cute-summary-icon">
                        🎯
                    </div>
                </div>

                <div class="cute-card cute-summary-card intake">
                    <div class="cute-summary-content">
                        <p class="cute-summary-label">
                            Kalori Masuk
                        </p>

                        <div class="cute-summary-value">
                            {{ number_format($kaloriMasuk) }}
                        </div>

                        <p class="cute-summary-unit">
                            kalori
                        </p>
                    </div>

                    <div class="cute-summary-icon">
                        🔥
                    </div>
                </div>

                <div class="cute-card cute-summary-card remaining">
                    <div class="cute-summary-content">
                        <p class="cute-summary-label">
                            Sisa Kalori
                        </p>

                        <div
                            class="cute-summary-value"
                            style="color: {{ $isOverTarget ? '#dc2626' : '#111827' }};"
                        >
                            {{ $isOverTarget ? '-' . number_format(abs($sisa)) : number_format($sisa) }}
                        </div>

                        <p class="cute-summary-unit">
                            kalori
                        </p>
                    </div>

                    <div class="cute-summary-icon">
                        🧭
                    </div>
                </div>
            </div>

            <div class="cute-card cute-progress-card">
                <h2 class="cute-section-title">
                    Progress Kalori Hari Ini
                </h2>

                <p class="cute-section-subtitle">
                    Pantau apakah kalori harian masih sesuai target.
                </p>

                <div class="cute-progress-track">
                    <div class="cute-progress-bar"></div>
                </div>

                <div class="cute-progress-info">
                    <span>{{ number_format($kaloriMasuk) }} kalori</span>
                    <span>{{ number_format($targetKalori) }} kalori</span>
                </div>

                <div class="cute-progress-warning">
                    {{ $statusAmount }} dari target harian
                </div>
            </div>

            <div class="cute-card cute-table-card">
                <div class="cute-table-header">
                    <div>
                        <h2 class="cute-section-title">
                            Jadwal Makan Hari Ini
                        </h2>

                        <p class="cute-section-subtitle">
                            Tandai makanan yang sudah dimakan agar kalori otomatis terhitung.
                        </p>
                    </div>

                    <a href="{{ route('user.meal-plans') }}" class="btn btn-primary">
                        + Tambah Jadwal
                    </a>
                </div>

                @if ($hasItems)
                    <div class="cute-table-wrapper">
                        <table class="cute-table">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Jenis Makan</th>
                                    <th>Menu</th>
                                    <th>Porsi</th>
                                    <th>Kalori</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($mealPlans as $mealPlan)
                                    @foreach ($mealPlan->items as $item)
                                        @php
                                            $mealLabel = match ($item->waktu_makan) {
                                                'sarapan' => 'Sarapan',
                                                'makan_siang' => 'Makan Siang',
                                                'makan_malam' => 'Makan Malam',
                                                'snack' => 'Cemilan',
                                                default => $item->waktu_makan,
                                            };

                                            $mealTime = match ($item->waktu_makan) {
                                                'sarapan' => '07:00',
                                                'snack' => '10:00',
                                                'makan_siang' => '12:30',
                                                'makan_malam' => '19:00',
                                                default => '-',
                                            };

                                            $mealIcon = match ($item->waktu_makan) {
                                                'sarapan' => '☀️',
                                                'snack' => '🍎',
                                                'makan_siang' => '🍱',
                                                'makan_malam' => '🌙',
                                                default => '🍽️',
                                            };

                                            $totalItemKalori = (int) ($item->makanan?->kalori ?? 0) * (int) $item->porsi;
                                        @endphp

                                        <tr>
                                            <td>{{ $mealTime }}</td>

                                            <td>
                                                <span class="meal-type">
                                                    <span class="meal-icon">{{ $mealIcon }}</span>
                                                    {{ $mealLabel }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="meal-name">
                                                    {{ $item->makanan?->nama ?? 'Makanan tidak ditemukan' }}
                                                </span>
                                            </td>

                                            <td>
                                                {{ $item->porsi }} porsi
                                            </td>

                                            <td>
                                                {{ number_format($totalItemKalori) }}
                                            </td>

                                            <td>
                                                @if ($item->sudah_dikonsumsi)
                                                    <span class="status-pill status-done">
                                                        ✓ Dimakan
                                                    </span>
                                                @else
                                                    <span class="status-pill status-pending">
                                                        ☐ Belum
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                <button
                                                    type="button"
                                                    wire:click="toggleKonsumsi({{ $item->id }})"
                                                    wire:loading.attr="disabled"
                                                    class="cute-action-button {{ $item->sudah_dikonsumsi ? 'cute-action-danger' : 'cute-action-success' }}"
                                                >
                                                    {{ $item->sudah_dikonsumsi ? 'Batalkan' : 'Dimakan' }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-dashboard">
                        <p class="empty-dashboard-title">
                            Belum ada jadwal makan hari ini
                        </p>

                        <p class="empty-dashboard-text">
                            Buat meal plan dengan tanggal hari ini agar jadwal makan muncul di dashboard.
                        </p>

                        <a href="{{ route('user.meal-plans') }}" class="btn btn-primary">
                            Buat Meal Plan Sekarang
                        </a>
                    </div>
                @endif
            </div>

            <div class="cute-card cute-side-card">
                <h2 class="cute-section-title">
                    Aksi Cepat
                </h2>

                <p class="cute-section-subtitle">
                    Kelola aktivitas meal planner kamu dari sini.
                </p>

                <div class="quick-actions">
                    <a href="{{ route('user.meal-plans') }}" class="btn btn-primary">
                        + Tambah Meal Plan
                    </a>

                    <a href="{{ route('user.daftar-belanja') }}" class="btn btn-success">
                        🛒 Daftar Belanja
                    </a>

                    @if (Route::has('user.makanan-saya'))
                        <a href="{{ route('user.makanan-saya') }}" class="btn btn-outline">
                            🍓 Makanan Saya
                        </a>
                    @endif

                    <a href="{{ route('user.profile') }}" class="btn btn-outline">
                        👤 Profile
                    </a>
                </div>
            </div>
        </main>

        <aside class="cute-side">
            <div class="cute-card cute-side-card">
                <h2 class="cute-section-title">
                    Ringkasan Kalori
                </h2>

                <div class="donut-row">
                    <div class="donut">
                        <div class="donut-inner">
                            {{ number_format($kaloriMasuk) }}
                            <span>kalori</span>
                        </div>
                    </div>

                    <div class="legend-list">
                        <div class="legend-item">
                            <span class="legend-dot dot-green"></span>
                            <span>
                                Masuk<br>
                                {{ number_format($kaloriMasuk) }} kalori
                            </span>
                        </div>

                        <div class="legend-item">
                            <span class="legend-dot dot-pink"></span>
                            <span>
                                Target<br>
                                {{ number_format($targetKalori) }} kalori
                            </span>
                        </div>

                        <div class="legend-item">
                            <span class="legend-dot dot-gray"></span>
                            <span>
                                Sisa<br>
                                {{ $isOverTarget ? '0' : number_format($sisa) }} kalori
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cute-card cute-side-card">
                <h2 class="cute-section-title">
                    Ringkasan Nutrisi
                </h2>

                <p class="cute-section-subtitle">
                    Nutrisi dari makanan yang sudah dikonsumsi.
                </p>

                <div class="legend-list" style="margin-top: 18px;">
                    <div class="legend-item">
                        <span class="legend-dot dot-green"></span>
                        <span>
                            Protein<br>
                            {{ number_format($proteinMasuk, 1, ',', '.') }} gram
                        </span>
                    </div>

                    <div class="legend-item">
                        <span class="legend-dot dot-pink"></span>
                        <span>
                            Karbohidrat<br>
                            {{ number_format($karbohidratMasuk, 1, ',', '.') }} gram
                        </span>
                    </div>

                    <div class="legend-item">
                        <span class="legend-dot dot-gray"></span>
                        <span>
                            Lemak<br>
                            {{ number_format($lemakMasuk, 1, ',', '.') }} gram
                        </span>
                    </div>
                </div>
            </div>

            <div class="cute-card cute-side-card">
                <h2 class="cute-section-title">
                    Minum Air Putih
                </h2>

                <p class="cute-section-subtitle">
                    Jangan lupa minum air putih minimal 8 gelas per hari.
                </p>

                <div class="water-row">
                    <div class="water-glass"></div>
                    <div class="water-glass"></div>
                    <div class="water-glass"></div>
                    <div class="water-glass"></div>
                    <div class="water-glass"></div>
                    <div class="water-glass"></div>
                    <div class="water-glass empty"></div>
                    <div class="water-glass empty"></div>
                </div>

                <p class="cute-section-subtitle" style="text-align: center; margin-top: 12px;">
                    6 / 8 gelas
                </p>
            </div>

            <div class="cute-card cute-side-card">
                <h2 class="cute-section-title">
                    Tips Hari Ini
                </h2>

                <div class="tips-box">
                    💡 Coba ganti camilan tinggi gula dengan buah segar atau yogurt agar lebih sehat dan tetap enak.
                </div>
            </div>
        </aside>
    </div>
</div>