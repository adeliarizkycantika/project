<div class="st-dashboard">
    @php
        $currentUser = auth()->user();

        $firstName = collect(
            preg_split('/\s+/', trim($currentUser?->name ?? 'Pengguna'))
        )->filter()->first() ?? 'Pengguna';

        $remainingCalories = (int) $sisaKalori;
        $displayRemainingCalories = abs($remainingCalories);
        $isOverTarget = $remainingCalories < 0;

        $recommendationImage = data_get(
            $siteSetting ?? null,
            'recommendation_image_url'
        );

        $mealSchedule = collect($jadwalMakanHariIni ?? []);

        $mealSlots = [
            'sarapan' => [
                'label' => 'Sarapan',
                'time' => '07.00 – 09.00',
                'icon' => '☀️',
                'tone' => 'blue',
            ],
            'makan_siang' => [
                'label' => 'Makan Siang',
                'time' => '12.00 – 14.00',
                'icon' => '◐',
                'tone' => 'violet',
            ],
            'makan_malam' => [
                'label' => 'Makan Malam',
                'time' => '18.00 – 20.00',
                'icon' => '☾',
                'tone' => 'mint',
            ],
            'cemilan' => [
                'label' => 'Cemilan',
                'time' => 'Fleksibel',
                'icon' => '✦',
                'tone' => 'peach',
            ],
        ];

        $bodyDataItems = [
            [
                'label' => 'Gender',
                'value' => $dataTubuh['gender_label']
                    ?? $dataTubuh['gender']
                    ?? '-',
            ],
            [
                'label' => 'Usia',
                'value' => filled(
                    $dataTubuh['age']
                    ?? $dataTubuh['usia']
                    ?? null
                )
                    ? (
                        $dataTubuh['age']
                        ?? $dataTubuh['usia']
                    ) . ' tahun'
                    : '-',
            ],
            [
                'label' => 'Tinggi badan',
                'value' => filled(
                    $dataTubuh['height_cm']
                    ?? $dataTubuh['tinggi']
                    ?? null
                )
                    ? number_format(
                        (float) (
                            $dataTubuh['height_cm']
                            ?? $dataTubuh['tinggi']
                        ),
                        0,
                        ',',
                        '.'
                    ) . ' cm'
                    : '-',
            ],
            [
                'label' => 'Berat badan',
                'value' => filled(
                    $dataTubuh['weight_kg']
                    ?? $dataTubuh['berat']
                    ?? null
                )
                    ? number_format(
                        (float) (
                            $dataTubuh['weight_kg']
                            ?? $dataTubuh['berat']
                        ),
                        1,
                        ',',
                        '.'
                    ) . ' kg'
                    : '-',
            ],
            [
                'label' => 'Aktivitas',
                'value' => $dataTubuh['activity_level_label']
                    ?? $dataTubuh['activity_label']
                    ?? $dataTubuh['aktivitas']
                    ?? '-',
            ],
        ];
    @endphp

    <style>
        .st-dashboard {
            --st-blue: #7ca1d8;
            --st-blue-dark: #5579ad;
            --st-blue-soft: #e5efff;
            --st-violet: #a797d6;
            --st-violet-dark: #6f609d;
            --st-violet-soft: #eee9ff;
            --st-mint: #83c8b5;
            --st-mint-dark: #438674;
            --st-mint-soft: #e4f8f1;
            --st-peach: #efb388;
            --st-peach-dark: #a66536;
            --st-peach-soft: #fff1e6;
            --st-danger: #ba1a1a;
            --st-danger-soft: #fff1ef;
            --st-success: #32745f;
            --st-success-soft: #e8f8f1;
            --st-warning: #85601b;
            --st-warning-soft: #fff8df;
            --st-ink: #191c20;
            --st-muted: #626a76;
            --st-faint: #8a919d;
            --st-border: #dfe3eb;
            --st-border-strong: #cbd2dd;
            --st-surface: #ffffff;
            --st-surface-soft: #f7f8fc;
            --st-background: #fbfcff;
            --st-shadow:
                0 10px 32px rgba(68, 83, 110, 0.07);
            --st-shadow-hover:
                0 18px 42px rgba(68, 83, 110, 0.13);

            width: 100%;
            color: var(--st-ink);
        }

        .st-dashboard * {
            box-sizing: border-box;
        }

        .st-stack {
            display: grid;
            gap: 24px;
        }

        .st-top-grid {
            display: grid;
            grid-template-columns:
                minmax(0, 1.75fr)
                minmax(310px, 0.85fr);
            gap: 24px;
        }

        .st-panel {
            overflow: hidden;
            border: 1px solid var(--st-border);
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.97);
            box-shadow: var(--st-shadow);
        }

        .st-panel-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            padding: 22px 24px;
            border-bottom: 1px solid var(--st-border);
        }

        .st-panel-body {
            padding: 24px;
        }

        .st-section-title {
            margin: 0;
            color: var(--st-ink);
            font-size: 20px;
            line-height: 1.35;
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        .st-section-copy {
            max-width: 760px;
            margin: 6px 0 0;
            color: var(--st-muted);
            font-size: 12px;
            line-height: 1.65;
        }

        .st-panel-action {
            flex: 0 0 auto;
        }

        .st-hero {
            position: relative;
            min-height: 330px;
            overflow: hidden;
            display: flex;
            align-items: center;
            padding: 36px;
            border-radius: 22px;
            background:
                radial-gradient(
                    circle at 90% 2%,
                    rgba(255, 255, 255, 0.62),
                    transparent 34%
                ),
                linear-gradient(
                    135deg,
                    #eee6ff 0%,
                    #dce8ff 52%,
                    #c9f4e6 100%
                );
            box-shadow:
                0 14px 38px rgba(91, 112, 151, 0.12);
        }

        .st-hero::before,
        .st-hero::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
        }

        .st-hero::before {
            top: -95px;
            right: -75px;
            width: 250px;
            height: 250px;
            background: rgba(124, 161, 216, 0.18);
        }

        .st-hero::after {
            right: 18%;
            bottom: -105px;
            width: 170px;
            height: 170px;
            background: rgba(131, 200, 181, 0.24);
        }

        .st-hero-content {
            position: relative;
            z-index: 2;
            max-width: 680px;
        }

        .st-kicker {
            min-height: 31px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 11px;
            border: 1px solid rgba(85, 121, 173, 0.22);
            border-radius: 999px;
            color: var(--st-blue-dark);
            background: rgba(255, 255, 255, 0.67);
            font-size: 10px;
            line-height: 1;
            font-weight: 700;
            backdrop-filter: blur(8px);
        }

        .st-hero-title {
            max-width: 650px;
            margin: 18px 0 0;
            color: var(--st-ink);
            font-size: clamp(34px, 4vw, 48px);
            line-height: 1.1;
            font-weight: 700;
            letter-spacing: -0.045em;
        }

        .st-hero-title span {
            color: var(--st-blue-dark);
        }

        .st-hero-copy {
            max-width: 590px;
            margin: 15px 0 0;
            color: #4f5967;
            font-size: 14px;
            line-height: 1.75;
        }

        .st-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 25px;
        }

        .st-button {
            min-height: 43px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 17px;
            border: 1px solid transparent;
            border-radius: 10px;
            text-decoration: none;
            cursor: pointer;
            font-size: 11px;
            line-height: 1.2;
            font-weight: 700;
            transition:
                transform 180ms ease,
                box-shadow 180ms ease,
                opacity 180ms ease,
                background 180ms ease,
                border-color 180ms ease;
        }

        .st-button:hover {
            transform: translateY(-1px);
        }

        .st-button:disabled {
            cursor: wait;
            opacity: 0.58;
            transform: none;
        }

        .st-button svg {
            width: 17px;
            height: 17px;
        }

        .st-button-primary {
            color: #ffffff;
            background: var(--st-blue);
            box-shadow:
                0 10px 22px rgba(124, 161, 216, 0.23);
        }

        .st-button-primary:hover {
            background: var(--st-blue-dark);
        }

        .st-button-outline {
            color: var(--st-blue-dark);
            border-color: rgba(85, 121, 173, 0.52);
            background: rgba(255, 255, 255, 0.58);
            backdrop-filter: blur(8px);
        }

        .st-button-outline:hover {
            background: rgba(255, 255, 255, 0.88);
        }

        .st-button-success {
            color: #ffffff;
            background: var(--st-mint-dark);
        }

        .st-button-danger {
            color: var(--st-danger);
            border-color: #efb8b4;
            background: #fff8f7;
        }

        .st-button-block {
            width: 100%;
        }

        .st-calorie-card {
            min-height: 330px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 26px;
        }

        .st-calorie-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
        }

        .st-calorie-title {
            margin: 0;
            color: var(--st-ink);
            font-size: 18px;
            line-height: 1.35;
            font-weight: 700;
        }

        .st-calorie-subtitle {
            margin: 5px 0 0;
            color: var(--st-muted);
            font-size: 11px;
            line-height: 1.5;
        }

        .st-calorie-icon {
            width: 47px;
            height: 47px;
            flex: 0 0 47px;
            display: grid;
            place-items: center;
            border-radius: 15px;
            color: var(--st-blue-dark);
            background: var(--st-blue-soft);
        }

        .st-calorie-icon svg {
            width: 23px;
            height: 23px;
        }

        .st-calorie-main {
            margin-top: 24px;
        }

        .st-calorie-value {
            margin: 0;
            color: var(--st-ink);
            font-size: 37px;
            line-height: 1;
            font-weight: 700;
            letter-spacing: -0.045em;
        }

        .st-calorie-unit {
            margin: 7px 0 0;
            color: var(--st-muted);
            font-size: 10px;
            font-weight: 600;
        }

        .st-progress {
            width: 100%;
            height: 10px;
            overflow: hidden;
            margin-top: 18px;
            border-radius: 999px;
            background: #e7e9ef;
        }

        .st-progress-value {
            height: 100%;
            border-radius: inherit;
            background:
                linear-gradient(
                    90deg,
                    var(--st-blue),
                    var(--st-violet),
                    var(--st-mint)
                );
            transition: width 350ms ease;
        }

        .st-progress-copy {
            margin: 9px 0 0;
            color: var(--st-muted);
            font-size: 10px;
            line-height: 1.5;
        }

        .st-metric-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-top: 20px;
        }

        .st-metric {
            min-width: 0;
            padding: 12px;
            border: 1px solid var(--st-border);
            border-radius: 13px;
            background: #ffffff;
        }

        .st-metric-label {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--st-muted);
            font-size: 9px;
            line-height: 1.2;
            font-weight: 600;
        }

        .st-metric-dot {
            width: 7px;
            height: 7px;
            flex: 0 0 7px;
            border-radius: 999px;
            background: var(--st-blue);
        }

        .st-metric:nth-child(2) .st-metric-dot {
            background: var(--st-violet);
        }

        .st-metric:nth-child(3) .st-metric-dot {
            background: var(--st-mint);
        }

        .st-metric:nth-child(4) .st-metric-dot {
            background: var(--st-peach);
        }

        .st-metric-value {
            display: block;
            overflow: hidden;
            margin-top: 7px;
            color: var(--st-ink);
            font-size: 15px;
            line-height: 1.2;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .st-alert {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            padding: 14px 16px;
            border: 1px solid var(--st-border);
            border-radius: 14px;
            font-size: 11px;
            line-height: 1.65;
            font-weight: 600;
        }

        .st-alert svg {
            width: 19px;
            height: 19px;
            flex: 0 0 19px;
        }

        .st-alert-success {
            color: var(--st-success);
            border-color: #b9dfd1;
            background: var(--st-success-soft);
        }

        .st-alert-error {
            color: #8f1d1d;
            border-color: #efb8b4;
            background: var(--st-danger-soft);
        }

        .st-alert-warning {
            color: var(--st-warning);
            border-color: #e9d89e;
            background: var(--st-warning-soft);
        }

        .st-alert a {
            color: inherit;
            font-weight: 800;
        }

        .st-schedule-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .st-meal-slot {
            min-width: 0;
            padding: 17px;
            border: 1px solid var(--st-border);
            border-radius: 18px;
            background: #ffffff;
            transition:
                transform 180ms ease,
                box-shadow 180ms ease,
                border-color 180ms ease;
        }

        .st-meal-slot:hover {
            border-color: #cad5e5;
            box-shadow: var(--st-shadow-hover);
            transform: translateY(-2px);
        }

        .st-meal-slot-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 14px;
        }

        .st-meal-slot-title {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .st-meal-slot-icon {
            width: 35px;
            height: 35px;
            flex: 0 0 35px;
            display: grid;
            place-items: center;
            border-radius: 11px;
            color: var(--st-blue-dark);
            background: var(--st-blue-soft);
            font-size: 16px;
        }

        .st-meal-slot[data-tone="violet"]
        .st-meal-slot-icon {
            color: var(--st-violet-dark);
            background: var(--st-violet-soft);
        }

        .st-meal-slot[data-tone="mint"]
        .st-meal-slot-icon {
            color: var(--st-mint-dark);
            background: var(--st-mint-soft);
        }

        .st-meal-slot[data-tone="peach"]
        .st-meal-slot-icon {
            color: var(--st-peach-dark);
            background: var(--st-peach-soft);
        }

        .st-meal-slot-name {
            overflow: hidden;
            margin: 0;
            color: var(--st-ink);
            font-size: 12px;
            line-height: 1.3;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .st-meal-slot-time {
            color: var(--st-faint);
            font-size: 8px;
            line-height: 1.3;
            font-weight: 600;
            white-space: nowrap;
        }

        .st-slot-items {
            display: grid;
            gap: 9px;
        }

        .st-slot-item {
            padding: 11px;
            border: 1px solid var(--st-border);
            border-radius: 13px;
            background: var(--st-background);
        }

        .st-slot-item-name {
            margin: 0;
            color: var(--st-ink);
            font-size: 11px;
            line-height: 1.4;
            font-weight: 700;
        }

        .st-slot-item-meta {
            margin: 4px 0 0;
            color: var(--st-muted);
            font-size: 9px;
            line-height: 1.5;
        }

        .st-slot-item-nutrition {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 8px;
        }

        .st-mini-tag {
            min-height: 23px;
            display: inline-flex;
            align-items: center;
            padding: 4px 7px;
            border: 1px solid var(--st-border);
            border-radius: 999px;
            color: var(--st-muted);
            background: #ffffff;
            font-size: 8px;
            line-height: 1;
            font-weight: 700;
        }

        .st-slot-item-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-top: 9px;
        }

        .st-status-button {
            min-height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 6px 9px;
            border: 1px solid var(--st-border);
            border-radius: 8px;
            cursor: pointer;
            font-size: 8px;
            line-height: 1;
            font-weight: 700;
            transition:
                transform 180ms ease,
                opacity 180ms ease,
                background 180ms ease;
        }

        .st-status-button:hover {
            transform: translateY(-1px);
        }

        .st-status-button.is-consumed {
            color: var(--st-success);
            border-color: #b8ddcf;
            background: var(--st-success-soft);
        }

        .st-status-button.is-planned {
            color: var(--st-blue-dark);
            border-color: #ccdafa;
            background: #edf3ff;
        }

        .st-slot-empty {
            min-height: 112px;
            display: grid;
            place-items: center;
            padding: 14px;
            border: 1px dashed var(--st-border-strong);
            border-radius: 13px;
            color: var(--st-faint);
            background: #fbfcff;
            text-align: center;
            font-size: 9px;
            line-height: 1.5;
        }

        .st-content-grid {
            display: grid;
            grid-template-columns:
                minmax(0, 1.45fr)
                minmax(290px, 0.55fr);
            gap: 24px;
        }

        .st-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .st-form-group {
            min-width: 0;
        }

        .st-form-group.is-full {
            grid-column: 1 / -1;
        }

        .st-label {
            display: block;
            margin: 0 0 7px;
            color: var(--st-muted);
            font-size: 9px;
            line-height: 1.3;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .st-input,
        .st-select,
        .st-textarea {
            width: 100%;
            border: 1px solid var(--st-border-strong);
            border-radius: 10px;
            color: var(--st-ink);
            background: #fbfcff;
            outline: none;
            font-size: 11px;
            transition:
                border-color 180ms ease,
                box-shadow 180ms ease,
                background 180ms ease;
        }

        .st-input,
        .st-select {
            min-height: 43px;
            padding: 10px 12px;
        }

        .st-textarea {
            min-height: 96px;
            padding: 11px 12px;
            resize: vertical;
        }

        .st-input:focus,
        .st-select:focus,
        .st-textarea:focus {
            border-color: var(--st-blue);
            background: #ffffff;
            box-shadow:
                0 0 0 3px rgba(124, 161, 216, 0.14);
        }

        .st-field-error {
            display: block;
            margin-top: 6px;
            color: var(--st-danger);
            font-size: 9px;
            line-height: 1.4;
        }

        .st-form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 17px;
        }

        .st-body-list {
            display: grid;
            gap: 0;
        }

        .st-body-row {
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid var(--st-border);
        }

        .st-body-row:last-child {
            border-bottom: 0;
        }

        .st-body-label {
            color: var(--st-muted);
            font-size: 10px;
            font-weight: 600;
        }

        .st-body-value {
            color: var(--st-ink);
            font-size: 11px;
            font-weight: 700;
            text-align: right;
        }

        .st-history-list {
            display: grid;
            gap: 11px;
        }

        .st-history-item {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
            gap: 15px;
            padding: 15px;
            border: 1px solid var(--st-border);
            border-radius: 15px;
            background: #ffffff;
        }

        .st-history-main {
            min-width: 0;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .st-history-icon {
            width: 39px;
            height: 39px;
            flex: 0 0 39px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            color: var(--st-violet-dark);
            background: var(--st-violet-soft);
        }

        .st-history-icon svg {
            width: 20px;
            height: 20px;
        }

        .st-history-name {
            margin: 0;
            color: var(--st-ink);
            font-size: 12px;
            line-height: 1.4;
            font-weight: 700;
        }

        .st-history-meta {
            margin: 4px 0 0;
            color: var(--st-muted);
            font-size: 9px;
            line-height: 1.5;
        }

        .st-history-note {
            margin: 6px 0 0;
            color: var(--st-faint);
            font-size: 9px;
            line-height: 1.5;
        }

        .st-empty {
            display: grid;
            place-items: center;
            min-height: 190px;
            padding: 26px;
            border: 1px dashed var(--st-border-strong);
            border-radius: 17px;
            background: #fbfcff;
            text-align: center;
        }

        .st-empty-icon {
            width: 52px;
            height: 52px;
            display: grid;
            place-items: center;
            margin: 0 auto 12px;
            border-radius: 16px;
            color: var(--st-blue-dark);
            background: var(--st-blue-soft);
        }

        .st-empty-icon svg {
            width: 26px;
            height: 26px;
        }

        .st-empty-title {
            margin: 0;
            color: var(--st-ink);
            font-size: 13px;
            line-height: 1.4;
            font-weight: 700;
        }

        .st-empty-copy {
            max-width: 430px;
            margin: 6px auto 0;
            color: var(--st-muted);
            font-size: 10px;
            line-height: 1.6;
        }

        .st-recommendation-controls {
            width: min(100%, 510px);
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 11px;
        }

        .st-recommendation-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .st-food-card {
            min-width: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--st-border);
            border-radius: 18px;
            background: #ffffff;
            transition:
                transform 180ms ease,
                box-shadow 180ms ease,
                border-color 180ms ease;
        }

        .st-food-card:hover {
            border-color: #cad5e5;
            box-shadow: var(--st-shadow-hover);
            transform: translateY(-3px);
        }

        .st-food-visual {
            position: relative;
            height: 155px;
            overflow: hidden;
            display: grid;
            place-items: center;
            background:
                radial-gradient(
                    circle at 24% 25%,
                    rgba(255, 255, 255, 0.82),
                    transparent 28%
                ),
                linear-gradient(
                    135deg,
                    var(--st-blue-soft),
                    var(--st-violet-soft),
                    var(--st-mint-soft)
                );
        }

        .st-food-visual::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(
                    to top,
                    rgba(23, 32, 51, 0.11),
                    transparent 58%
                );
            pointer-events: none;
        }

        .st-food-image {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
        }

        .st-food-placeholder {
            font-size: 48px;
            filter: drop-shadow(
                0 10px 18px rgba(68, 83, 110, 0.12)
            );
        }

        .st-food-calorie-badge {
            position: absolute;
            z-index: 2;
            right: 11px;
            bottom: 11px;
            min-height: 27px;
            display: inline-flex;
            align-items: center;
            padding: 6px 9px;
            border-radius: 999px;
            color: var(--st-ink);
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(9px);
            font-size: 9px;
            line-height: 1;
            font-weight: 700;
        }

        .st-food-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 16px;
        }

        .st-food-name {
            margin: 0;
            color: var(--st-ink);
            font-size: 13px;
            line-height: 1.4;
            font-weight: 700;
        }

        .st-food-description {
            display: -webkit-box;
            overflow: hidden;
            margin: 7px 0 0;
            color: var(--st-muted);
            font-size: 10px;
            line-height: 1.6;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }

        .st-nutrition-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 7px;
            margin-top: 14px;
        }

        .st-nutrition {
            min-width: 0;
            padding: 8px;
            border: 1px solid var(--st-border);
            border-radius: 10px;
            background: var(--st-surface-soft);
            text-align: center;
        }

        .st-nutrition-value {
            display: block;
            overflow: hidden;
            color: var(--st-ink);
            font-size: 10px;
            line-height: 1.2;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .st-nutrition-label {
            display: block;
            margin-top: 3px;
            color: var(--st-faint);
            font-size: 7px;
            line-height: 1;
            font-weight: 600;
        }

        .st-food-action {
            margin-top: auto;
            padding-top: 15px;
        }

        @media (max-width: 1280px) {
            .st-schedule-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .st-recommendation-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 1050px) {
            .st-top-grid,
            .st-content-grid {
                grid-template-columns: 1fr;
            }

            .st-calorie-card {
                min-height: auto;
            }
        }

        @media (max-width: 720px) {
            .st-stack {
                gap: 17px;
            }

            .st-top-grid {
                gap: 17px;
            }

            .st-hero {
                min-height: auto;
                padding: 24px 20px;
                border-radius: 18px;
            }

            .st-hero-title {
                font-size: 31px;
            }

            .st-hero-copy {
                font-size: 12px;
            }

            .st-hero-actions {
                display: grid;
                grid-template-columns: 1fr;
            }

            .st-calorie-card {
                padding: 20px;
            }

            .st-panel {
                border-radius: 18px;
            }

            .st-panel-head {
                flex-direction: column;
                padding: 18px;
            }

            .st-panel-body {
                padding: 18px;
            }

            .st-schedule-grid,
            .st-form-grid,
            .st-recommendation-controls,
            .st-recommendation-grid {
                grid-template-columns: 1fr;
            }

            .st-history-item {
                grid-template-columns: 1fr;
            }

            .st-history-item .st-button {
                width: 100%;
            }

            .st-form-actions {
                justify-content: stretch;
            }

            .st-form-actions .st-button {
                width: 100%;
            }

            .st-food-visual {
                height: 180px;
            }
        }

        @media (max-width: 420px) {
            .st-metric-grid {
                grid-template-columns: 1fr;
            }

            .st-hero-title {
                font-size: 28px;
            }
        }
    </style>

    <div class="st-stack">
        <section class="st-top-grid">
            <article class="st-hero">
                <div class="st-hero-content">
                    <div class="st-kicker">
                        <x-heroicon-o-calendar-days
                            style="width: 15px; height: 15px;"
                        />

                        <span>
                            {{
                                $tanggalHariIni
                                ?: now()->translatedFormat(
                                    'l, d F Y'
                                )
                            }}
                        </span>
                    </div>

                    <h1 class="st-hero-title">
                        Halo, {{ $firstName }}.
                        <span>
                            Yuk jaga pola makan hari ini.
                        </span>
                    </h1>

                    <p class="st-hero-copy">
                        Pantau kebutuhan kalori, susun jadwal makan,
                        dan catat konsumsi harianmu dalam satu tempat
                        yang lebih teratur.
                    </p>

                    <div class="st-hero-actions">
                        <a
                            href="{{ route('user.meal-plan') }}"
                            class="st-button st-button-primary"
                        >
                            <x-heroicon-o-calendar-days />
                            <span>Buka Meal Plan</span>
                        </a>

                        <a
                            href="{{ route('user.makanan') }}"
                            class="st-button st-button-outline"
                        >
                            <x-heroicon-o-cake />
                            <span>Lihat Makanan</span>
                        </a>
                    </div>
                </div>
            </article>

            <aside class="st-panel st-calorie-card">
                <div>
                    <div class="st-calorie-top">
                        <div>
                            <h2 class="st-calorie-title">
                                Kalori Harian
                            </h2>

                            <p class="st-calorie-subtitle">
                                Target kebutuhan energi hari ini
                            </p>
                        </div>

                        <div class="st-calorie-icon">
                            <x-heroicon-o-fire />
                        </div>
                    </div>

                    <div class="st-calorie-main">
                        <p class="st-calorie-value">
                            {{
                                number_format(
                                    $targetKalori,
                                    0,
                                    ',',
                                    '.'
                                )
                            }}
                        </p>

                        <p class="st-calorie-unit">
                            kkal target harian
                        </p>

                        <div
                            class="st-progress"
                            role="progressbar"
                            aria-label="Progress kalori harian"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            aria-valuenow="{{ $persentaseKalori }}"
                        >
                            <div
                                class="st-progress-value"
                                style="width: {{ min(100, max(0, $persentaseKalori)) }}%;"
                            ></div>
                        </div>

                        <p class="st-progress-copy">
                            {{ $persentaseKalori }}% target sudah
                            tercatat hari ini.
                        </p>
                    </div>
                </div>

                <div class="st-metric-grid">
                    <div class="st-metric">
                        <span class="st-metric-label">
                            <span class="st-metric-dot"></span>
                            Kalori masuk
                        </span>

                        <strong class="st-metric-value">
                            {{
                                number_format(
                                    $kaloriMasuk,
                                    0,
                                    ',',
                                    '.'
                                )
                            }} kkal
                        </strong>
                    </div>

                    <div class="st-metric">
                        <span class="st-metric-label">
                            <span class="st-metric-dot"></span>

                            {{
                                $isOverTarget
                                    ? 'Melebihi target'
                                    : 'Sisa kalori'
                            }}
                        </span>

                        <strong class="st-metric-value">
                            {{
                                number_format(
                                    $displayRemainingCalories,
                                    0,
                                    ',',
                                    '.'
                                )
                            }} kkal
                        </strong>
                    </div>

                    <div class="st-metric">
                        <span class="st-metric-label">
                            <span class="st-metric-dot"></span>
                            Protein
                        </span>

                        <strong class="st-metric-value">
                            {{
                                number_format(
                                    $proteinMasuk,
                                    1,
                                    ',',
                                    '.'
                                )
                            }} g
                        </strong>
                    </div>

                    <div class="st-metric">
                        <span class="st-metric-label">
                            <span class="st-metric-dot"></span>
                            Karbohidrat
                        </span>

                        <strong class="st-metric-value">
                            {{
                                number_format(
                                    $karboMasuk,
                                    1,
                                    ',',
                                    '.'
                                )
                            }} g
                        </strong>
                    </div>
                </div>
            </aside>
        </section>

        @if (session('dashboard_success'))
            <div class="st-alert st-alert-success">
                <x-heroicon-o-check-circle />

                <div>
                    {{ session('dashboard_success') }}
                </div>
            </div>
        @endif

        @if (session('dashboard_error'))
            <div class="st-alert st-alert-error">
                <x-heroicon-o-exclamation-circle />

                <div>
                    {{ session('dashboard_error') }}
                </div>
            </div>
        @endif

        @if (! $dataTubuhLengkap)
            <div class="st-alert st-alert-warning">
                <x-heroicon-o-exclamation-triangle />

                <div>
                    Data tubuhmu belum lengkap sehingga target kalori
                    belum dapat dihitung secara optimal.

                    <a href="{{ route('user.profil') }}">
                        Lengkapi profil sekarang.
                    </a>
                </div>
            </div>
        @endif

        <section class="st-panel">
            <div class="st-panel-head">
                <div>
                    <h2 class="st-section-title">
                        Jadwal Makan Hari Ini
                    </h2>

                    <p class="st-section-copy">
                        Ringkasan menu yang sudah ditambahkan ke
                        Meal Plan untuk hari ini.
                    </p>
                </div>

                <div class="st-panel-action">
                    <a
                        href="{{ route('user.meal-plan') }}"
                        class="st-button st-button-outline"
                    >
                        <x-heroicon-o-pencil-square />
                        <span>Kelola Jadwal</span>
                    </a>
                </div>
            </div>

            <div class="st-panel-body">
                <div class="st-schedule-grid">
                    @foreach ($mealSlots as $slotKey => $slot)
                        @php
                            $slotItems = $mealSchedule->filter(
                                function ($item) use ($slotKey) {
                                    return (
                                        $item['waktu_makan']
                                        ?? $item['meal_time']
                                        ?? 'sarapan'
                                    ) === $slotKey;
                                }
                            );
                        @endphp

                        <article
                            class="st-meal-slot"
                            data-tone="{{ $slot['tone'] }}"
                            wire:key="meal-slot-{{ $slotKey }}"
                        >
                            <div class="st-meal-slot-head">
                                <div class="st-meal-slot-title">
                                    <div class="st-meal-slot-icon">
                                        {{ $slot['icon'] }}
                                    </div>

                                    <h3 class="st-meal-slot-name">
                                        {{ $slot['label'] }}
                                    </h3>
                                </div>

                                <span class="st-meal-slot-time">
                                    {{ $slot['time'] }}
                                </span>
                            </div>

                            @if ($slotItems->isNotEmpty())
                                <div class="st-slot-items">
                                    @foreach ($slotItems as $item)
                                        <article
                                            class="st-slot-item"
                                            wire:key="meal-item-{{ $item['id'] ?? $loop->index }}"
                                        >
                                            <h4 class="st-slot-item-name">
                                                {{
                                                    $item['nama_makanan']
                                                    ?? $item['nama']
                                                    ?? 'Menu tanpa nama'
                                                }}
                                            </h4>

                                            <p class="st-slot-item-meta">
                                                {{
                                                    number_format(
                                                        (float) (
                                                            $item['porsi']
                                                            ?? 1
                                                        ),
                                                        1,
                                                        ',',
                                                        '.'
                                                    )
                                                }} porsi
                                                ·
                                                {{
                                                    number_format(
                                                        (float) (
                                                            $item['kalori']
                                                            ?? 0
                                                        ),
                                                        0,
                                                        ',',
                                                        '.'
                                                    )
                                                }} kkal
                                            </p>

                                            <div class="st-slot-item-nutrition">
                                                <span class="st-mini-tag">
                                                    Protein
                                                    {{
                                                        number_format(
                                                            (float) (
                                                                $item['protein']
                                                                ?? 0
                                                            ),
                                                            1,
                                                            ',',
                                                            '.'
                                                        )
                                                    }}g
                                                </span>

                                                <span class="st-mini-tag">
                                                    Karbo
                                                    {{
                                                        number_format(
                                                            (float) (
                                                                $item['karbohidrat']
                                                                ?? $item['karbo']
                                                                ?? 0
                                                            ),
                                                            1,
                                                            ',',
                                                            '.'
                                                        )
                                                    }}g
                                                </span>

                                                <span class="st-mini-tag">
                                                    Lemak
                                                    {{
                                                        number_format(
                                                            (float) (
                                                                $item['lemak']
                                                                ?? 0
                                                            ),
                                                            1,
                                                            ',',
                                                            '.'
                                                        )
                                                    }}g
                                                </span>
                                            </div>

                                            <div class="st-slot-item-actions">
                                                <button
                                                    type="button"
                                                    class="st-status-button {{
                                                        ! empty(
                                                            $item['is_consumed']
                                                        )
                                                            ? 'is-consumed'
                                                            : 'is-planned'
                                                    }}"
                                                    wire:click="toggleMealPlanItemConsumed({{ (int) ($item['id'] ?? 0) }})"
                                                    wire:loading.attr="disabled"
                                                >
                                                    @if (! empty($item['is_consumed']))
                                                        <x-heroicon-o-check-circle
                                                            style="width: 13px; height: 13px;"
                                                        />

                                                        <span>Sudah dimakan</span>
                                                    @else
                                                        <x-heroicon-o-clock
                                                            style="width: 13px; height: 13px;"
                                                        />

                                                        <span>Belum dimakan</span>
                                                    @endif
                                                </button>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            @else
                                <div class="st-slot-empty">
                                    Belum ada menu untuk
                                    {{ strtolower($slot['label']) }}.
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="st-content-grid">
            <article class="st-panel">
                <div class="st-panel-head">
                    <div>
                        <h2 class="st-section-title">
                            Catat Makanan Tambahan
                        </h2>

                        <p class="st-section-copy">
                            Tambahkan makanan yang dikonsumsi di luar
                            jadwal Meal Plan.
                        </p>
                    </div>
                </div>

                <div class="st-panel-body">
                    <form
                        wire:submit.prevent="addCatatanMakananHarian"
                    >
                        <div class="st-form-grid">
                            <div class="st-form-group">
                                <label
                                    for="extra_food_date"
                                    class="st-label"
                                >
                                    Tanggal
                                </label>

                                <input
                                    id="extra_food_date"
                                    type="date"
                                    class="st-input"
                                    wire:model="extra_food_date"
                                >

                                @error('extra_food_date')
                                    <span class="st-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="st-form-group">
                                <label
                                    for="extra_meal_time"
                                    class="st-label"
                                >
                                    Waktu makan
                                </label>

                                <select
                                    id="extra_meal_time"
                                    class="st-select"
                                    wire:model="extra_meal_time"
                                >
                                    @foreach ($mealTimeOptions as $value => $label)
                                        <option value="{{ $value }}">
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('extra_meal_time')
                                    <span class="st-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="st-form-group is-full">
                                <label
                                    for="extra_food_name"
                                    class="st-label"
                                >
                                    Nama makanan
                                </label>

                                <input
                                    id="extra_food_name"
                                    type="text"
                                    class="st-input"
                                    placeholder="Contoh: roti gandum dan susu"
                                    wire:model="extra_food_name"
                                >

                                @error('extra_food_name')
                                    <span class="st-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="st-form-group">
                                <label
                                    for="extra_porsi"
                                    class="st-label"
                                >
                                    Jumlah porsi
                                </label>

                                <input
                                    id="extra_porsi"
                                    type="number"
                                    min="0.1"
                                    max="50"
                                    step="0.1"
                                    class="st-input"
                                    wire:model="extra_porsi"
                                >

                                @error('extra_porsi')
                                    <span class="st-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="st-form-group">
                                <label
                                    for="extra_calories"
                                    class="st-label"
                                >
                                    Kalori per porsi
                                </label>

                                <input
                                    id="extra_calories"
                                    type="number"
                                    min="0"
                                    max="10000"
                                    class="st-input"
                                    placeholder="Contoh: 250"
                                    wire:model="extra_calories"
                                >

                                @error('extra_calories')
                                    <span class="st-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="st-form-group">
                                <label
                                    for="extra_protein"
                                    class="st-label"
                                >
                                    Protein per porsi
                                </label>

                                <input
                                    id="extra_protein"
                                    type="number"
                                    min="0"
                                    max="1000"
                                    step="0.1"
                                    class="st-input"
                                    placeholder="Dalam gram"
                                    wire:model="extra_protein"
                                >

                                @error('extra_protein')
                                    <span class="st-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="st-form-group">
                                <label
                                    for="extra_karbohidrat"
                                    class="st-label"
                                >
                                    Karbohidrat per porsi
                                </label>

                                <input
                                    id="extra_karbohidrat"
                                    type="number"
                                    min="0"
                                    max="1000"
                                    step="0.1"
                                    class="st-input"
                                    placeholder="Dalam gram"
                                    wire:model="extra_karbohidrat"
                                >

                                @error('extra_karbohidrat')
                                    <span class="st-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="st-form-group">
                                <label
                                    for="extra_lemak"
                                    class="st-label"
                                >
                                    Lemak per porsi
                                </label>

                                <input
                                    id="extra_lemak"
                                    type="number"
                                    min="0"
                                    max="1000"
                                    step="0.1"
                                    class="st-input"
                                    placeholder="Dalam gram"
                                    wire:model="extra_lemak"
                                >

                                @error('extra_lemak')
                                    <span class="st-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="st-form-group is-full">
                                <label
                                    for="extra_catatan"
                                    class="st-label"
                                >
                                    Catatan
                                </label>

                                <textarea
                                    id="extra_catatan"
                                    class="st-textarea"
                                    placeholder="Opsional, misalnya: dikonsumsi setelah olahraga"
                                    wire:model="extra_catatan"
                                ></textarea>

                                @error('extra_catatan')
                                    <span class="st-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="st-form-actions">
                            <button
                                type="submit"
                                class="st-button st-button-primary"
                                wire:loading.attr="disabled"
                                wire:target="addCatatanMakananHarian"
                            >
                                <x-heroicon-o-plus />

                                <span
                                    wire:loading.remove
                                    wire:target="addCatatanMakananHarian"
                                >
                                    Simpan Catatan
                                </span>

                                <span
                                    wire:loading
                                    wire:target="addCatatanMakananHarian"
                                >
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </article>

            <aside class="st-panel">
                <div class="st-panel-head">
                    <div>
                        <h2 class="st-section-title">
                            Data Tubuh
                        </h2>

                        <p class="st-section-copy">
                            Data yang dipakai untuk menghitung
                            kebutuhan kalori.
                        </p>
                    </div>
                </div>

                <div class="st-panel-body">
                    <div class="st-body-list">
                        @foreach ($bodyDataItems as $bodyItem)
                            <div class="st-body-row">
                                <span class="st-body-label">
                                    {{ $bodyItem['label'] }}
                                </span>

                                <strong class="st-body-value">
                                    {{ $bodyItem['value'] }}
                                </strong>
                            </div>
                        @endforeach
                    </div>

                    <div style="margin-top: 18px;">
                        <a
                            href="{{ route('user.profil') }}"
                            class="st-button st-button-outline st-button-block"
                        >
                            <x-heroicon-o-pencil-square />
                            <span>Edit Data Tubuh</span>
                        </a>
                    </div>
                </div>
            </aside>
        </section>

        <section class="st-panel">
            <div class="st-panel-head">
                <div>
                    <h2 class="st-section-title">
                        Catatan Hari Ini
                    </h2>

                    <p class="st-section-copy">
                        Riwayat makanan tambahan yang sudah masuk
                        ke perhitungan kalori hari ini.
                    </p>
                </div>
            </div>

            <div class="st-panel-body">
                @if (count($catatanMakananHariIni) > 0)
                    <div class="st-history-list">
                        @foreach ($catatanMakananHariIni as $catatan)
                            <article
                                class="st-history-item"
                                wire:key="food-note-{{ $catatan['id'] ?? $loop->index }}"
                            >
                                <div class="st-history-main">
                                    <div class="st-history-icon">
                                        <x-heroicon-o-document-text />
                                    </div>

                                    <div>
                                        <h3 class="st-history-name">
                                            {{
                                                $catatan['nama_makanan']
                                                ?? $catatan['nama']
                                                ?? 'Makanan tambahan'
                                            }}
                                        </h3>

                                        <p class="st-history-meta">
                                            {{
                                                $catatan['waktu_makan_label']
                                                ?? $catatan['meal_time']
                                                ?? 'Waktu makan'
                                            }}
                                            ·
                                            {{
                                                number_format(
                                                    (float) (
                                                        $catatan['porsi']
                                                        ?? 1
                                                    ),
                                                    1,
                                                    ',',
                                                    '.'
                                                )
                                            }} porsi
                                            ·
                                            {{
                                                number_format(
                                                    (float) (
                                                        $catatan['kalori']
                                                        ?? 0
                                                    ),
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }} kkal
                                            · Protein
                                            {{
                                                number_format(
                                                    (float) (
                                                        $catatan['protein']
                                                        ?? 0
                                                    ),
                                                    1,
                                                    ',',
                                                    '.'
                                                )
                                            }}g
                                        </p>

                                        @if (! empty($catatan['catatan']))
                                            <p class="st-history-note">
                                                {{ $catatan['catatan'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    class="st-button st-button-danger"
                                    wire:click="deleteCatatanMakananHarian({{ (int) ($catatan['id'] ?? 0) }})"
                                    wire:confirm="Hapus catatan makanan ini?"
                                    wire:loading.attr="disabled"
                                >
                                    <x-heroicon-o-trash />
                                    <span>Hapus</span>
                                </button>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="st-empty">
                        <div>
                            <div class="st-empty-icon">
                                <x-heroicon-o-document-plus />
                            </div>

                            <h3 class="st-empty-title">
                                Belum ada catatan tambahan
                            </h3>

                            <p class="st-empty-copy">
                                Makanan tambahan yang disimpan hari ini
                                akan muncul pada bagian ini.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section class="st-panel">
            <div class="st-panel-head">
                <div>
                    <h2 class="st-section-title">
                        Rekomendasi Menu Sehat
                    </h2>

                    <p class="st-section-copy">
                        Pilih tanggal dan waktu makan, lalu tambahkan
                        menu langsung ke Meal Plan.
                    </p>
                </div>

                <div class="st-recommendation-controls">
                    <div class="st-form-group">
                        <label
                            for="selectedMealPlanDate"
                            class="st-label"
                        >
                            Tanggal Meal Plan
                        </label>

                        <input
                            id="selectedMealPlanDate"
                            type="date"
                            class="st-input"
                            wire:model="selectedMealPlanDate"
                        >

                        @error('selectedMealPlanDate')
                            <span class="st-field-error">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="st-form-group">
                        <label
                            for="selectedMealTime"
                            class="st-label"
                        >
                            Waktu makan
                        </label>

                        <select
                            id="selectedMealTime"
                            class="st-select"
                            wire:model="selectedMealTime"
                        >
                            @foreach ($mealTimeOptions as $value => $label)
                                <option value="{{ $value }}">
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        @error('selectedMealTime')
                            <span class="st-field-error">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="st-panel-body">
                @if (count($rekomendasiMenu) > 0)
                    <div class="st-recommendation-grid">
                        @foreach ($rekomendasiMenu as $menu)
                            <article
                                class="st-food-card"
                                wire:key="recommended-food-{{ $menu['id'] ?? $loop->index }}"
                            >
                                <div class="st-food-visual">
                                    @if ($recommendationImage)
                                        <img
                                            src="{{ $recommendationImage }}"
                                            alt="Foto {{ $menu['nama_makanan'] ?? $menu['nama'] ?? 'menu sehat' }}"
                                            class="st-food-image"
                                            loading="lazy"
                                        >
                                    @else
                                        <div
                                            class="st-food-placeholder"
                                            aria-hidden="true"
                                        >
                                            🥗
                                        </div>
                                    @endif

                                    <span class="st-food-calorie-badge">
                                        {{
                                            number_format(
                                                (float) (
                                                    $menu['kalori']
                                                    ?? 0
                                                ),
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }} kkal
                                    </span>
                                </div>

                                <div class="st-food-content">
                                    <h3 class="st-food-name">
                                        {{
                                            $menu['nama_makanan']
                                            ?? $menu['nama']
                                            ?? 'Menu sehat'
                                        }}
                                    </h3>

                                    <p class="st-food-description">
                                        {{
                                            $menu['deskripsi']
                                            ?? $menu['recommended_note']
                                            ?? 'Menu sehat yang dapat ditambahkan ke Meal Plan.'
                                        }}
                                    </p>

                                    <div class="st-nutrition-grid">
                                        <div class="st-nutrition">
                                            <strong class="st-nutrition-value">
                                                {{
                                                    number_format(
                                                        (float) (
                                                            $menu['protein']
                                                            ?? 0
                                                        ),
                                                        1,
                                                        ',',
                                                        '.'
                                                    )
                                                }}g
                                            </strong>

                                            <span class="st-nutrition-label">
                                                Protein
                                            </span>
                                        </div>

                                        <div class="st-nutrition">
                                            <strong class="st-nutrition-value">
                                                {{
                                                    number_format(
                                                        (float) (
                                                            $menu['karbohidrat']
                                                            ?? $menu['karbo']
                                                            ?? 0
                                                        ),
                                                        1,
                                                        ',',
                                                        '.'
                                                    )
                                                }}g
                                            </strong>

                                            <span class="st-nutrition-label">
                                                Karbo
                                            </span>
                                        </div>

                                        <div class="st-nutrition">
                                            <strong class="st-nutrition-value">
                                                {{
                                                    number_format(
                                                        (float) (
                                                            $menu['lemak']
                                                            ?? 0
                                                        ),
                                                        1,
                                                        ',',
                                                        '.'
                                                    )
                                                }}g
                                            </strong>

                                            <span class="st-nutrition-label">
                                                Lemak
                                            </span>
                                        </div>
                                    </div>

                                    <div class="st-food-action">
                                        <button
                                            type="button"
                                            class="st-button st-button-success st-button-block"
                                            wire:click="addRekomendasiToMealPlan({{ (int) ($menu['id'] ?? 0) }})"
                                            wire:loading.attr="disabled"
                                        >
                                            <x-heroicon-o-plus />

                                            <span>
                                                Tambah ke Meal Plan
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="st-empty">
                        <div>
                            <div class="st-empty-icon">
                                <x-heroicon-o-sparkles />
                            </div>

                            <h3 class="st-empty-title">
                                Belum ada rekomendasi menu
                            </h3>

                            <p class="st-empty-copy">
                                Tambahkan data makanan melalui panel
                                admin atau halaman makanan, lalu tandai
                                sebagai rekomendasi.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
</div>