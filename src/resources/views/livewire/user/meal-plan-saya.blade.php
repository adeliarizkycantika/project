<div class="mp-page">
    @php
        $jumlahMenu = (int) ($summary['jumlah_menu'] ?? 0);
        $totalKalori = (int) ($summary['total_kalori'] ?? 0);
        $kaloriDikonsumsi = (int) ($summary['consumed_kalori'] ?? 0);

        $totalProtein = (float) ($summary['total_protein'] ?? 0);
        $totalKarbohidrat = (float) ($summary['total_karbohidrat'] ?? 0);
        $totalLemak = (float) ($summary['total_lemak'] ?? 0);

        $jumlahDikonsumsi = collect($mealPlanItems)
            ->where('is_consumed', true)
            ->count();

        $persentaseDikonsumsi = $totalKalori > 0
            ? min(
                100,
                (int) round(
                    ($kaloriDikonsumsi / $totalKalori) * 100
                )
            )
            : 0;

        $isToday = $selectedDate === now()->toDateString();

        $groupTones = [
            'sarapan' => 'blue',
            'makan_siang' => 'violet',
            'makan_malam' => 'mint',
            'cemilan' => 'peach',
        ];

        $groupTimes = [
            'sarapan' => '07.00 – 09.00',
            'makan_siang' => '12.00 – 14.00',
            'makan_malam' => '18.00 – 20.00',
            'cemilan' => 'Fleksibel',
        ];
    @endphp

    <style>
        .mp-page {
            --mp-blue: #7c9fd3;
            --mp-blue-dark: #5579ad;
            --mp-blue-soft: #e8f1ff;

            --mp-violet: #a697d6;
            --mp-violet-dark: #7160a5;
            --mp-violet-soft: #f0ecff;

            --mp-mint: #7fc7b2;
            --mp-mint-dark: #438674;
            --mp-mint-soft: #e6f8f2;

            --mp-peach: #eab186;
            --mp-peach-dark: #a76739;
            --mp-peach-soft: #fff1e6;

            --mp-yellow: #ddb85f;
            --mp-yellow-dark: #82631f;
            --mp-yellow-soft: #fff8df;

            --mp-red: #ba1a1a;
            --mp-red-dark: #8f1919;
            --mp-red-soft: #fff2f0;

            --mp-green: #347a63;
            --mp-green-soft: #e8f8f1;

            --mp-text: #191c20;
            --mp-muted: #626a76;
            --mp-faint: #8a919d;

            --mp-border: #dfe3eb;
            --mp-border-strong: #cbd2dd;

            --mp-surface: #ffffff;
            --mp-surface-soft: #f7f8fc;
            --mp-background: #fbfcff;

            --mp-shadow:
                0 12px 34px rgba(68, 83, 110, 0.07);

            --mp-shadow-hover:
                0 20px 48px rgba(68, 83, 110, 0.13);

            width: 100%;
            color: var(--mp-text);
        }

        .mp-page * {
            box-sizing: border-box;
        }

        .mp-stack {
            display: grid;
            gap: 24px;
        }

        /*
        |--------------------------------------------------------------------------
        | Tombol
        |--------------------------------------------------------------------------
        */

        .mp-button {
            min-height: 43px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 17px;
            border: 1px solid transparent;
            border-radius: 10px;
            outline: none;
            text-decoration: none;
            cursor: pointer;
            font-size: 11px;
            line-height: 1.2;
            font-weight: 700;
            white-space: nowrap;
            transition:
                transform 180ms ease,
                box-shadow 180ms ease,
                background 180ms ease,
                border-color 180ms ease,
                opacity 180ms ease;
        }

        .mp-button:hover {
            transform: translateY(-1px);
        }

        .mp-button:disabled {
            cursor: wait;
            opacity: 0.58;
            transform: none;
        }

        .mp-button svg {
            width: 17px;
            height: 17px;
            flex: 0 0 17px;
        }

        .mp-button-primary {
            color: #ffffff;
            background: var(--mp-blue);
            box-shadow:
                0 10px 22px rgba(124, 159, 211, 0.24);
        }

        .mp-button-primary:hover {
            background: var(--mp-blue-dark);
        }

        .mp-button-outline {
            color: var(--mp-blue-dark);
            border-color: rgba(85, 121, 173, 0.48);
            background: #ffffff;
        }

        .mp-button-outline:hover {
            background: var(--mp-blue-soft);
        }

        .mp-button-soft {
            color: var(--mp-muted);
            border-color: var(--mp-border);
            background: var(--mp-surface-soft);
        }

        .mp-button-soft:hover {
            color: var(--mp-text);
            border-color: var(--mp-border-strong);
            background: #ffffff;
        }

        .mp-button-success {
            color: #ffffff;
            background: var(--mp-mint-dark);
        }

        .mp-button-success:hover {
            background: #356f60;
        }

        .mp-button-danger {
            color: var(--mp-red);
            border-color: #efb8b4;
            background: var(--mp-red-soft);
        }

        .mp-button-danger:hover {
            color: #ffffff;
            border-color: var(--mp-red);
            background: var(--mp-red);
        }

        .mp-button-block {
            width: 100%;
        }

        /*
        |--------------------------------------------------------------------------
        | Hero
        |--------------------------------------------------------------------------
        */

        .mp-hero {
            position: relative;
            min-height: 300px;
            overflow: hidden;
            display: flex;
            align-items: center;
            padding: 36px;
            border: 1px solid rgba(124, 159, 211, 0.18);
            border-radius: 22px;
            background:
                radial-gradient(
                    circle at 90% 4%,
                    rgba(255, 255, 255, 0.72),
                    transparent 34%
                ),
                linear-gradient(
                    135deg,
                    #e8e3ff 0%,
                    #dce8ff 52%,
                    #d2f4e9 100%
                );
            box-shadow:
                0 16px 40px rgba(83, 104, 140, 0.12);
        }

        .mp-hero::before,
        .mp-hero::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
        }

        .mp-hero::before {
            top: -110px;
            right: -70px;
            width: 280px;
            height: 280px;
            background: rgba(124, 159, 211, 0.18);
        }

        .mp-hero::after {
            right: 18%;
            bottom: -110px;
            width: 190px;
            height: 190px;
            background: rgba(127, 199, 178, 0.22);
        }

        .mp-hero-layout {
            position: relative;
            z-index: 2;
            width: 100%;
            display: grid;
            grid-template-columns:
                minmax(0, 1.35fr)
                minmax(300px, 0.65fr);
            align-items: center;
            gap: 34px;
        }

        .mp-hero-content {
            max-width: 720px;
        }

        .mp-kicker {
            min-height: 31px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 11px;
            border: 1px solid rgba(85, 121, 173, 0.22);
            border-radius: 999px;
            color: var(--mp-blue-dark);
            background: rgba(255, 255, 255, 0.68);
            backdrop-filter: blur(8px);
            font-size: 10px;
            line-height: 1;
            font-weight: 700;
        }

        .mp-kicker svg {
            width: 15px;
            height: 15px;
        }

        .mp-hero-title {
            max-width: 700px;
            margin: 18px 0 0;
            color: var(--mp-text);
            font-size: clamp(34px, 4vw, 48px);
            line-height: 1.1;
            font-weight: 700;
            letter-spacing: -0.045em;
        }

        .mp-hero-title span {
            color: var(--mp-blue-dark);
        }

        .mp-hero-description {
            max-width: 620px;
            margin: 15px 0 0;
            color: #505967;
            font-size: 13px;
            line-height: 1.75;
        }

        .mp-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 24px;
        }

        .mp-hero-progress {
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.78);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.62);
            box-shadow:
                0 14px 30px rgba(68, 83, 110, 0.08);
            backdrop-filter: blur(12px);
        }

        .mp-progress-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
        }

        .mp-progress-title {
            margin: 0;
            color: var(--mp-text);
            font-size: 13px;
            font-weight: 700;
        }

        .mp-progress-copy {
            margin: 5px 0 0;
            color: var(--mp-muted);
            font-size: 9px;
            line-height: 1.5;
        }

        .mp-progress-value-text {
            color: var(--mp-blue-dark);
            font-size: 22px;
            line-height: 1;
            font-weight: 700;
        }

        .mp-progress-track {
            width: 100%;
            height: 10px;
            overflow: hidden;
            margin-top: 17px;
            border-radius: 999px;
            background: rgba(212, 218, 228, 0.78);
        }

        .mp-progress-bar {
            height: 100%;
            border-radius: inherit;
            background:
                linear-gradient(
                    90deg,
                    var(--mp-blue),
                    var(--mp-violet),
                    var(--mp-mint)
                );
            transition: width 350ms ease;
        }

        .mp-progress-meta {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-top: 17px;
        }

        .mp-progress-stat {
            padding: 11px;
            border: 1px solid rgba(203, 210, 221, 0.78);
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.78);
        }

        .mp-progress-stat strong {
            display: block;
            color: var(--mp-text);
            font-size: 14px;
            line-height: 1.2;
            font-weight: 700;
        }

        .mp-progress-stat span {
            display: block;
            margin-top: 4px;
            color: var(--mp-muted);
            font-size: 8px;
            line-height: 1.4;
            font-weight: 600;
        }

        /*
        |--------------------------------------------------------------------------
        | Alert
        |--------------------------------------------------------------------------
        */

        .mp-alert {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            padding: 14px 16px;
            border: 1px solid var(--mp-border);
            border-radius: 14px;
            font-size: 11px;
            line-height: 1.6;
            font-weight: 600;
        }

        .mp-alert svg {
            width: 19px;
            height: 19px;
            flex: 0 0 19px;
        }

        .mp-alert-success {
            color: var(--mp-green);
            border-color: #badfd2;
            background: var(--mp-green-soft);
        }

        .mp-alert-error {
            color: var(--mp-red-dark);
            border-color: #efb8b4;
            background: var(--mp-red-soft);
        }

        /*
        |--------------------------------------------------------------------------
        | Navigasi tanggal
        |--------------------------------------------------------------------------
        */

        .mp-date-panel {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 22px;
            padding: 18px 20px;
            border: 1px solid var(--mp-border);
            border-radius: 18px;
            background: #ffffff;
            box-shadow: var(--mp-shadow);
        }

        .mp-date-copy {
            min-width: 0;
        }

        .mp-date-label {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mp-date-icon {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            color: var(--mp-blue-dark);
            background: var(--mp-blue-soft);
        }

        .mp-date-icon svg {
            width: 21px;
            height: 21px;
        }

        .mp-date-title {
            margin: 0;
            color: var(--mp-text);
            font-size: 15px;
            line-height: 1.35;
            font-weight: 700;
        }

        .mp-date-subtitle {
            margin: 4px 0 0;
            color: var(--mp-muted);
            font-size: 9px;
            line-height: 1.5;
        }

        .mp-date-controls {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 9px;
        }

        .mp-date-input {
            min-height: 43px;
            min-width: 170px;
            padding: 9px 12px;
            border: 1px solid var(--mp-border-strong);
            border-radius: 10px;
            color: var(--mp-text);
            background: #fbfcff;
            outline: none;
            font-size: 10px;
        }

        .mp-date-input:focus {
            border-color: var(--mp-blue);
            box-shadow:
                0 0 0 3px rgba(124, 159, 211, 0.14);
        }

        /*
        |--------------------------------------------------------------------------
        | Ringkasan
        |--------------------------------------------------------------------------
        */

        .mp-summary-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 13px;
        }

        .mp-summary-card {
            min-width: 0;
            padding: 16px;
            border: 1px solid var(--mp-border);
            border-radius: 16px;
            background: #ffffff;
            box-shadow: var(--mp-shadow);
        }

        .mp-summary-icon {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            color: var(--mp-blue-dark);
            background: var(--mp-blue-soft);
        }

        .mp-summary-card:nth-child(2)
        .mp-summary-icon {
            color: var(--mp-peach-dark);
            background: var(--mp-peach-soft);
        }

        .mp-summary-card:nth-child(3)
        .mp-summary-icon {
            color: var(--mp-green);
            background: var(--mp-green-soft);
        }

        .mp-summary-card:nth-child(4)
        .mp-summary-icon {
            color: var(--mp-violet-dark);
            background: var(--mp-violet-soft);
        }

        .mp-summary-card:nth-child(5)
        .mp-summary-icon {
            color: var(--mp-mint-dark);
            background: var(--mp-mint-soft);
        }

        .mp-summary-card:nth-child(6)
        .mp-summary-icon {
            color: var(--mp-yellow-dark);
            background: var(--mp-yellow-soft);
        }

        .mp-summary-icon svg {
            width: 19px;
            height: 19px;
        }

        .mp-summary-value {
            display: block;
            overflow: hidden;
            margin-top: 12px;
            color: var(--mp-text);
            font-size: 18px;
            line-height: 1.15;
            font-weight: 700;
            letter-spacing: -0.025em;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .mp-summary-label {
            display: block;
            margin-top: 5px;
            color: var(--mp-muted);
            font-size: 8px;
            line-height: 1.45;
            font-weight: 600;
        }

        /*
        |--------------------------------------------------------------------------
        | Panel
        |--------------------------------------------------------------------------
        */

        .mp-content-grid {
            display: grid;
            grid-template-columns:
                minmax(0, 1.45fr)
                minmax(310px, 0.55fr);
            align-items: start;
            gap: 24px;
        }

        .mp-panel {
            overflow: hidden;
            border: 1px solid var(--mp-border);
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.97);
            box-shadow: var(--mp-shadow);
        }

        .mp-panel-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            padding: 22px 24px;
            border-bottom: 1px solid var(--mp-border);
        }

        .mp-panel-body {
            padding: 24px;
        }

        .mp-section-title {
            margin: 0;
            color: var(--mp-text);
            font-size: 20px;
            line-height: 1.35;
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        .mp-section-description {
            max-width: 720px;
            margin: 6px 0 0;
            color: var(--mp-muted);
            font-size: 11px;
            line-height: 1.65;
        }

        /*
        |--------------------------------------------------------------------------
        | Grup waktu makan
        |--------------------------------------------------------------------------
        */

        .mp-group-list {
            display: grid;
            gap: 15px;
        }

        .mp-group {
            overflow: hidden;
            border: 1px solid var(--mp-border);
            border-radius: 17px;
            background: var(--mp-background);
        }

        .mp-group-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 15px 16px;
            border-bottom: 1px solid var(--mp-border);
            background: #ffffff;
        }

        .mp-group-title-wrap {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .mp-group-icon {
            width: 38px;
            height: 38px;
            flex: 0 0 38px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            color: var(--mp-blue-dark);
            background: var(--mp-blue-soft);
            font-size: 17px;
        }

        .mp-group[data-tone="violet"]
        .mp-group-icon {
            color: var(--mp-violet-dark);
            background: var(--mp-violet-soft);
        }

        .mp-group[data-tone="mint"]
        .mp-group-icon {
            color: var(--mp-mint-dark);
            background: var(--mp-mint-soft);
        }

        .mp-group[data-tone="peach"]
        .mp-group-icon {
            color: var(--mp-peach-dark);
            background: var(--mp-peach-soft);
        }

        .mp-group-title {
            margin: 0;
            color: var(--mp-text);
            font-size: 12px;
            line-height: 1.35;
            font-weight: 700;
        }

        .mp-group-time {
            margin: 3px 0 0;
            color: var(--mp-faint);
            font-size: 8px;
            line-height: 1.4;
        }

        .mp-group-total {
            min-height: 29px;
            display: inline-flex;
            align-items: center;
            padding: 6px 9px;
            border: 1px solid var(--mp-border);
            border-radius: 999px;
            color: var(--mp-muted);
            background: var(--mp-surface-soft);
            font-size: 8px;
            line-height: 1;
            font-weight: 700;
            white-space: nowrap;
        }

        .mp-group-items {
            display: grid;
            gap: 10px;
            padding: 13px;
        }

        .mp-item {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
            gap: 15px;
            padding: 14px;
            border: 1px solid var(--mp-border);
            border-radius: 14px;
            background: #ffffff;
            transition:
                transform 180ms ease,
                box-shadow 180ms ease,
                border-color 180ms ease;
        }

        .mp-item:hover {
            border-color: #cad5e5;
            box-shadow: var(--mp-shadow-hover);
            transform: translateY(-1px);
        }

        .mp-item-main {
            min-width: 0;
        }

        .mp-item-name {
            margin: 0;
            color: var(--mp-text);
            font-size: 12px;
            line-height: 1.4;
            font-weight: 700;
        }

        .mp-item-meta {
            margin: 5px 0 0;
            color: var(--mp-muted);
            font-size: 9px;
            line-height: 1.5;
        }

        .mp-item-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 9px;
        }

        .mp-tag {
            min-height: 24px;
            display: inline-flex;
            align-items: center;
            padding: 5px 8px;
            border: 1px solid var(--mp-border);
            border-radius: 999px;
            color: var(--mp-muted);
            background: var(--mp-surface-soft);
            font-size: 8px;
            line-height: 1;
            font-weight: 700;
        }

        .mp-item-note {
            display: flex;
            align-items: flex-start;
            gap: 7px;
            margin-top: 9px;
            padding: 9px;
            border: 1px solid #d9d0f1;
            border-radius: 9px;
            color: var(--mp-violet-dark);
            background: var(--mp-violet-soft);
            font-size: 8px;
            line-height: 1.55;
        }

        .mp-item-note svg {
            width: 13px;
            height: 13px;
            flex: 0 0 13px;
        }

        .mp-item-actions {
            display: grid;
            gap: 7px;
            min-width: 128px;
        }

        .mp-status {
            min-height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 10px;
            border: 1px solid var(--mp-border);
            border-radius: 9px;
            cursor: pointer;
            font-size: 8px;
            line-height: 1;
            font-weight: 700;
            transition:
                transform 180ms ease,
                opacity 180ms ease;
        }

        .mp-status:hover {
            transform: translateY(-1px);
        }

        .mp-status svg {
            width: 14px;
            height: 14px;
        }

        .mp-status.is-consumed {
            color: var(--mp-green);
            border-color: #b9dfd1;
            background: var(--mp-green-soft);
        }

        .mp-status.is-planned {
            color: var(--mp-blue-dark);
            border-color: #cbd9ef;
            background: var(--mp-blue-soft);
        }

        .mp-item-delete {
            min-height: 34px;
            padding: 7px 10px;
            font-size: 8px;
        }

        /*
        |--------------------------------------------------------------------------
        | Form
        |--------------------------------------------------------------------------
        */

        .mp-form-grid {
            display: grid;
            gap: 14px;
        }

        .mp-form-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .mp-form-group {
            min-width: 0;
        }

        .mp-label {
            display: block;
            margin: 0 0 7px;
            color: var(--mp-muted);
            font-size: 9px;
            line-height: 1.3;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .mp-input,
        .mp-select,
        .mp-textarea {
            width: 100%;
            border: 1px solid var(--mp-border-strong);
            border-radius: 10px;
            color: var(--mp-text);
            background: #fbfcff;
            outline: none;
            font-size: 11px;
            transition:
                border-color 180ms ease,
                box-shadow 180ms ease,
                background 180ms ease;
        }

        .mp-input,
        .mp-select {
            min-height: 44px;
            padding: 10px 12px;
        }

        .mp-textarea {
            min-height: 100px;
            padding: 11px 12px;
            resize: vertical;
        }

        .mp-input::placeholder,
        .mp-textarea::placeholder {
            color: #a0a6b0;
        }

        .mp-input:focus,
        .mp-select:focus,
        .mp-textarea:focus {
            border-color: var(--mp-blue);
            background: #ffffff;
            box-shadow:
                0 0 0 3px rgba(124, 159, 211, 0.14);
        }

        .mp-field-error {
            display: block;
            margin-top: 6px;
            color: var(--mp-red);
            font-size: 9px;
            line-height: 1.4;
        }

        .mp-field-hint {
            margin: 6px 0 0;
            color: var(--mp-faint);
            font-size: 8px;
            line-height: 1.5;
        }

        .mp-search-wrapper {
            position: relative;
        }

        .mp-search-icon {
            position: absolute;
            z-index: 2;
            top: 50%;
            left: 13px;
            width: 17px;
            height: 17px;
            color: var(--mp-faint);
            transform: translateY(-50%);
            pointer-events: none;
        }

        .mp-search-wrapper .mp-input {
            padding-left: 40px;
        }

        .mp-add-summary {
            display: grid;
            gap: 8px;
            margin-top: 5px;
            padding: 12px;
            border: 1px solid var(--mp-border);
            border-radius: 12px;
            background: var(--mp-surface-soft);
        }

        .mp-add-summary-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            color: var(--mp-muted);
            font-size: 8px;
            line-height: 1.4;
        }

        .mp-add-summary-row strong {
            color: var(--mp-text);
            font-size: 9px;
            font-weight: 700;
            text-align: right;
        }

        .mp-form-action {
            margin-top: 4px;
        }

        .mp-manage-food {
            margin-top: 11px;
        }

        /*
        |--------------------------------------------------------------------------
        | Empty
        |--------------------------------------------------------------------------
        */

        .mp-empty {
            min-height: 220px;
            display: grid;
            place-items: center;
            padding: 28px;
            border: 1px dashed var(--mp-border-strong);
            border-radius: 15px;
            background: #fbfcff;
            text-align: center;
        }

        .mp-empty.is-small {
            min-height: 135px;
            padding: 18px;
        }

        .mp-empty-icon {
            width: 55px;
            height: 55px;
            display: grid;
            place-items: center;
            margin: 0 auto 12px;
            border-radius: 17px;
            color: var(--mp-blue-dark);
            background: var(--mp-blue-soft);
        }

        .mp-empty.is-small .mp-empty-icon {
            width: 44px;
            height: 44px;
            border-radius: 13px;
        }

        .mp-empty-icon svg {
            width: 27px;
            height: 27px;
        }

        .mp-empty.is-small .mp-empty-icon svg {
            width: 21px;
            height: 21px;
        }

        .mp-empty-title {
            margin: 0;
            color: var(--mp-text);
            font-size: 13px;
            line-height: 1.4;
            font-weight: 700;
        }

        .mp-empty-copy {
            max-width: 420px;
            margin: 6px auto 0;
            color: var(--mp-muted);
            font-size: 9px;
            line-height: 1.6;
        }

        /*
        |--------------------------------------------------------------------------
        | Loading
        |--------------------------------------------------------------------------
        */

        .mp-loading-line {
            height: 3px;
            overflow: hidden;
            margin-bottom: -3px;
            border-radius: 999px;
            background: transparent;
        }

        .mp-loading-line::after {
            content: "";
            width: 38%;
            height: 100%;
            display: block;
            border-radius: inherit;
            background:
                linear-gradient(
                    90deg,
                    var(--mp-blue),
                    var(--mp-violet),
                    var(--mp-mint)
                );
            animation:
                mp-loading 900ms ease-in-out infinite alternate;
        }

        @keyframes mp-loading {
            from {
                transform: translateX(-15%);
            }

            to {
                transform: translateX(185%);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Responsive
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1360px) {
            .mp-summary-grid {
                grid-template-columns:
                    repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .mp-hero-layout,
            .mp-content-grid {
                grid-template-columns: 1fr;
            }

            .mp-hero-progress {
                max-width: 620px;
            }

            .mp-date-panel {
                align-items: flex-start;
                flex-direction: column;
            }

            .mp-date-controls {
                width: 100%;
                justify-content: flex-start;
            }
        }

        @media (max-width: 760px) {
            .mp-stack {
                gap: 17px;
            }

            .mp-hero {
                min-height: auto;
                padding: 24px 20px;
                border-radius: 18px;
            }

            .mp-hero-title {
                font-size: 31px;
            }

            .mp-hero-description {
                font-size: 12px;
            }

            .mp-hero-actions {
                display: grid;
                grid-template-columns: 1fr;
            }

            .mp-hero-actions .mp-button {
                width: 100%;
            }

            .mp-date-controls {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .mp-date-input {
                width: 100%;
                min-width: 0;
                grid-column: 1 / -1;
            }

            .mp-date-controls
            .mp-button-danger {
                grid-column: 1 / -1;
            }

            .mp-summary-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .mp-panel {
                border-radius: 18px;
            }

            .mp-panel-head {
                flex-direction: column;
                padding: 18px;
            }

            .mp-panel-body {
                padding: 18px;
            }

            .mp-item {
                grid-template-columns: 1fr;
            }

            .mp-item-actions {
                min-width: 0;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .mp-form-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 450px) {
            .mp-date-controls,
            .mp-summary-grid,
            .mp-item-actions,
            .mp-progress-meta {
                grid-template-columns: 1fr;
            }

            .mp-date-controls
            .mp-button-danger,
            .mp-date-input {
                grid-column: auto;
            }

            .mp-hero-title {
                font-size: 28px;
            }
        }
    
        /* meal-plan-select-arrow */

        .meal-select-shell {
            position: relative;
            width: 100%;
        }

        .meal-select-shell
        .meal-select-control {
            width: 100%;
            padding-right: 48px !important;

            cursor: pointer;

            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;

            background-image: none !important;
        }

        .meal-select-arrow {
            position: absolute;
            z-index: 4;

            top: 50%;
            right: 11px;

            width: 28px;
            height: 28px;

            display: grid;
            place-items: center;

            border: 1px solid #d4deed;
            border-radius: 8px;

            color: #587daf;
            background: #edf3fc;

            pointer-events: none;

            transform: translateY(-50%);

            transition:
                transform 180ms ease,
                color 180ms ease,
                border-color 180ms ease,
                background 180ms ease;
        }

        .meal-select-arrow svg {
            width: 15px;
            height: 15px;
            display: block;
        }

        .meal-select-shell:hover
        .meal-select-arrow {
            border-color: #afc2df;
            background: #e3edfa;
        }

        .meal-select-shell:focus-within
        .meal-select-arrow {
            color: #ffffff;
            border-color: #789bd0;
            background: #789bd0;

            transform:
                translateY(-50%)
                rotate(180deg);
        }

        .meal-select-shell:focus-within
        .meal-select-control {
            border-color: #789bd0 !important;

            box-shadow:
                0 0 0 3px
                rgba(120, 155, 208, 0.15) !important;
        }

    
        /* meal-plan-target-card-start */

        [data-meal-calorie-value] {
            display: flex !important;
            align-items: baseline !important;
            flex-wrap: wrap !important;
            gap: 3px !important;
        }

        .meal-target-current {
            color: inherit;
            font: inherit;
            font-weight: inherit;
        }

        .meal-target-separator {
            color: #9199a5;
            font-size: 12px;
            font-weight: 800;
        }

        .meal-target-goal {
            color: #5579ad;
            font-size: 13px;
            font-weight: 850;
        }

        .meal-target-unit {
            color: #7b8492;
            font-size: 9px;
            font-weight: 800;
        }

        [data-meal-calorie-label] {
            display: block !important;
        }

        .meal-target-caption {
            display: block;
        }

        .meal-target-status {
            display: block;
            margin-top: 5px;
            font-size: 9px;
            line-height: 1.35;
            font-weight: 850;
        }

        .meal-target-status.is-kurang {
            color: #b36d31;
        }

        .meal-target-status.is-sesuai {
            color: #39816e;
        }

        .meal-target-status.is-lebih {
            color: #b64353;
        }

        .meal-target-status.is-belum_tersedia {
            color: #7b8492;
        }

        .meal-target-progress {
            width: 100%;
            height: 4px;
            display: block;
            overflow: hidden;
            margin-top: 6px;
            border-radius: 999px;
            background: #e8edf4;
        }

        .meal-target-progress-fill {
            height: 100%;
            display: block;
            border-radius: inherit;
            background:
                linear-gradient(
                    90deg,
                    #7d9fd3,
                    #79c7b2
                );
        }

        .meal-target-progress-fill.is-lebih {
            background:
                linear-gradient(
                    90deg,
                    #e5a061,
                    #d86878
                );
        }

        /* meal-plan-target-card-end */

    </style>

    <div class="mp-stack">
        {{-- Hero --}}
        <section class="mp-hero">
            <div class="mp-hero-layout">
                <div class="mp-hero-content">
                    <div class="mp-kicker">
                        <x-heroicon-o-calendar-days />

                        <span>Meal Plan Harian</span>
                    </div>

                    <h1 class="mp-hero-title">
                        Susun jadwal makan
                        <span>lebih terarah.</span>
                    </h1>

                    <p class="mp-hero-description">
                        Atur menu berdasarkan waktu makan, porsi, dan
                        kebutuhan nutrisi. Tandai makanan yang sudah
                        dikonsumsi agar progres harian selalu terpantau.
                    </p>

                    <div class="mp-hero-actions">
                        <button
                            type="button"
                            class="mp-button mp-button-primary"
                            wire:click="createMealPlan"
                            wire:loading.attr="disabled"
                            wire:target="createMealPlan"
                        >
                            <x-heroicon-o-plus />

                            <span
                                wire:loading.remove
                                wire:target="createMealPlan"
                            >
                                Siapkan Meal Plan
                            </span>

                            <span
                                wire:loading
                                wire:target="createMealPlan"
                            >
                                Menyiapkan...
                            </span>
                        </button>

                        <a
                            href="{{ route('user.makanan') }}"
                            class="mp-button mp-button-outline"
                        >
                            <x-heroicon-o-cake />

                            <span>Kelola Makanan</span>
                        </a>
                    </div>
                </div>

                <aside class="mp-hero-progress">
                    <div class="mp-progress-head">
                        <div>
                            <h2 class="mp-progress-title">
                                Progress Konsumsi
                            </h2>

                            <p class="mp-progress-copy">
                                Kalori yang sudah dikonsumsi dari
                                seluruh menu hari ini.
                            </p>
                        </div>

                        <strong class="mp-progress-value-text">
                            {{ $persentaseDikonsumsi }}%
                        </strong>
                    </div>

                    <div
                        class="mp-progress-track"
                        role="progressbar"
                        aria-label="Progress konsumsi meal plan"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        aria-valuenow="{{ $persentaseDikonsumsi }}"
                    >
                        <div
                            class="mp-progress-bar"
                            style="width: {{ $persentaseDikonsumsi }}%;"
                        ></div>
                    </div>

                    <div class="mp-progress-meta">
                        <div class="mp-progress-stat">
                            <strong>
                                {{
                                    number_format(
                                        $kaloriDikonsumsi,
                                        0,
                                        ',',
                                        '.'
                                    )
                                }} kkal
                            </strong>

                            <span>Sudah dikonsumsi</span>
                        </div>

                        <div class="mp-progress-stat">
                            <strong>
                                {{ $jumlahDikonsumsi }}
                                dari
                                {{ $jumlahMenu }}
                            </strong>

                            <span>Menu selesai</span>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        {{-- Notifikasi --}}
        @if (session('meal_plan_success'))
            <div class="mp-alert mp-alert-success">
                <x-heroicon-o-check-circle />

                <div>
                    {{ session('meal_plan_success') }}
                </div>
            </div>
        @endif

        @if (session('meal_plan_error'))
            <div class="mp-alert mp-alert-error">
                <x-heroicon-o-exclamation-circle />

                <div>
                    {{ session('meal_plan_error') }}
                </div>
            </div>
        @endif

        {{-- Navigasi tanggal --}}
        <section class="mp-date-panel">
            <div class="mp-date-copy">
                <div class="mp-date-label">
                    <div class="mp-date-icon">
                        <x-heroicon-o-calendar-days />
                    </div>

                    <div>
                        <h2 class="mp-date-title">
                            {{ $dateLabel }}
                        </h2>

                        <p class="mp-date-subtitle">
                            @if ($isToday)
                                Kamu sedang melihat Meal Plan hari ini.
                            @elseif ($hasMealPlan)
                                Meal Plan tersedia untuk tanggal ini.
                            @else
                                Belum ada Meal Plan untuk tanggal ini.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="mp-date-controls">
                <button
                    type="button"
                    class="mp-button mp-button-soft"
                    wire:click="previousDate"
                    wire:loading.attr="disabled"
                >
                    <x-heroicon-o-chevron-left />
                    <span>Sebelumnya</span>
                </button>

                <input
                    type="date"
                    class="mp-date-input"
                    wire:model.live="selectedDate"
                    aria-label="Pilih tanggal Meal Plan"
                >

                <button
                    type="button"
                    class="mp-button mp-button-soft"
                    wire:click="nextDate"
                    wire:loading.attr="disabled"
                >
                    <span>Berikutnya</span>
                    <x-heroicon-o-chevron-right />
                </button>

                <button
                    type="button"
                    class="mp-button mp-button-success"
                    wire:click="todayDate"
                    wire:loading.attr="disabled"
                >
                    <x-heroicon-o-calendar />

                    <span>Hari Ini</span>
                </button>

                @if ($hasMealPlan)
                    <button
                        type="button"
                        class="mp-button mp-button-danger"
                        wire:click="deleteMealPlan"
                        wire:confirm="Hapus seluruh Meal Plan pada tanggal ini?"
                        wire:loading.attr="disabled"
                        wire:target="deleteMealPlan"
                    >
                        <x-heroicon-o-trash />

                        <span
                            wire:loading.remove
                            wire:target="deleteMealPlan"
                        >
                            Hapus Plan
                        </span>

                        <span
                            wire:loading
                            wire:target="deleteMealPlan"
                        >
                            Menghapus...
                        </span>
                    </button>
                @endif
            </div>
        </section>

        {{-- Ringkasan --}}
        <section class="mp-summary-grid">
            <article class="mp-summary-card">
                <div class="mp-summary-icon">
                    <x-heroicon-o-clipboard-document-list />
                </div>

                <strong class="mp-summary-value">
                    {{ number_format($jumlahMenu, 0, ',', '.') }}
                </strong>

                <span class="mp-summary-label">
                    Jumlah menu
                </span>
            </article>

            <article class="mp-summary-card" data-meal-calorie-target-card>
                <div class="mp-summary-icon">
                    <x-heroicon-o-fire />
                </div>

                <strong class="mp-summary-value" data-meal-calorie-value>
                @if (
                    ($summary['target_kalori'] ?? 0)
                    > 0
                )
                    <span class="meal-target-current">
                        {{
                            number_format(
                                (int) (
                                    $summary['total_kalori']
                                    ?? 0
                                ),
                                0,
                                ',',
                                '.'
                            )
                        }}
                    </span>

                    <span class="meal-target-separator">
                        /
                    </span>

                    <span class="meal-target-goal">
                        {{
                            number_format(
                                (int) (
                                    $summary['target_kalori']
                                    ?? 0
                                ),
                                0,
                                ',',
                                '.'
                            )
                        }}
                    </span>

                    <span class="meal-target-unit">
                        kkal
                    </span>
                @else
                    <span class="meal-target-current">
                        {{
                            number_format(
                                (int) (
                                    $summary['total_kalori']
                                    ?? 0
                                ),
                                0,
                                ',',
                                '.'
                            )
                        }}
                    </span>

                    <span class="meal-target-unit">
                        kkal
                    </span>
                @endif
</strong>

                <span class="mp-summary-label" data-meal-calorie-label>
                <span class="meal-target-caption">
                    Rencana / target harian
                </span>

                @if (
                    ($summary['target_kalori'] ?? 0)
                    > 0
                )
                    <span
                        class="meal-target-status
                        is-{{
                            $summary['status_rencana']
                            ?? 'belum_tersedia'
                        }}"
                    >
                        @if (
                            ($summary['status_rencana'] ?? '')
                            === 'kurang'
                        )
                            Kurang
                            {{
                                number_format(
                                    (int) (
                                        $summary[
                                            'sisa_kalori_rencana'
                                        ]
                                        ?? 0
                                    ),
                                    0,
                                    ',',
                                    '.'
                                )
                            }}
                            kkal
                        @elseif (
                            ($summary['status_rencana'] ?? '')
                            === 'lebih'
                        )
                            Lebih
                            {{
                                number_format(
                                    (int) (
                                        $summary[
                                            'kelebihan_kalori_rencana'
                                        ]
                                        ?? 0
                                    ),
                                    0,
                                    ',',
                                    '.'
                                )
                            }}
                            kkal
                        @else
                            Target rencana terpenuhi
                        @endif
                    </span>

                    <span
                        class="meal-target-progress"
                        aria-hidden="true"
                    >
                        <span
                            class="meal-target-progress-fill
                            is-{{
                                $summary['status_rencana']
                                ?? 'belum_tersedia'
                            }}"
                            style="
                                width:
                                {{
                                    min(
                                        100,
                                        max(
                                            0,
                                            (int) (
                                                $summary[
                                                    'persentase_rencana'
                                                ]
                                                ?? 0
                                            )
                                        )
                                    )
                                }}%;
                            "
                        ></span>
                    </span>
                @else
                    <span
                        class="meal-target-status
                        is-belum_tersedia"
                    >
                        Lengkapi data tubuh untuk
                        memperoleh target kalori
                    </span>
                @endif
</span>
            </article>

            <article class="mp-summary-card">
                <div class="mp-summary-icon">
                    <x-heroicon-o-check-circle />
                </div>

                <strong class="mp-summary-value">
                    {{
                        number_format(
                            $kaloriDikonsumsi,
                            0,
                            ',',
                            '.'
                        )
                    }}
                </strong>

                <span class="mp-summary-label">
                    Kalori dikonsumsi
                </span>
            </article>

            <article class="mp-summary-card">
                <div class="mp-summary-icon">
                    <x-heroicon-o-bolt />
                </div>

                <strong class="mp-summary-value">
                    {{
                        number_format(
                            $totalProtein,
                            1,
                            ',',
                            '.'
                        )
                    }}g
                </strong>

                <span class="mp-summary-label">
                    Total protein
                </span>
            </article>

            <article class="mp-summary-card">
                <div class="mp-summary-icon">
                    <x-heroicon-o-chart-bar />
                </div>

                <strong class="mp-summary-value">
                    {{
                        number_format(
                            $totalKarbohidrat,
                            1,
                            ',',
                            '.'
                        )
                    }}g
                </strong>

                <span class="mp-summary-label">
                    Total karbohidrat
                </span>
            </article>

            <article class="mp-summary-card">
                <div class="mp-summary-icon">
                    <x-heroicon-o-beaker />
                </div>

                <strong class="mp-summary-value">
                    {{
                        number_format(
                            $totalLemak,
                            1,
                            ',',
                            '.'
                        )
                    }}g
                </strong>

                <span class="mp-summary-label">
                    Total lemak
                </span>
            </article>
        </section>

        {{-- Jadwal dan form --}}
        <section class="mp-content-grid">
            <article class="mp-panel">
                <div
                    class="mp-loading-line"
                    wire:loading
                    wire:target="selectedDate,previousDate,nextDate,todayDate,toggleConsumed,deleteItem"
                ></div>

                <div class="mp-panel-head">
                    <div>
                        <h2 class="mp-section-title">
                            Jadwal Makan
                        </h2>

                        <p class="mp-section-description">
                            Menu dibagi berdasarkan waktu makan agar
                            jadwal harian lebih mudah dipantau.
                        </p>
                    </div>
                </div>

                <div class="mp-panel-body">
                    @if (count($mealPlanItems) > 0)
                        <div class="mp-group-list">
                            @foreach ($groupedItems as $group)
                                @php
                                    $groupKey = $group['key']
                                        ?? 'sarapan';

                                    $groupTone = $groupTones[
                                        $groupKey
                                    ] ?? 'blue';

                                    $groupTime = $groupTimes[
                                        $groupKey
                                    ] ?? 'Fleksibel';
                                @endphp

                                <section
                                    class="mp-group"
                                    data-tone="{{ $groupTone }}"
                                    wire:key="meal-group-{{ $groupKey }}"
                                >
                                    <div class="mp-group-head">
                                        <div class="mp-group-title-wrap">
                                            <div class="mp-group-icon">
                                                {{ $group['icon'] ?? '🍽️' }}
                                            </div>

                                            <div>
                                                <h3 class="mp-group-title">
                                                    {{
                                                        $group['label']
                                                        ?? 'Waktu Makan'
                                                    }}
                                                </h3>

                                                <p class="mp-group-time">
                                                    {{ $groupTime }}
                                                </p>
                                            </div>
                                        </div>

                                        <span class="mp-group-total">
                                            {{
                                                number_format(
                                                    (int) (
                                                        $group[
                                                            'total_kalori'
                                                        ]
                                                        ?? 0
                                                    ),
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }}
                                            kkal
                                        </span>
                                    </div>

                                    <div class="mp-group-items">
                                        @if (count($group['items'] ?? []) > 0)
                                            @foreach ($group['items'] as $item)
                                                <article
                                                    class="mp-item"
                                                    wire:key="meal-item-{{ $item['id'] }}"
                                                >
                                                    <div class="mp-item-main">
                                                        <h4 class="mp-item-name">
                                                            {{
                                                                $item['nama']
                                                                ?? 'Menu tanpa nama'
                                                            }}
                                                        </h4>

                                                        <p class="mp-item-meta">
                                                            {{
                                                                number_format(
                                                                    (float) (
                                                                        $item[
                                                                            'porsi'
                                                                        ]
                                                                        ?? 1
                                                                    ),
                                                                    1,
                                                                    ',',
                                                                    '.'
                                                                )
                                                            }}
                                                            porsi
                                                            ·
                                                            {{
                                                                number_format(
                                                                    (int) (
                                                                        $item[
                                                                            'total_kalori'
                                                                        ]
                                                                        ?? 0
                                                                    ),
                                                                    0,
                                                                    ',',
                                                                    '.'
                                                                )
                                                            }}
                                                            kkal
                                                        </p>

                                                        <div class="mp-item-tags">
                                                            <span class="mp-tag">
                                                                Protein
                                                                {{
                                                                    number_format(
                                                                        (float) (
                                                                            $item[
                                                                                'total_protein'
                                                                            ]
                                                                            ?? 0
                                                                        ),
                                                                        1,
                                                                        ',',
                                                                        '.'
                                                                    )
                                                                }}g
                                                            </span>

                                                            <span class="mp-tag">
                                                                Karbo
                                                                {{
                                                                    number_format(
                                                                        (float) (
                                                                            $item[
                                                                                'total_karbohidrat'
                                                                            ]
                                                                            ?? 0
                                                                        ),
                                                                        1,
                                                                        ',',
                                                                        '.'
                                                                    )
                                                                }}g
                                                            </span>

                                                            <span class="mp-tag">
                                                                Lemak
                                                                {{
                                                                    number_format(
                                                                        (float) (
                                                                            $item[
                                                                                'total_lemak'
                                                                            ]
                                                                            ?? 0
                                                                        ),
                                                                        1,
                                                                        ',',
                                                                        '.'
                                                                    )
                                                                }}g
                                                            </span>
                                                        </div>

                                                        @if (filled($item['catatan'] ?? null))
                                                            <div class="mp-item-note">
                                                                <x-heroicon-o-document-text />

                                                                <span>
                                                                    {{ $item['catatan'] }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="mp-item-actions">
                                                        <button
                                                            type="button"
                                                            class="mp-status {{
                                                                ! empty(
                                                                    $item[
                                                                        'is_consumed'
                                                                    ]
                                                                )
                                                                    ? 'is-consumed'
                                                                    : 'is-planned'
                                                            }}"
                                                            wire:click="toggleConsumed({{ (int) $item['id'] }})"
                                                            wire:loading.attr="disabled"
                                                        >
                                                            @if (! empty($item['is_consumed']))
                                                                <x-heroicon-o-check-circle />

                                                                <span>
                                                                    Sudah dimakan
                                                                </span>
                                                            @else
                                                                <x-heroicon-o-clock />

                                                                <span>
                                                                    Belum dimakan
                                                                </span>
                                                            @endif
                                                        </button>

                                                        <button
                                                            type="button"
                                                            class="mp-button mp-button-danger mp-item-delete"
                                                            wire:click="deleteItem({{ (int) $item['id'] }})"
                                                            wire:confirm="Hapus item Meal Plan ini?"
                                                            wire:loading.attr="disabled"
                                                        >
                                                            <x-heroicon-o-trash />

                                                            <span>Hapus</span>
                                                        </button>
                                                    </div>
                                                </article>
                                            @endforeach
                                        @else
                                            <div class="mp-empty is-small">
                                                <div>
                                                    <div class="mp-empty-icon">
                                                        <x-heroicon-o-plus />
                                                    </div>

                                                    <h4 class="mp-empty-title">
                                                        Belum ada menu
                                                    </h4>

                                                    <p class="mp-empty-copy">
                                                        Tambahkan makanan untuk
                                                        {{
                                                            strtolower(
                                                                $group[
                                                                    'label'
                                                                ]
                                                                ?? 'waktu makan ini'
                                                            )
                                                        }}.
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </section>
                            @endforeach
                        </div>
                    @else
                        <div class="mp-empty">
                            <div>
                                <div class="mp-empty-icon">
                                    <x-heroicon-o-calendar-days />
                                </div>

                                <h3 class="mp-empty-title">
                                    Belum ada menu pada tanggal ini
                                </h3>

                                <p class="mp-empty-copy">
                                    Cari makanan pada form Tambah Menu,
                                    pilih waktu makan dan porsi, kemudian
                                    simpan ke Meal Plan.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </article>

            <aside class="mp-panel">
                <div
                    class="mp-loading-line"
                    wire:loading
                    wire:target="makananSearch,addMealPlanItem"
                ></div>

                <div class="mp-panel-head">
                    <div>
                        <h2 class="mp-section-title">
                            Tambah Menu
                        </h2>

                        <p class="mp-section-description">
                            Tambahkan makanan ke Meal Plan untuk
                            {{ $dateLabel }}.
                        </p>
                    </div>
                </div>

                <div class="mp-panel-body">
                    <form wire:submit.prevent="addMealPlanItem">
                        <div class="mp-form-grid">
                            <div class="mp-form-group">
                                <label
                                    for="makananSearch"
                                    class="mp-label"
                                >
                                    Cari makanan
                                </label>

                                <div class="mp-search-wrapper">
                                    <x-heroicon-o-magnifying-glass
                                        class="mp-search-icon"
                                    />

                                    <input
                                        id="makananSearch"
                                        type="search"
                                        class="mp-input"
                                        placeholder="Ketik nama makanan..."
                                        wire:model.live.debounce.400ms="makananSearch"
                                    >
                                </div>

                                <p class="mp-field-hint">
                                    Maksimal 30 hasil makanan akan
                                    ditampilkan.
                                </p>
                            </div>

                            <div class="mp-form-group">
                                <label
                                    for="selectedMakananId"
                                    class="mp-label"
                                >
                                    Pilih makanan
                                </label>

                                <div
                                    class="meal-select-shell"
                                    data-meal-select="selectedMakananId"
                                >
                                    <select
                                        id="selectedMakananId"
                                        class="mp-select meal-select-control"
                                        wire:model="selectedMakananId"
                                    >
                                        <option value="">
                                            Pilih makanan
                                        </option>
                                    
                                        @foreach ($makananOptions as $makanan)
                                            <option
                                                value="{{ $makanan['id'] }}"
                                            >
                                                {{ $makanan['nama'] }}
                                                ·
                                                {{
                                                    number_format(
                                                        (int) (
                                                            $makanan[
                                                                'kalori'
                                                            ]
                                                            ?? 0
                                                        ),
                                                        0,
                                                        ',',
                                                        '.'
                                                    )
                                                }}
                                                kkal
                                            </option>
                                        @endforeach
                                    </select>

                                    <span
                                        class="meal-select-arrow"
                                        aria-hidden="true"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2.2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path d="m7 10 5 5 5-5" />
                                        </svg>
                                    </span>
                                </div>

                                @error('selectedMakananId')
                                    <span class="mp-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                                @if (count($makananOptions) === 0)
                                    <p class="mp-field-hint">
                                        Tidak ada makanan yang sesuai.
                                        Tambahkan data dari halaman
                                        Makanan.
                                    </p>
                                @endif
                            </div>

                            <div class="mp-form-row">
                                <div class="mp-form-group">
                                    <label
                                        for="selectedMealTime"
                                        class="mp-label"
                                    >
                                        Waktu makan
                                    </label>

                                    <div
                                        class="meal-select-shell"
                                        data-meal-select="selectedMealTime"
                                    >
                                        <select
                                            id="selectedMealTime"
                                            class="mp-select meal-select-control"
                                            wire:model="selectedMealTime"
                                        >
                                            @foreach ($mealTimeOptions as $value => $label)
                                                <option value="{{ $value }}">
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <span
                                            class="meal-select-arrow"
                                            aria-hidden="true"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path d="m7 10 5 5 5-5" />
                                            </svg>
                                        </span>
                                    </div>

                                    @error('selectedMealTime')
                                        <span class="mp-field-error">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="mp-form-group">
                                    <label
                                        for="selectedPorsi"
                                        class="mp-label"
                                    >
                                        Jumlah porsi
                                    </label>

                                    <input
                                        id="selectedPorsi"
                                        type="number"
                                        min="0.1"
                                        max="100"
                                        step="0.1"
                                        class="mp-input"
                                        wire:model="selectedPorsi"
                                    >

                                    @error('selectedPorsi')
                                        <span class="mp-field-error">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mp-form-group">
                                <label
                                    for="selectedCatatan"
                                    class="mp-label"
                                >
                                    Catatan
                                </label>

                                <textarea
                                    id="selectedCatatan"
                                    class="mp-textarea"
                                    placeholder="Opsional, contoh: dikonsumsi setelah olahraga."
                                    wire:model="selectedCatatan"
                                ></textarea>

                                @error('selectedCatatan')
                                    <span class="mp-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="mp-add-summary">
                                <div class="mp-add-summary-row">
                                    <span>Tanggal</span>

                                    <strong>
                                        {{ $dateLabel }}
                                    </strong>
                                </div>

                                <div class="mp-add-summary-row">
                                    <span>Waktu makan</span>

                                    <strong>
                                        {{
                                            $mealTimeOptions[
                                                $selectedMealTime
                                            ]
                                            ?? 'Sarapan'
                                        }}
                                    </strong>
                                </div>

                                <div class="mp-add-summary-row">
                                    <span>Porsi</span>

                                    <strong>
                                        {{
                                            number_format(
                                                (float) (
                                                    $selectedPorsi
                                                    ?: 1
                                                ),
                                                1,
                                                ',',
                                                '.'
                                            )
                                        }}
                                    </strong>
                                </div>
                            </div>

                            <div class="mp-form-action">
                                <button
                                    type="submit"
                                    class="mp-button mp-button-primary mp-button-block"
                                    wire:loading.attr="disabled"
                                    wire:target="addMealPlanItem"
                                >
                                    <x-heroicon-o-plus />

                                    <span
                                        wire:loading.remove
                                        wire:target="addMealPlanItem"
                                    >
                                        Tambahkan ke Meal Plan
                                    </span>

                                    <span
                                        wire:loading
                                        wire:target="addMealPlanItem"
                                    >
                                        Menambahkan...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="mp-manage-food">
                        <a
                            href="{{ route('user.makanan') }}"
                            class="mp-button mp-button-outline mp-button-block"
                        >
                            <x-heroicon-o-cake />

                            <span>Kelola Data Makanan</span>
                        </a>
                    </div>
                </div>
            </aside>
        </section>
    </div>
</div>