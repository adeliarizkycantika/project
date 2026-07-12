<div class="food-page">
    @php
        $totalMakanan = method_exists($makanans, 'total')
            ? $makanans->total()
            : $makanans->count();

        $totalKategori = count($kategoriOptions);

        $filterAktif = filled($search)
            || filled($kategoriFilter)
            || filled($visibilityFilter);

        $visibilityLabels = [
            '' => 'Semua makanan',
            'mine' => 'Makanan saya',
            'public' => 'Makanan publik',
            'recommended' => 'Rekomendasi',
        ];
    @endphp

    <style>
        .food-page {
            --food-blue: #7c9fd3;
            --food-blue-dark: #5579ad;
            --food-blue-soft: #eaf2ff;

            --food-purple: #a697d6;
            --food-purple-dark: #7160a5;
            --food-purple-soft: #f0ecff;

            --food-mint: #7fc7b2;
            --food-mint-dark: #438674;
            --food-mint-soft: #e6f8f2;

            --food-peach: #eab186;
            --food-peach-dark: #a76739;
            --food-peach-soft: #fff1e6;

            --food-yellow: #e4bd68;
            --food-yellow-dark: #87651f;
            --food-yellow-soft: #fff8df;

            --food-danger: #ba1a1a;
            --food-danger-dark: #8e1818;
            --food-danger-soft: #fff2f0;

            --food-success: #347a63;
            --food-success-soft: #e8f8f1;

            --food-text: #1b1e24;
            --food-muted: #626a76;
            --food-faint: #8b929e;

            --food-border: #dfe3eb;
            --food-border-strong: #cbd2dd;

            --food-surface: #ffffff;
            --food-surface-soft: #f7f8fc;

            --food-shadow:
                0 12px 34px rgba(68, 83, 110, 0.07);

            --food-shadow-hover:
                0 20px 48px rgba(68, 83, 110, 0.13);

            width: 100%;
            color: var(--food-text);
        }

        .food-page * {
            box-sizing: border-box;
        }

        .food-stack {
            display: grid;
            gap: 24px;
        }

        /*
        |--------------------------------------------------------------------------
        | Tombol
        |--------------------------------------------------------------------------
        */

        .food-button {
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

        .food-button:hover {
            transform: translateY(-1px);
        }

        .food-button:disabled {
            cursor: wait;
            opacity: 0.58;
            transform: none;
        }

        .food-button svg {
            width: 17px;
            height: 17px;
            flex: 0 0 17px;
        }

        .food-button-primary {
            color: #ffffff;
            background: var(--food-blue);
            box-shadow:
                0 10px 22px rgba(124, 159, 211, 0.24);
        }

        .food-button-primary:hover {
            background: var(--food-blue-dark);
        }

        .food-button-outline {
            color: var(--food-blue-dark);
            border-color: rgba(85, 121, 173, 0.48);
            background: #ffffff;
        }

        .food-button-outline:hover {
            background: var(--food-blue-soft);
        }

        .food-button-soft {
            color: var(--food-muted);
            border-color: var(--food-border);
            background: var(--food-surface-soft);
        }

        .food-button-soft:hover {
            color: var(--food-text);
            border-color: var(--food-border-strong);
            background: #ffffff;
        }

        .food-button-danger {
            color: var(--food-danger);
            border-color: #efb8b4;
            background: var(--food-danger-soft);
        }

        .food-button-danger:hover {
            color: #ffffff;
            border-color: var(--food-danger);
            background: var(--food-danger);
        }

        .food-button-block {
            width: 100%;
        }

        /*
        |--------------------------------------------------------------------------
        | Hero
        |--------------------------------------------------------------------------
        */

        .food-hero {
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

        .food-hero::before,
        .food-hero::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
        }

        .food-hero::before {
            top: -110px;
            right: -70px;
            width: 280px;
            height: 280px;
            background: rgba(124, 159, 211, 0.18);
        }

        .food-hero::after {
            right: 18%;
            bottom: -110px;
            width: 190px;
            height: 190px;
            background: rgba(127, 199, 178, 0.22);
        }

        .food-hero-layout {
            position: relative;
            z-index: 2;
            width: 100%;
            display: grid;
            grid-template-columns:
                minmax(0, 1.4fr)
                minmax(290px, 0.6fr);
            align-items: center;
            gap: 34px;
        }

        .food-hero-content {
            max-width: 710px;
        }

        .food-kicker {
            min-height: 31px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 11px;
            border: 1px solid rgba(85, 121, 173, 0.22);
            border-radius: 999px;
            color: var(--food-blue-dark);
            background: rgba(255, 255, 255, 0.68);
            backdrop-filter: blur(8px);
            font-size: 10px;
            line-height: 1;
            font-weight: 700;
        }

        .food-kicker svg {
            width: 15px;
            height: 15px;
        }

        .food-hero-title {
            max-width: 690px;
            margin: 18px 0 0;
            color: var(--food-text);
            font-size: clamp(34px, 4vw, 48px);
            line-height: 1.1;
            font-weight: 700;
            letter-spacing: -0.045em;
        }

        .food-hero-title span {
            color: var(--food-blue-dark);
        }

        .food-hero-description {
            max-width: 620px;
            margin: 15px 0 0;
            color: #505967;
            font-size: 13px;
            line-height: 1.75;
        }

        .food-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 24px;
        }

        .food-summary {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 11px;
            padding: 18px;
            border: 1px solid rgba(255, 255, 255, 0.76);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.58);
            box-shadow:
                0 14px 30px rgba(68, 83, 110, 0.08);
            backdrop-filter: blur(12px);
        }

        .food-summary-card {
            min-width: 0;
            padding: 14px;
            border: 1px solid rgba(203, 210, 221, 0.72);
            border-radius: 13px;
            background: rgba(255, 255, 255, 0.84);
        }

        .food-summary-icon {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            color: var(--food-blue-dark);
            background: var(--food-blue-soft);
        }

        .food-summary-card:nth-child(2)
        .food-summary-icon {
            color: var(--food-purple-dark);
            background: var(--food-purple-soft);
        }

        .food-summary-card:nth-child(3)
        .food-summary-icon {
            color: var(--food-mint-dark);
            background: var(--food-mint-soft);
        }

        .food-summary-card:nth-child(4)
        .food-summary-icon {
            color: var(--food-peach-dark);
            background: var(--food-peach-soft);
        }

        .food-summary-icon svg {
            width: 18px;
            height: 18px;
        }

        .food-summary-value {
            display: block;
            overflow: hidden;
            margin-top: 10px;
            color: var(--food-text);
            font-size: 18px;
            line-height: 1.15;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .food-summary-label {
            display: block;
            margin-top: 4px;
            color: var(--food-muted);
            font-size: 8px;
            line-height: 1.4;
            font-weight: 600;
        }

        /*
        |--------------------------------------------------------------------------
        | Alert
        |--------------------------------------------------------------------------
        */

        .food-alert {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            padding: 14px 16px;
            border: 1px solid var(--food-border);
            border-radius: 14px;
            font-size: 11px;
            line-height: 1.6;
            font-weight: 600;
        }

        .food-alert svg {
            width: 19px;
            height: 19px;
            flex: 0 0 19px;
        }

        .food-alert-success {
            color: var(--food-success);
            border-color: #badfd2;
            background: var(--food-success-soft);
        }

        .food-alert-error {
            color: var(--food-danger-dark);
            border-color: #efb8b4;
            background: var(--food-danger-soft);
        }

        /*
        |--------------------------------------------------------------------------
        | Panel
        |--------------------------------------------------------------------------
        */

        .food-panel {
            overflow: hidden;
            border: 1px solid var(--food-border);
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.97);
            box-shadow: var(--food-shadow);
        }

        .food-panel-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            padding: 22px 24px;
            border-bottom: 1px solid var(--food-border);
        }

        .food-panel-body {
            padding: 24px;
        }

        .food-section-title {
            margin: 0;
            color: var(--food-text);
            font-size: 20px;
            line-height: 1.35;
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        .food-section-description {
            max-width: 760px;
            margin: 6px 0 0;
            color: var(--food-muted);
            font-size: 11px;
            line-height: 1.65;
        }

        /*
        |--------------------------------------------------------------------------
        | Form
        |--------------------------------------------------------------------------
        */

        .food-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px;
        }

        .food-form-group {
            min-width: 0;
        }

        .food-form-group.is-full {
            grid-column: 1 / -1;
        }

        .food-label {
            display: block;
            margin: 0 0 7px;
            color: var(--food-muted);
            font-size: 9px;
            line-height: 1.3;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .food-required {
            color: var(--food-danger);
        }

        .food-input,
        .food-select,
        .food-textarea {
            width: 100%;
            border: 1px solid var(--food-border-strong);
            border-radius: 10px;
            color: var(--food-text);
            background: #fbfcff;
            outline: none;
            font-size: 11px;
            transition:
                border-color 180ms ease,
                box-shadow 180ms ease,
                background 180ms ease;
        }

        .food-input,
        .food-select {
            min-height: 44px;
            padding: 10px 12px;
        }

        .food-textarea {
            min-height: 104px;
            padding: 11px 12px;
            resize: vertical;
        }

        .food-input::placeholder,
        .food-textarea::placeholder {
            color: #a0a6b0;
        }

        .food-input:focus,
        .food-select:focus,
        .food-textarea:focus {
            border-color: var(--food-blue);
            background: #ffffff;
            box-shadow:
                0 0 0 3px rgba(124, 159, 211, 0.14);
        }

        .food-field-error {
            display: block;
            margin-top: 6px;
            color: var(--food-danger);
            font-size: 9px;
            line-height: 1.4;
        }

        .food-field-hint {
            margin: 6px 0 0;
            color: var(--food-faint);
            font-size: 8px;
            line-height: 1.5;
        }

        .food-switch-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .food-switch-card {
            position: relative;
            min-height: 86px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px;
            border: 1px solid var(--food-border);
            border-radius: 14px;
            background: var(--food-surface-soft);
            cursor: pointer;
            transition:
                border-color 180ms ease,
                background 180ms ease,
                transform 180ms ease;
        }

        .food-switch-card:hover {
            border-color: var(--food-blue);
            background: var(--food-blue-soft);
            transform: translateY(-1px);
        }

        .food-switch-card input {
            width: 18px;
            height: 18px;
            flex: 0 0 18px;
            margin: 1px 0 0;
            accent-color: var(--food-blue-dark);
        }

        .food-switch-title {
            display: block;
            color: var(--food-text);
            font-size: 10px;
            line-height: 1.4;
            font-weight: 700;
        }

        .food-switch-description {
            display: block;
            margin-top: 4px;
            color: var(--food-muted);
            font-size: 8px;
            line-height: 1.55;
        }

        .food-form-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        .food-filter-area {
            padding: 18px;
            border: 1px solid var(--food-border);
            border-radius: 17px;
            background:
                linear-gradient(
                    135deg,
                    #f9fbff,
                    #fbfaff
                );
        }

        .food-filter-grid {
            display: grid;
            grid-template-columns:
                minmax(260px, 1.4fr)
                minmax(180px, 0.8fr)
                minmax(180px, 0.8fr);
            gap: 13px;
        }

        .food-search-wrapper {
            position: relative;
        }

        .food-search-icon {
            position: absolute;
            z-index: 2;
            top: 50%;
            left: 13px;
            width: 17px;
            height: 17px;
            color: var(--food-faint);
            transform: translateY(-50%);
            pointer-events: none;
        }

        .food-search-wrapper .food-input {
            padding-left: 40px;
        }

        .food-filter-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-top: 13px;
        }

        .food-filter-copy {
            color: var(--food-muted);
            font-size: 9px;
            line-height: 1.5;
        }

        .food-filter-badge {
            min-height: 28px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border: 1px solid #cfdbef;
            border-radius: 999px;
            color: var(--food-blue-dark);
            background: var(--food-blue-soft);
            font-size: 8px;
            line-height: 1;
            font-weight: 700;
        }

        .food-filter-badge svg {
            width: 13px;
            height: 13px;
        }

        /*
        |--------------------------------------------------------------------------
        | Daftar makanan
        |--------------------------------------------------------------------------
        */

        .food-list-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin: 24px 0 16px;
        }

        .food-result-count {
            color: var(--food-muted);
            font-size: 10px;
            line-height: 1.5;
        }

        .food-result-count strong {
            color: var(--food-text);
            font-weight: 700;
        }

        .food-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 17px;
        }

        .food-card {
            min-width: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--food-border);
            border-radius: 18px;
            background: #ffffff;
            transition:
                transform 180ms ease,
                box-shadow 180ms ease,
                border-color 180ms ease;
        }

        .food-card:hover {
            border-color: #c9d4e4;
            box-shadow: var(--food-shadow-hover);
            transform: translateY(-3px);
        }

        .food-card-visual {
            position: relative;
            height: 150px;
            overflow: hidden;
            display: grid;
            place-items: center;
            background:
                radial-gradient(
                    circle at 26% 24%,
                    rgba(255, 255, 255, 0.78),
                    transparent 28%
                ),
                linear-gradient(
                    135deg,
                    var(--food-blue-soft),
                    var(--food-purple-soft),
                    var(--food-mint-soft)
                );
        }

        .food-card:nth-child(3n + 2)
        .food-card-visual {
            background:
                radial-gradient(
                    circle at 26% 24%,
                    rgba(255, 255, 255, 0.78),
                    transparent 28%
                ),
                linear-gradient(
                    135deg,
                    var(--food-purple-soft),
                    var(--food-peach-soft),
                    var(--food-yellow-soft)
                );
        }

        .food-card:nth-child(3n + 3)
        .food-card-visual {
            background:
                radial-gradient(
                    circle at 26% 24%,
                    rgba(255, 255, 255, 0.78),
                    transparent 28%
                ),
                linear-gradient(
                    135deg,
                    var(--food-mint-soft),
                    var(--food-blue-soft),
                    var(--food-peach-soft)
                );
        }

        .food-card-visual::before,
        .food-card-visual::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
        }

        .food-card-visual::before {
            top: -28px;
            right: -20px;
            width: 90px;
            height: 90px;
            background: rgba(255, 255, 255, 0.28);
        }

        .food-card-visual::after {
            bottom: -34px;
            left: -25px;
            width: 110px;
            height: 110px;
            background: rgba(127, 199, 178, 0.14);
        }

        .food-card-icon {
            position: relative;
            z-index: 2;
            font-size: 48px;
            filter:
                drop-shadow(
                    0 10px 18px rgba(68, 83, 110, 0.14)
                );
            transition: transform 180ms ease;
        }

        .food-card:hover .food-card-icon {
            transform:
                translateY(-2px)
                scale(1.04);
        }

        .food-card-calorie {
            position: absolute;
            z-index: 3;
            right: 11px;
            bottom: 11px;
            min-height: 29px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 9px;
            border-radius: 999px;
            color: var(--food-text);
            background: rgba(255, 255, 255, 0.88);
            box-shadow:
                0 7px 16px rgba(68, 83, 110, 0.08);
            backdrop-filter: blur(9px);
            font-size: 9px;
            line-height: 1;
            font-weight: 700;
        }

        .food-card-calorie svg {
            width: 13px;
            height: 13px;
            color: var(--food-peach-dark);
        }

        .food-card-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 16px;
        }

        .food-card-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .food-card-title {
            margin: 0;
            color: var(--food-text);
            font-size: 14px;
            line-height: 1.4;
            font-weight: 700;
        }

        .food-category {
            min-height: 25px;
            display: inline-flex;
            align-items: center;
            margin-top: 8px;
            padding: 5px 8px;
            border: 1px solid #c7e4da;
            border-radius: 999px;
            color: var(--food-mint-dark);
            background: var(--food-mint-soft);
            font-size: 8px;
            line-height: 1;
            font-weight: 700;
        }

        .food-description {
            display: -webkit-box;
            overflow: hidden;
            min-height: 48px;
            margin: 10px 0 0;
            color: var(--food-muted);
            font-size: 10px;
            line-height: 1.6;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }

        .food-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 12px;
        }

        .food-badge {
            min-height: 25px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 8px;
            border: 1px solid var(--food-border);
            border-radius: 999px;
            font-size: 8px;
            line-height: 1;
            font-weight: 700;
        }

        .food-badge svg {
            width: 12px;
            height: 12px;
        }

        .food-badge-public {
            color: var(--food-success);
            border-color: #bae0d2;
            background: var(--food-success-soft);
        }

        .food-badge-private {
            color: var(--food-purple-dark);
            border-color: #d6ccf3;
            background: var(--food-purple-soft);
        }

        .food-badge-recommended {
            color: var(--food-yellow-dark);
            border-color: #ecd99e;
            background: var(--food-yellow-soft);
        }

        .food-nutrition-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 7px;
            margin-top: 14px;
        }

        .food-nutrition {
            min-width: 0;
            padding: 9px 7px;
            border: 1px solid var(--food-border);
            border-radius: 10px;
            background: var(--food-surface-soft);
            text-align: center;
        }

        .food-nutrition-value {
            display: block;
            overflow: hidden;
            color: var(--food-text);
            font-size: 10px;
            line-height: 1.2;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .food-nutrition-label {
            display: block;
            margin-top: 4px;
            color: var(--food-faint);
            font-size: 7px;
            line-height: 1;
            font-weight: 600;
        }

        .food-portion {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-top: 12px;
            color: var(--food-muted);
            font-size: 9px;
            line-height: 1.4;
            font-weight: 600;
        }

        .food-portion svg {
            width: 14px;
            height: 14px;
            color: var(--food-blue-dark);
        }

        .food-recommendation-note {
            margin-top: 12px;
            padding: 10px;
            border: 1px solid #ecd99e;
            border-radius: 10px;
            color: var(--food-yellow-dark);
            background: var(--food-yellow-soft);
            font-size: 8px;
            line-height: 1.55;
        }

        .food-card-actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            margin-top: auto;
            padding-top: 15px;
        }

        .food-card-actions .food-button {
            min-height: 38px;
            padding: 8px 10px;
            font-size: 9px;
        }

        .food-public-notice {
            min-height: 38px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: auto;
            padding-top: 15px;
            color: var(--food-muted);
            font-size: 9px;
            line-height: 1.5;
        }

        .food-public-notice svg {
            width: 15px;
            height: 15px;
            color: var(--food-success);
        }

        /*
        |--------------------------------------------------------------------------
        | Empty state
        |--------------------------------------------------------------------------
        */

        .food-empty {
            min-height: 300px;
            display: grid;
            place-items: center;
            padding: 34px;
            border: 1px dashed var(--food-border-strong);
            border-radius: 18px;
            background: #fbfcff;
            text-align: center;
        }

        .food-empty-icon {
            width: 62px;
            height: 62px;
            display: grid;
            place-items: center;
            margin: 0 auto 14px;
            border-radius: 19px;
            color: var(--food-blue-dark);
            background: var(--food-blue-soft);
        }

        .food-empty-icon svg {
            width: 30px;
            height: 30px;
        }

        .food-empty-title {
            margin: 0;
            color: var(--food-text);
            font-size: 15px;
            line-height: 1.4;
            font-weight: 700;
        }

        .food-empty-description {
            max-width: 440px;
            margin: 7px auto 0;
            color: var(--food-muted);
            font-size: 10px;
            line-height: 1.65;
        }

        .food-empty-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 9px;
            margin-top: 17px;
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        .food-pagination {
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px solid var(--food-border);
        }

        .food-pagination nav {
            width: 100%;
        }

        /*
        |--------------------------------------------------------------------------
        | Loading
        |--------------------------------------------------------------------------
        */

        .food-loading-line {
            height: 3px;
            overflow: hidden;
            margin-bottom: -3px;
            border-radius: 999px;
            background: transparent;
        }

        .food-loading-line::after {
            content: "";
            width: 38%;
            height: 100%;
            display: block;
            border-radius: inherit;
            background:
                linear-gradient(
                    90deg,
                    var(--food-blue),
                    var(--food-purple),
                    var(--food-mint)
                );
            animation:
                food-loading 900ms ease-in-out infinite alternate;
        }

        @keyframes food-loading {
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

        @media (max-width: 1280px) {
            .food-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 1050px) {
            .food-hero-layout {
                grid-template-columns: 1fr;
            }

            .food-summary {
                max-width: 620px;
            }

            .food-filter-grid {
                grid-template-columns:
                    minmax(0, 1fr)
                    minmax(170px, 0.55fr);
            }

            .food-filter-grid
            .food-form-group:last-child {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 720px) {
            .food-stack {
                gap: 17px;
            }

            .food-hero {
                min-height: auto;
                padding: 24px 20px;
                border-radius: 18px;
            }

            .food-hero-title {
                font-size: 31px;
            }

            .food-hero-description {
                font-size: 12px;
            }

            .food-hero-actions {
                display: grid;
                grid-template-columns: 1fr;
            }

            .food-hero-actions .food-button {
                width: 100%;
            }

            .food-panel {
                border-radius: 18px;
            }

            .food-panel-head {
                flex-direction: column;
                padding: 18px;
            }

            .food-panel-head .food-button {
                width: 100%;
            }

            .food-panel-body {
                padding: 18px;
            }

            .food-form-grid,
            .food-switch-grid,
            .food-filter-grid,
            .food-grid {
                grid-template-columns: 1fr;
            }

            .food-filter-grid
            .food-form-group:last-child {
                grid-column: auto;
            }

            .food-filter-status {
                align-items: flex-start;
                flex-direction: column;
            }

            .food-list-top {
                align-items: flex-start;
                flex-direction: column;
            }

            .food-card-visual {
                height: 180px;
            }

            .food-form-actions {
                display: grid;
                grid-template-columns: 1fr;
            }

            .food-form-actions .food-button {
                width: 100%;
            }
        }

        @media (max-width: 430px) {
            .food-summary {
                grid-template-columns: 1fr;
            }

            .food-hero-title {
                font-size: 28px;
            }

            .food-card-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="food-stack">
        {{-- Hero --}}
        <section class="food-hero">
            <div class="food-hero-layout">
                <div class="food-hero-content">
                    <div class="food-kicker">
                        <x-heroicon-o-sparkles />

                        <span>Database Makanan</span>
                    </div>

                    <h1 class="food-hero-title">
                        Temukan dan kelola
                        <span>makanan sehatmu.</span>
                    </h1>

                    <p class="food-hero-description">
                        Simpan informasi kalori dan makronutrisi setiap
                        makanan agar penyusunan Meal Plan menjadi lebih
                        cepat, akurat, dan sesuai kebutuhan harianmu.
                    </p>

                    <div class="food-hero-actions">
                        <button
                            type="button"
                            class="food-button food-button-primary"
                            wire:click="createMakanan"
                        >
                            <x-heroicon-o-plus />

                            <span>Tambah Makanan</span>
                        </button>

                        <a
                            href="{{ route('user.meal-plan') }}"
                            class="food-button food-button-outline"
                        >
                            <x-heroicon-o-calendar-days />

                            <span>Buka Meal Plan</span>
                        </a>
                    </div>
                </div>

                <div class="food-summary">
                    <article class="food-summary-card">
                        <div class="food-summary-icon">
                            <x-heroicon-o-cake />
                        </div>

                        <strong class="food-summary-value">
                            {{ number_format($totalMakanan, 0, ',', '.') }}
                        </strong>

                        <span class="food-summary-label">
                            Total makanan ditemukan
                        </span>
                    </article>

                    <article class="food-summary-card">
                        <div class="food-summary-icon">
                            <x-heroicon-o-tag />
                        </div>

                        <strong class="food-summary-value">
                            {{ number_format($totalKategori, 0, ',', '.') }}
                        </strong>

                        <span class="food-summary-label">
                            Kategori tersedia
                        </span>
                    </article>

                    <article class="food-summary-card">
                        <div class="food-summary-icon">
                            <x-heroicon-o-funnel />
                        </div>

                        <strong class="food-summary-value">
                            {{ $filterAktif ? 'Aktif' : 'Semua' }}
                        </strong>

                        <span class="food-summary-label">
                            Status filter saat ini
                        </span>
                    </article>

                    <article class="food-summary-card">
                        <div class="food-summary-icon">
                            <x-heroicon-o-eye />
                        </div>

                        <strong class="food-summary-value">
                            {{
                                $visibilityLabels[
                                    $visibilityFilter
                                ] ?? 'Semua'
                            }}
                        </strong>

                        <span class="food-summary-label">
                            Jenis data ditampilkan
                        </span>
                    </article>
                </div>
            </div>
        </section>

        {{-- Notifikasi --}}
        @if (session('makanan_success'))
            <div class="food-alert food-alert-success">
                <x-heroicon-o-check-circle />

                <div>
                    {{ session('makanan_success') }}
                </div>
            </div>
        @endif

        @if (session('makanan_error'))
            <div class="food-alert food-alert-error">
                <x-heroicon-o-exclamation-circle />

                <div>
                    {{ session('makanan_error') }}
                </div>
            </div>
        @endif

        {{-- Form tambah dan edit --}}
        @if ($showForm)
            <section
                class="food-panel"
                wire:key="food-form-{{ $editingId ?? 'new' }}"
            >
                <div class="food-panel-head">
                    <div>
                        <h2 class="food-section-title">
                            {{
                                $editingId
                                    ? 'Edit Data Makanan'
                                    : 'Tambah Makanan Baru'
                            }}
                        </h2>

                        <p class="food-section-description">
                            Lengkapi nilai gizi per porsi agar makanan
                            dapat digunakan pada Meal Plan dan
                            perhitungan kalori.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="food-button food-button-soft"
                        wire:click="cancelForm"
                    >
                        <x-heroicon-o-x-mark />

                        <span>Tutup Form</span>
                    </button>
                </div>

                <div class="food-panel-body">
                    <form wire:submit.prevent="saveMakanan">
                        <div class="food-form-grid">
                            <div class="food-form-group is-full">
                                <label
                                    for="nama"
                                    class="food-label"
                                >
                                    Nama makanan
                                    <span class="food-required">*</span>
                                </label>

                                <input
                                    id="nama"
                                    type="text"
                                    class="food-input"
                                    placeholder="Contoh: nasi merah dengan ayam panggang"
                                    wire:model="nama"
                                >

                                @error('nama')
                                    <span class="food-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group">
                                <label
                                    for="kategori_makanan_id"
                                    class="food-label"
                                >
                                    Kategori
                                </label>

                                <select
                                    id="kategori_makanan_id"
                                    class="food-select"
                                    wire:model="kategori_makanan_id"
                                >
                                    <option value="">
                                        Tanpa kategori
                                    </option>

                                    @foreach ($kategoriOptions as $id => $label)
                                        <option value="{{ $id }}">
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('kategori_makanan_id')
                                    <span class="food-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group">
                                <label
                                    for="kalori"
                                    class="food-label"
                                >
                                    Kalori per porsi
                                    <span class="food-required">*</span>
                                </label>

                                <input
                                    id="kalori"
                                    type="number"
                                    min="0"
                                    max="10000"
                                    class="food-input"
                                    placeholder="Contoh: 350"
                                    wire:model="kalori"
                                >

                                <p class="food-field-hint">
                                    Nilai energi dalam satuan kkal.
                                </p>

                                @error('kalori')
                                    <span class="food-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group">
                                <label
                                    for="protein"
                                    class="food-label"
                                >
                                    Protein per porsi
                                </label>

                                <input
                                    id="protein"
                                    type="number"
                                    min="0"
                                    max="1000"
                                    step="0.1"
                                    class="food-input"
                                    placeholder="Dalam gram"
                                    wire:model="protein"
                                >

                                @error('protein')
                                    <span class="food-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group">
                                <label
                                    for="karbohidrat"
                                    class="food-label"
                                >
                                    Karbohidrat per porsi
                                </label>

                                <input
                                    id="karbohidrat"
                                    type="number"
                                    min="0"
                                    max="1000"
                                    step="0.1"
                                    class="food-input"
                                    placeholder="Dalam gram"
                                    wire:model="karbohidrat"
                                >

                                @error('karbohidrat')
                                    <span class="food-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group">
                                <label
                                    for="lemak"
                                    class="food-label"
                                >
                                    Lemak per porsi
                                </label>

                                <input
                                    id="lemak"
                                    type="number"
                                    min="0"
                                    max="1000"
                                    step="0.1"
                                    class="food-input"
                                    placeholder="Dalam gram"
                                    wire:model="lemak"
                                >

                                @error('lemak')
                                    <span class="food-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group">
                                <label
                                    for="porsi"
                                    class="food-label"
                                >
                                    Jumlah porsi
                                    <span class="food-required">*</span>
                                </label>

                                <input
                                    id="porsi"
                                    type="number"
                                    min="0.1"
                                    max="100"
                                    step="0.1"
                                    class="food-input"
                                    wire:model="porsi"
                                >

                                @error('porsi')
                                    <span class="food-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group">
                                <label
                                    for="satuan"
                                    class="food-label"
                                >
                                    Satuan
                                    <span class="food-required">*</span>
                                </label>

                                <input
                                    id="satuan"
                                    type="text"
                                    class="food-input"
                                    placeholder="Contoh: porsi, gram, mangkuk"
                                    wire:model="satuan"
                                >

                                @error('satuan')
                                    <span class="food-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group is-full">
                                <label
                                    for="deskripsi"
                                    class="food-label"
                                >
                                    Deskripsi makanan
                                </label>

                                <textarea
                                    id="deskripsi"
                                    class="food-textarea"
                                    placeholder="Jelaskan komposisi, cara penyajian, atau manfaat makanan."
                                    wire:model="deskripsi"
                                ></textarea>

                                @error('deskripsi')
                                    <span class="food-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group is-full">
                                <div class="food-switch-grid">
                                    <label class="food-switch-card">
                                        <input
                                            type="checkbox"
                                            wire:model="is_public"
                                        >

                                        <span>
                                            <strong class="food-switch-title">
                                                Tampilkan untuk publik
                                            </strong>

                                            <span class="food-switch-description">
                                                Makanan dapat dilihat dan
                                                digunakan oleh pengguna lain.
                                            </span>
                                        </span>
                                    </label>

                                    <label class="food-switch-card">
                                        <input
                                            type="checkbox"
                                            wire:model="is_recommended"
                                        >

                                        <span>
                                            <strong class="food-switch-title">
                                                Jadikan rekomendasi
                                            </strong>

                                            <span class="food-switch-description">
                                                Makanan dapat muncul pada
                                                rekomendasi dashboard.
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <div class="food-form-group is-full">
                                <label
                                    for="recommended_note"
                                    class="food-label"
                                >
                                    Catatan rekomendasi
                                </label>

                                <textarea
                                    id="recommended_note"
                                    class="food-textarea"
                                    placeholder="Contoh: tinggi protein dan cocok dikonsumsi setelah berolahraga."
                                    wire:model="recommended_note"
                                ></textarea>

                                @error('recommended_note')
                                    <span class="food-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="food-form-actions">
                            <button
                                type="button"
                                class="food-button food-button-soft"
                                wire:click="cancelForm"
                                wire:loading.attr="disabled"
                            >
                                <x-heroicon-o-x-mark />

                                <span>Batal</span>
                            </button>

                            <button
                                type="submit"
                                class="food-button food-button-primary"
                                wire:loading.attr="disabled"
                                wire:target="saveMakanan"
                            >
                                <x-heroicon-o-check />

                                <span
                                    wire:loading.remove
                                    wire:target="saveMakanan"
                                >
                                    {{
                                        $editingId
                                            ? 'Simpan Perubahan'
                                            : 'Simpan Makanan'
                                    }}
                                </span>

                                <span
                                    wire:loading
                                    wire:target="saveMakanan"
                                >
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        @endif

        {{-- Daftar makanan --}}
        <section class="food-panel">
            <div
                class="food-loading-line"
                wire:loading
                wire:target="search,kategoriFilter,visibilityFilter"
            ></div>

            <div class="food-panel-head">
                <div>
                    <h2 class="food-section-title">
                        Koleksi Makanan
                    </h2>

                    <p class="food-section-description">
                        Cari makanan, gunakan filter, kemudian kelola
                        data makanan yang kamu buat sendiri.
                    </p>
                </div>

                @if (! $showForm)
                    <button
                        type="button"
                        class="food-button food-button-primary"
                        wire:click="createMakanan"
                    >
                        <x-heroicon-o-plus />

                        <span>Tambah Makanan</span>
                    </button>
                @endif
            </div>

            <div class="food-panel-body">
                <div class="food-filter-area">
                    <div class="food-filter-grid">
                        <div class="food-form-group">
                            <label
                                for="search"
                                class="food-label"
                            >
                                Cari makanan
                            </label>

                            <div class="food-search-wrapper">
                                <x-heroicon-o-magnifying-glass
                                    class="food-search-icon"
                                />

                                <input
                                    id="search"
                                    type="search"
                                    class="food-input"
                                    placeholder="Cari nama atau deskripsi..."
                                    wire:model.live.debounce.400ms="search"
                                >
                            </div>
                        </div>

                        <div class="food-form-group">
                            <label
                                for="kategoriFilter"
                                class="food-label"
                            >
                                Kategori
                            </label>

                            <select
                                id="kategoriFilter"
                                class="food-select"
                                wire:model.live="kategoriFilter"
                            >
                                <option value="">
                                    Semua kategori
                                </option>

                                @foreach ($kategoriOptions as $id => $label)
                                    <option value="{{ $id }}">
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="food-form-group">
                            <label
                                for="visibilityFilter"
                                class="food-label"
                            >
                                Jenis makanan
                            </label>

                            <select
                                id="visibilityFilter"
                                class="food-select"
                                wire:model.live="visibilityFilter"
                            >
                                <option value="">
                                    Semua makanan
                                </option>

                                <option value="mine">
                                    Makanan saya
                                </option>

                                <option value="public">
                                    Makanan publik
                                </option>

                                <option value="recommended">
                                    Rekomendasi
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="food-filter-status">
                        <p class="food-filter-copy">
                            Filter akan diterapkan otomatis saat nilai
                            pencarian atau pilihan diubah.
                        </p>

                        @if ($filterAktif)
                            <span class="food-filter-badge">
                                <x-heroicon-o-funnel />

                                <span>Filter sedang aktif</span>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="food-list-top">
                    <p class="food-result-count">
                        Menampilkan
                        <strong>
                            {{ $makanans->count() }}
                        </strong>
                        dari
                        <strong>
                            {{ number_format($totalMakanan, 0, ',', '.') }}
                        </strong>
                        makanan.
                    </p>

                    @if (method_exists($makanans, 'currentPage'))
                        <p class="food-result-count">
                            Halaman
                            <strong>
                                {{ $makanans->currentPage() }}
                            </strong>
                            dari
                            <strong>
                                {{ max(1, $makanans->lastPage()) }}
                            </strong>
                        </p>
                    @endif
                </div>

                @if ($makanans->count() > 0)
                    <div class="food-grid">
                        @foreach ($makanans as $makanan)
                            @php
                                $foodSearchText = mb_strtolower(
                                    (
                                        $makanan['kategori']
                                        ?? ''
                                    )
                                    . ' '
                                    . (
                                        $makanan['nama']
                                        ?? ''
                                    )
                                );

                                $foodIcon = match (true) {
                                    str_contains(
                                        $foodSearchText,
                                        'minum'
                                    ),
                                    str_contains(
                                        $foodSearchText,
                                        'jus'
                                    ),
                                    str_contains(
                                        $foodSearchText,
                                        'susu'
                                    ) => '🥤',

                                    str_contains(
                                        $foodSearchText,
                                        'buah'
                                    ),
                                    str_contains(
                                        $foodSearchText,
                                        'apel'
                                    ),
                                    str_contains(
                                        $foodSearchText,
                                        'pisang'
                                    ) => '🍎',

                                    str_contains(
                                        $foodSearchText,
                                        'sayur'
                                    ),
                                    str_contains(
                                        $foodSearchText,
                                        'salad'
                                    ) => '🥗',

                                    str_contains(
                                        $foodSearchText,
                                        'ayam'
                                    ),
                                    str_contains(
                                        $foodSearchText,
                                        'daging'
                                    ) => '🍗',

                                    str_contains(
                                        $foodSearchText,
                                        'ikan'
                                    ),
                                    str_contains(
                                        $foodSearchText,
                                        'seafood'
                                    ) => '🐟',

                                    str_contains(
                                        $foodSearchText,
                                        'roti'
                                    ),
                                    str_contains(
                                        $foodSearchText,
                                        'sarapan'
                                    ) => '🍞',

                                    str_contains(
                                        $foodSearchText,
                                        'sup'
                                    ),
                                    str_contains(
                                        $foodSearchText,
                                        'soto'
                                    ) => '🍲',

                                    str_contains(
                                        $foodSearchText,
                                        'nasi'
                                    ),
                                    str_contains(
                                        $foodSearchText,
                                        'makan'
                                    ) => '🍛',

                                    default => '🥣',
                                };
                            @endphp

                            <article
                                class="food-card"
                                wire:key="food-card-{{ $makanan['id'] }}"
                            >
                                <div class="food-card-visual">
                                    <div
                                        class="food-card-icon"
                                        aria-hidden="true"
                                    >
                                        {{ $foodIcon }}
                                    </div>

                                    <span class="food-card-calorie">
                                        <x-heroicon-o-fire />

                                        {{
                                            number_format(
                                                (float) (
                                                    $makanan['kalori']
                                                    ?? 0
                                                ),
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }} kkal
                                    </span>
                                </div>

                                <div class="food-card-content">
                                    <div class="food-card-heading">
                                        <div>
                                            <h3 class="food-card-title">
                                                {{
                                                    $makanan['nama']
                                                    ?? 'Makanan tanpa nama'
                                                }}
                                            </h3>

                                            <span class="food-category">
                                                {{
                                                    $makanan['kategori']
                                                    ?? 'Tanpa kategori'
                                                }}
                                            </span>
                                        </div>
                                    </div>

                                    <p class="food-description">
                                        {{
                                            filled(
                                                $makanan['deskripsi']
                                                ?? null
                                            )
                                                ? $makanan['deskripsi']
                                                : 'Belum ada deskripsi untuk makanan ini.'
                                        }}
                                    </p>

                                    <div class="food-badges">
                                        @if (! empty($makanan['is_public']))
                                            <span class="food-badge food-badge-public">
                                                <x-heroicon-o-globe-alt />
                                                <span>Publik</span>
                                            </span>
                                        @else
                                            <span class="food-badge food-badge-private">
                                                <x-heroicon-o-lock-closed />
                                                <span>Pribadi</span>
                                            </span>
                                        @endif

                                        @if (! empty($makanan['is_recommended']))
                                            <span class="food-badge food-badge-recommended">
                                                <x-heroicon-o-star />
                                                <span>Rekomendasi</span>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="food-nutrition-grid">
                                        <div class="food-nutrition">
                                            <strong class="food-nutrition-value">
                                                {{
                                                    number_format(
                                                        (float) (
                                                            $makanan['protein']
                                                            ?? 0
                                                        ),
                                                        1,
                                                        ',',
                                                        '.'
                                                    )
                                                }}g
                                            </strong>

                                            <span class="food-nutrition-label">
                                                Protein
                                            </span>
                                        </div>

                                        <div class="food-nutrition">
                                            <strong class="food-nutrition-value">
                                                {{
                                                    number_format(
                                                        (float) (
                                                            $makanan[
                                                                'karbohidrat'
                                                            ]
                                                            ?? 0
                                                        ),
                                                        1,
                                                        ',',
                                                        '.'
                                                    )
                                                }}g
                                            </strong>

                                            <span class="food-nutrition-label">
                                                Karbo
                                            </span>
                                        </div>

                                        <div class="food-nutrition">
                                            <strong class="food-nutrition-value">
                                                {{
                                                    number_format(
                                                        (float) (
                                                            $makanan['lemak']
                                                            ?? 0
                                                        ),
                                                        1,
                                                        ',',
                                                        '.'
                                                    )
                                                }}g
                                            </strong>

                                            <span class="food-nutrition-label">
                                                Lemak
                                            </span>
                                        </div>
                                    </div>

                                    <div class="food-portion">
                                        <x-heroicon-o-scale />

                                        <span>
                                            {{
                                                number_format(
                                                    (float) (
                                                        $makanan['porsi']
                                                        ?? 1
                                                    ),
                                                    1,
                                                    ',',
                                                    '.'
                                                )
                                            }}
                                            {{
                                                $makanan['satuan']
                                                ?? 'porsi'
                                            }}
                                        </span>
                                    </div>

                                    @if (filled($makanan['recommended_note'] ?? null))
                                        <div class="food-recommendation-note">
                                            <strong>Catatan rekomendasi:</strong>
                                            {{ $makanan['recommended_note'] }}
                                        </div>
                                    @endif

                                    @if (! empty($makanan['is_owner']))
                                        <div class="food-card-actions">
                                            <button
                                                type="button"
                                                class="food-button food-button-outline"
                                                wire:click="editMakanan({{ (int) $makanan['id'] }})"
                                                wire:loading.attr="disabled"
                                            >
                                                <x-heroicon-o-pencil-square />

                                                <span>Edit</span>
                                            </button>

                                            <button
                                                type="button"
                                                class="food-button food-button-danger"
                                                wire:click="deleteMakanan({{ (int) $makanan['id'] }})"
                                                wire:confirm="Hapus makanan ini?"
                                                wire:loading.attr="disabled"
                                            >
                                                <x-heroicon-o-trash />

                                                <span>Hapus</span>
                                            </button>
                                        </div>
                                    @else
                                        <div class="food-public-notice">
                                            <x-heroicon-o-information-circle />

                                            <span>
                                                Makanan publik milik pengguna
                                                lain. Data hanya dapat dilihat.
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if (
                        method_exists($makanans, 'hasPages')
                        && $makanans->hasPages()
                    )
                        <div class="food-pagination">
                            {{ $makanans->links() }}
                        </div>
                    @endif
                @else
                    <div class="food-empty">
                        <div>
                            <div class="food-empty-icon">
                                @if ($filterAktif)
                                    <x-heroicon-o-magnifying-glass />
                                @else
                                    <x-heroicon-o-cake />
                                @endif
                            </div>

                            <h3 class="food-empty-title">
                                @if ($filterAktif)
                                    Makanan tidak ditemukan
                                @else
                                    Belum ada data makanan
                                @endif
                            </h3>

                            <p class="food-empty-description">
                                @if ($filterAktif)
                                    Tidak ada makanan yang cocok dengan
                                    pencarian atau filter saat ini.
                                    Ubah kata kunci dan pilihan filter.
                                @else
                                    Tambahkan makanan pertamamu agar
                                    dapat digunakan untuk menyusun
                                    Meal Plan dan rekomendasi harian.
                                @endif
                            </p>

                            @if (! $filterAktif)
                                <div class="food-empty-actions">
                                    <button
                                        type="button"
                                        class="food-button food-button-primary"
                                        wire:click="createMakanan"
                                    >
                                        <x-heroicon-o-plus />

                                        <span>Tambah Makanan</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
</div>