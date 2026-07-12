<div class="shopping-page">
    @php
        $totalItems = (int) ($summary['total'] ?? 0);
        $purchasedItems = (int) ($summary['purchased'] ?? 0);
        $pendingItems = (int) ($summary['pending'] ?? 0);
        $shoppingPercentage = min(
            100,
            max(0, (int) ($summary['percentage'] ?? 0))
        );

        $filterAktif = filled($search) || filled($statusFilter);

        $pageItems = collect($items->items());

        $groupedItems = $pageItems->groupBy(function ($item) {
            return filled($item['kategori'] ?? null)
                ? trim((string) $item['kategori'])
                : 'Umum';
        });

        $statusLabels = [
            '' => 'Semua status',
            'belum_dibeli' => 'Belum dibeli',
            'sudah_dibeli' => 'Sudah dibeli',
        ];
    @endphp

    <style>
        .shopping-page {
            --shop-blue: #7c9fd3;
            --shop-blue-dark: #5579ad;
            --shop-blue-soft: #e8f1ff;

            --shop-violet: #a697d6;
            --shop-violet-dark: #7160a5;
            --shop-violet-soft: #f0ecff;

            --shop-mint: #7fc7b2;
            --shop-mint-dark: #438674;
            --shop-mint-soft: #e6f8f2;

            --shop-peach: #eab186;
            --shop-peach-dark: #a76739;
            --shop-peach-soft: #fff1e6;

            --shop-yellow: #ddb85f;
            --shop-yellow-dark: #82631f;
            --shop-yellow-soft: #fff8df;

            --shop-red: #ba1a1a;
            --shop-red-dark: #8f1919;
            --shop-red-soft: #fff2f0;

            --shop-green: #347a63;
            --shop-green-soft: #e8f8f1;

            --shop-text: #191c20;
            --shop-muted: #626a76;
            --shop-faint: #8a919d;

            --shop-border: #dfe3eb;
            --shop-border-strong: #cbd2dd;

            --shop-surface: #ffffff;
            --shop-surface-soft: #f7f8fc;
            --shop-background: #fbfcff;

            --shop-shadow:
                0 12px 34px rgba(68, 83, 110, 0.07);

            --shop-shadow-hover:
                0 20px 48px rgba(68, 83, 110, 0.13);

            width: 100%;
            color: var(--shop-text);
        }

        .shopping-page * {
            box-sizing: border-box;
        }

        .shop-stack {
            display: grid;
            gap: 24px;
        }

        /*
        |--------------------------------------------------------------------------
        | Tombol
        |--------------------------------------------------------------------------
        */

        .shop-button {
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

        .shop-button:hover {
            transform: translateY(-1px);
        }

        .shop-button:disabled {
            cursor: wait;
            opacity: 0.58;
            transform: none;
        }

        .shop-button svg {
            width: 17px;
            height: 17px;
            flex: 0 0 17px;
        }

        .shop-button-primary {
            color: #ffffff;
            background: var(--shop-blue);
            box-shadow:
                0 10px 22px rgba(124, 159, 211, 0.24);
        }

        .shop-button-primary:hover {
            background: var(--shop-blue-dark);
        }

        .shop-button-outline {
            color: var(--shop-blue-dark);
            border-color: rgba(85, 121, 173, 0.48);
            background: #ffffff;
        }

        .shop-button-outline:hover {
            background: var(--shop-blue-soft);
        }

        .shop-button-soft {
            color: var(--shop-muted);
            border-color: var(--shop-border);
            background: var(--shop-surface-soft);
        }

        .shop-button-soft:hover {
            color: var(--shop-text);
            border-color: var(--shop-border-strong);
            background: #ffffff;
        }

        .shop-button-danger {
            color: var(--shop-red);
            border-color: #efb8b4;
            background: var(--shop-red-soft);
        }

        .shop-button-danger:hover {
            color: #ffffff;
            border-color: var(--shop-red);
            background: var(--shop-red);
        }

        .shop-button-success {
            color: #ffffff;
            background: var(--shop-mint-dark);
        }

        .shop-button-success:hover {
            background: #356f60;
        }

        .shop-button-block {
            width: 100%;
        }

        /*
        |--------------------------------------------------------------------------
        | Hero
        |--------------------------------------------------------------------------
        */

        .shop-hero {
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

        .shop-hero::before,
        .shop-hero::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
        }

        .shop-hero::before {
            top: -110px;
            right: -70px;
            width: 280px;
            height: 280px;
            background: rgba(124, 159, 211, 0.18);
        }

        .shop-hero::after {
            right: 18%;
            bottom: -110px;
            width: 190px;
            height: 190px;
            background: rgba(127, 199, 178, 0.22);
        }

        .shop-hero-layout {
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

        .shop-hero-content {
            max-width: 720px;
        }

        .shop-kicker {
            min-height: 31px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 11px;
            border: 1px solid rgba(85, 121, 173, 0.22);
            border-radius: 999px;
            color: var(--shop-blue-dark);
            background: rgba(255, 255, 255, 0.68);
            backdrop-filter: blur(8px);
            font-size: 10px;
            line-height: 1;
            font-weight: 700;
        }

        .shop-kicker svg {
            width: 15px;
            height: 15px;
        }

        .shop-hero-title {
            max-width: 690px;
            margin: 18px 0 0;
            color: var(--shop-text);
            font-size: clamp(34px, 4vw, 48px);
            line-height: 1.1;
            font-weight: 700;
            letter-spacing: -0.045em;
        }

        .shop-hero-title span {
            color: var(--shop-blue-dark);
        }

        .shop-hero-description {
            max-width: 620px;
            margin: 15px 0 0;
            color: #505967;
            font-size: 13px;
            line-height: 1.75;
        }

        .shop-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 24px;
        }

        .shop-progress-card {
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.78);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.62);
            box-shadow:
                0 14px 30px rgba(68, 83, 110, 0.08);
            backdrop-filter: blur(12px);
        }

        .shop-progress-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
        }

        .shop-progress-title {
            margin: 0;
            color: var(--shop-text);
            font-size: 13px;
            line-height: 1.4;
            font-weight: 700;
        }

        .shop-progress-copy {
            margin: 5px 0 0;
            color: var(--shop-muted);
            font-size: 9px;
            line-height: 1.5;
        }

        .shop-progress-percentage {
            color: var(--shop-blue-dark);
            font-size: 24px;
            line-height: 1;
            font-weight: 700;
        }

        .shop-progress-track {
            width: 100%;
            height: 10px;
            overflow: hidden;
            margin-top: 18px;
            border-radius: 999px;
            background: rgba(212, 218, 228, 0.78);
        }

        .shop-progress-bar {
            height: 100%;
            border-radius: inherit;
            background:
                linear-gradient(
                    90deg,
                    var(--shop-blue),
                    var(--shop-violet),
                    var(--shop-mint)
                );
            transition: width 350ms ease;
        }

        .shop-progress-meta {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-top: 17px;
        }

        .shop-progress-stat {
            padding: 11px;
            border: 1px solid rgba(203, 210, 221, 0.78);
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.78);
        }

        .shop-progress-stat strong {
            display: block;
            color: var(--shop-text);
            font-size: 14px;
            line-height: 1.2;
            font-weight: 700;
        }

        .shop-progress-stat span {
            display: block;
            margin-top: 4px;
            color: var(--shop-muted);
            font-size: 8px;
            line-height: 1.4;
            font-weight: 600;
        }

        /*
        |--------------------------------------------------------------------------
        | Alert
        |--------------------------------------------------------------------------
        */

        .shop-alert {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            padding: 14px 16px;
            border: 1px solid var(--shop-border);
            border-radius: 14px;
            font-size: 11px;
            line-height: 1.6;
            font-weight: 600;
        }

        .shop-alert svg {
            width: 19px;
            height: 19px;
            flex: 0 0 19px;
        }

        .shop-alert-success {
            color: var(--shop-green);
            border-color: #badfd2;
            background: var(--shop-green-soft);
        }

        .shop-alert-error {
            color: var(--shop-red-dark);
            border-color: #efb8b4;
            background: var(--shop-red-soft);
        }

        /*
        |--------------------------------------------------------------------------
        | Ringkasan
        |--------------------------------------------------------------------------
        */

        .shop-summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .shop-summary-card {
            min-width: 0;
            padding: 17px;
            border: 1px solid var(--shop-border);
            border-radius: 17px;
            background: #ffffff;
            box-shadow: var(--shop-shadow);
        }

        .shop-summary-icon {
            width: 39px;
            height: 39px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            color: var(--shop-blue-dark);
            background: var(--shop-blue-soft);
        }

        .shop-summary-card:nth-child(2)
        .shop-summary-icon {
            color: var(--shop-green);
            background: var(--shop-green-soft);
        }

        .shop-summary-card:nth-child(3)
        .shop-summary-icon {
            color: var(--shop-peach-dark);
            background: var(--shop-peach-soft);
        }

        .shop-summary-card:nth-child(4)
        .shop-summary-icon {
            color: var(--shop-violet-dark);
            background: var(--shop-violet-soft);
        }

        .shop-summary-icon svg {
            width: 20px;
            height: 20px;
        }

        .shop-summary-value {
            display: block;
            overflow: hidden;
            margin-top: 12px;
            color: var(--shop-text);
            font-size: 21px;
            line-height: 1.15;
            font-weight: 700;
            letter-spacing: -0.025em;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .shop-summary-label {
            display: block;
            margin-top: 5px;
            color: var(--shop-muted);
            font-size: 8px;
            line-height: 1.45;
            font-weight: 600;
        }

        /*
        |--------------------------------------------------------------------------
        | Panel utama
        |--------------------------------------------------------------------------
        */

        .shop-content-grid {
            display: grid;
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
            align-items: start;
            gap: 24px;
        }

        .shop-panel {
            overflow: hidden;
            border: 1px solid var(--shop-border);
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.97);
            box-shadow: var(--shop-shadow);
        }

        .shop-panel-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            padding: 22px 24px;
            border-bottom: 1px solid var(--shop-border);
        }

        .shop-panel-body {
            padding: 24px;
        }

        .shop-section-title {
            margin: 0;
            color: var(--shop-text);
            font-size: 20px;
            line-height: 1.35;
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        .shop-section-description {
            max-width: 720px;
            margin: 6px 0 0;
            color: var(--shop-muted);
            font-size: 11px;
            line-height: 1.65;
        }

        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        .shop-filter-area {
            padding: 16px;
            border: 1px solid var(--shop-border);
            border-radius: 15px;
            background:
                linear-gradient(
                    135deg,
                    #f9fbff,
                    #fbfaff
                );
        }

        .shop-filter-grid {
            display: grid;
            grid-template-columns:
                minmax(240px, 1.35fr)
                minmax(180px, 0.65fr);
            gap: 12px;
        }

        .shop-form-group {
            min-width: 0;
        }

        .shop-label {
            display: block;
            margin: 0 0 7px;
            color: var(--shop-muted);
            font-size: 9px;
            line-height: 1.3;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .shop-required {
            color: var(--shop-red);
        }

        .shop-input,
        .shop-select,
        .shop-textarea {
            width: 100%;
            border: 1px solid var(--shop-border-strong);
            border-radius: 10px;
            color: var(--shop-text);
            background: #fbfcff;
            outline: none;
            font-size: 11px;
            transition:
                border-color 180ms ease,
                box-shadow 180ms ease,
                background 180ms ease;
        }

        .shop-input,
        .shop-select {
            min-height: 44px;
            padding: 10px 12px;
        }

        .shop-textarea {
            min-height: 100px;
            padding: 11px 12px;
            resize: vertical;
        }

        .shop-input::placeholder,
        .shop-textarea::placeholder {
            color: #a0a6b0;
        }

        .shop-input:focus,
        .shop-select:focus,
        .shop-textarea:focus {
            border-color: var(--shop-blue);
            background: #ffffff;
            box-shadow:
                0 0 0 3px rgba(124, 159, 211, 0.14);
        }

        .shop-search-wrapper {
            position: relative;
        }

        .shop-search-icon {
            position: absolute;
            z-index: 2;
            top: 50%;
            left: 13px;
            width: 17px;
            height: 17px;
            color: var(--shop-faint);
            transform: translateY(-50%);
            pointer-events: none;
        }

        .shop-search-wrapper .shop-input {
            padding-left: 40px;
        }

        .shop-filter-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-top: 12px;
        }

        .shop-filter-copy {
            color: var(--shop-muted);
            font-size: 9px;
            line-height: 1.5;
        }

        .shop-filter-badge {
            min-height: 28px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border: 1px solid #cfdbef;
            border-radius: 999px;
            color: var(--shop-blue-dark);
            background: var(--shop-blue-soft);
            font-size: 8px;
            line-height: 1;
            font-weight: 700;
        }

        .shop-filter-badge svg {
            width: 13px;
            height: 13px;
        }

        /*
        |--------------------------------------------------------------------------
        | Grup kategori
        |--------------------------------------------------------------------------
        */

        .shop-group-list {
            display: grid;
            gap: 16px;
            margin-top: 20px;
        }

        .shop-category-group {
            overflow: hidden;
            border: 1px solid var(--shop-border);
            border-radius: 17px;
            background: var(--shop-background);
        }

        .shop-category-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 14px 16px;
            border-bottom: 1px solid var(--shop-border);
            background: #ffffff;
        }

        .shop-category-title-wrap {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .shop-category-icon {
            width: 38px;
            height: 38px;
            flex: 0 0 38px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            color: var(--shop-blue-dark);
            background: var(--shop-blue-soft);
        }

        .shop-category-group:nth-child(4n + 2)
        .shop-category-icon {
            color: var(--shop-mint-dark);
            background: var(--shop-mint-soft);
        }

        .shop-category-group:nth-child(4n + 3)
        .shop-category-icon {
            color: var(--shop-violet-dark);
            background: var(--shop-violet-soft);
        }

        .shop-category-group:nth-child(4n + 4)
        .shop-category-icon {
            color: var(--shop-peach-dark);
            background: var(--shop-peach-soft);
        }

        .shop-category-icon svg {
            width: 19px;
            height: 19px;
        }

        .shop-category-title {
            margin: 0;
            color: var(--shop-text);
            font-size: 12px;
            line-height: 1.4;
            font-weight: 700;
        }

        .shop-category-copy {
            margin: 3px 0 0;
            color: var(--shop-faint);
            font-size: 8px;
            line-height: 1.4;
        }

        .shop-category-count {
            min-height: 29px;
            display: inline-flex;
            align-items: center;
            padding: 6px 9px;
            border: 1px solid var(--shop-border);
            border-radius: 999px;
            color: var(--shop-muted);
            background: var(--shop-surface-soft);
            font-size: 8px;
            line-height: 1;
            font-weight: 700;
            white-space: nowrap;
        }

        .shop-item-list {
            display: grid;
            gap: 9px;
            padding: 13px;
        }

        /*
        |--------------------------------------------------------------------------
        | Item belanja
        |--------------------------------------------------------------------------
        */

        .shop-item {
            display: grid;
            grid-template-columns:
                auto
                minmax(0, 1fr)
                auto;
            align-items: center;
            gap: 13px;
            padding: 14px;
            border: 1px solid var(--shop-border);
            border-radius: 14px;
            background: #ffffff;
            transition:
                transform 180ms ease,
                box-shadow 180ms ease,
                border-color 180ms ease,
                opacity 180ms ease;
        }

        .shop-item:hover {
            border-color: #cad5e5;
            box-shadow: var(--shop-shadow-hover);
            transform: translateY(-1px);
        }

        .shop-item.is-purchased {
            opacity: 0.78;
            background: #fbfcfc;
        }

        .shop-check-button {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            padding: 0;
            border: 1px solid var(--shop-border-strong);
            border-radius: 13px;
            color: var(--shop-blue-dark);
            background: var(--shop-blue-soft);
            cursor: pointer;
            transition:
                transform 180ms ease,
                background 180ms ease,
                border-color 180ms ease;
        }

        .shop-check-button:hover {
            transform: scale(1.04);
        }

        .shop-check-button.is-purchased {
            color: var(--shop-green);
            border-color: #b9dfd1;
            background: var(--shop-green-soft);
        }

        .shop-check-button svg {
            width: 21px;
            height: 21px;
        }

        .shop-item-main {
            min-width: 0;
        }

        .shop-item-name {
            margin: 0;
            color: var(--shop-text);
            font-size: 12px;
            line-height: 1.4;
            font-weight: 700;
        }

        .shop-item-name.is-purchased {
            color: var(--shop-faint);
            text-decoration: line-through;
        }

        .shop-item-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px;
            margin-top: 6px;
            color: var(--shop-muted);
            font-size: 9px;
            line-height: 1.5;
        }

        .shop-item-quantity {
            min-height: 25px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 8px;
            border: 1px solid var(--shop-border);
            border-radius: 999px;
            color: var(--shop-blue-dark);
            background: var(--shop-blue-soft);
            font-size: 8px;
            line-height: 1;
            font-weight: 700;
        }

        .shop-item-quantity svg {
            width: 12px;
            height: 12px;
        }

        .shop-item-status {
            min-height: 25px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 8px;
            border: 1px solid var(--shop-border);
            border-radius: 999px;
            font-size: 8px;
            line-height: 1;
            font-weight: 700;
        }

        .shop-item-status.is-purchased {
            color: var(--shop-green);
            border-color: #b9dfd1;
            background: var(--shop-green-soft);
        }

        .shop-item-status.is-pending {
            color: var(--shop-peach-dark);
            border-color: #efd2bb;
            background: var(--shop-peach-soft);
        }

        .shop-item-status svg {
            width: 12px;
            height: 12px;
        }

        .shop-item-note {
            display: flex;
            align-items: flex-start;
            gap: 7px;
            margin-top: 8px;
            padding: 8px 9px;
            border: 1px solid #d9d0f1;
            border-radius: 9px;
            color: var(--shop-violet-dark);
            background: var(--shop-violet-soft);
            font-size: 8px;
            line-height: 1.55;
        }

        .shop-item-note svg {
            width: 13px;
            height: 13px;
            flex: 0 0 13px;
        }

        .shop-item-actions {
            display: flex;
            flex-direction: column;
            gap: 7px;
            min-width: 95px;
        }

        .shop-item-actions .shop-button {
            min-height: 34px;
            padding: 7px 10px;
            font-size: 8px;
        }

        /*
        |--------------------------------------------------------------------------
        | Form
        |--------------------------------------------------------------------------
        */

        .shop-form-grid {
            display: grid;
            gap: 14px;
        }

        .shop-form-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .shop-field-error {
            display: block;
            margin-top: 6px;
            color: var(--shop-red);
            font-size: 9px;
            line-height: 1.4;
        }

        .shop-field-hint {
            margin: 6px 0 0;
            color: var(--shop-faint);
            font-size: 8px;
            line-height: 1.5;
        }

        .shop-checkbox-card {
            min-height: 84px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px;
            border: 1px solid var(--shop-border);
            border-radius: 14px;
            background: var(--shop-surface-soft);
            cursor: pointer;
            transition:
                border-color 180ms ease,
                background 180ms ease;
        }

        .shop-checkbox-card:hover {
            border-color: var(--shop-mint);
            background: var(--shop-mint-soft);
        }

        .shop-checkbox-card input {
            width: 18px;
            height: 18px;
            flex: 0 0 18px;
            margin-top: 1px;
            accent-color: var(--shop-mint-dark);
        }

        .shop-checkbox-title {
            display: block;
            color: var(--shop-text);
            font-size: 10px;
            line-height: 1.4;
            font-weight: 700;
        }

        .shop-checkbox-copy {
            display: block;
            margin-top: 4px;
            color: var(--shop-muted);
            font-size: 8px;
            line-height: 1.55;
        }

        .shop-form-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 9px;
            margin-top: 18px;
        }

        /*
        |--------------------------------------------------------------------------
        | Empty
        |--------------------------------------------------------------------------
        */

        .shop-empty {
            min-height: 270px;
            display: grid;
            place-items: center;
            padding: 30px;
            border: 1px dashed var(--shop-border-strong);
            border-radius: 17px;
            background: #fbfcff;
            text-align: center;
        }

        .shop-empty.is-form {
            min-height: 380px;
        }

        .shop-empty-icon {
            width: 58px;
            height: 58px;
            display: grid;
            place-items: center;
            margin: 0 auto 13px;
            border-radius: 18px;
            color: var(--shop-blue-dark);
            background: var(--shop-blue-soft);
        }

        .shop-empty-icon svg {
            width: 28px;
            height: 28px;
        }

        .shop-empty-title {
            margin: 0;
            color: var(--shop-text);
            font-size: 14px;
            line-height: 1.4;
            font-weight: 700;
        }

        .shop-empty-copy {
            max-width: 430px;
            margin: 7px auto 0;
            color: var(--shop-muted);
            font-size: 9px;
            line-height: 1.65;
        }

        .shop-empty-actions {
            display: flex;
            justify-content: center;
            margin-top: 16px;
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination dan loading
        |--------------------------------------------------------------------------
        */

        .shop-pagination {
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid var(--shop-border);
        }

        .shop-loading-line {
            height: 3px;
            overflow: hidden;
            margin-bottom: -3px;
            border-radius: 999px;
            background: transparent;
        }

        .shop-loading-line::after {
            content: "";
            width: 38%;
            height: 100%;
            display: block;
            border-radius: inherit;
            background:
                linear-gradient(
                    90deg,
                    var(--shop-blue),
                    var(--shop-violet),
                    var(--shop-mint)
                );
            animation:
                shop-loading 900ms ease-in-out infinite alternate;
        }

        @keyframes shop-loading {
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

        @media (max-width: 1180px) {
            .shop-hero-layout,
            .shop-content-grid {
                grid-template-columns: 1fr;
            }

            .shop-progress-card {
                max-width: 620px;
            }

            .shop-summary-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 760px) {
            .shop-stack {
                gap: 17px;
            }

            .shop-hero {
                min-height: auto;
                padding: 24px 20px;
                border-radius: 18px;
            }

            .shop-hero-title {
                font-size: 31px;
            }

            .shop-hero-description {
                font-size: 12px;
            }

            .shop-hero-actions {
                display: grid;
                grid-template-columns: 1fr;
            }

            .shop-hero-actions .shop-button {
                width: 100%;
            }

            .shop-panel {
                border-radius: 18px;
            }

            .shop-panel-head {
                flex-direction: column;
                padding: 18px;
            }

            .shop-panel-head .shop-button {
                width: 100%;
            }

            .shop-panel-body {
                padding: 18px;
            }

            .shop-filter-grid,
            .shop-form-row {
                grid-template-columns: 1fr;
            }

            .shop-filter-status {
                align-items: flex-start;
                flex-direction: column;
            }

            .shop-item {
                grid-template-columns:
                    auto
                    minmax(0, 1fr);
            }

            .shop-item-actions {
                grid-column: 1 / -1;
                display: grid;
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
                min-width: 0;
            }

            .shop-form-actions {
                display: grid;
                grid-template-columns: 1fr;
            }

            .shop-form-actions .shop-button {
                width: 100%;
            }
        }

        @media (max-width: 460px) {
            .shop-summary-grid,
            .shop-progress-meta,
            .shop-item-actions {
                grid-template-columns: 1fr;
            }

            .shop-item {
                grid-template-columns: 1fr;
            }

            .shop-check-button {
                width: 100%;
            }

            .shop-hero-title {
                font-size: 28px;
            }
        }
    
        /* shopping-food-nutrition-fields */

        .shopping-nutrition-box {
            margin: 16px 0;
            padding: 16px;
            border: 1px solid #d9e2ef;
            border-radius: 15px;
            background:
                linear-gradient(
                    135deg,
                    #f7faff 0%,
                    #faf9ff 100%
                );
        }

        .shopping-nutrition-header {
            margin-bottom: 14px;
        }

        .shopping-nutrition-title {
            margin: 0;
            color: #1f2732;
            font-size: 14px;
            line-height: 1.4;
            font-weight: 800;
        }

        .shopping-nutrition-description {
            margin: 5px 0 0;
            color: #747e8c;
            font-size: 10px;
            line-height: 1.55;
        }

        .shopping-nutrition-grid {
            display: grid;
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .shopping-nutrition-field {
            min-width: 0;
        }

        .shopping-nutrition-field.is-full {
            grid-column: 1 / -1;
        }

        .shopping-nutrition-label {
            display: block;
            margin-bottom: 6px;
            color: #596475;
            font-size: 10px;
            line-height: 1.4;
            font-weight: 750;
        }

        .shopping-nutrition-required {
            color: #d94f5c;
        }

        .shopping-nutrition-input,
        .shopping-nutrition-select {
            width: 100%;
            min-height: 42px;
            padding: 10px 12px;
            border: 1px solid #cbd7e7;
            border-radius: 10px;
            outline: none;
            color: #202832;
            background: #ffffff;
            font: inherit;
            font-size: 11px;
            transition:
                border-color 180ms ease,
                box-shadow 180ms ease;
        }

        .shopping-nutrition-input:focus,
        .shopping-nutrition-select:focus {
            border-color: #7d9fd3;
            box-shadow:
                0 0 0 3px
                rgba(125, 159, 211, 0.14);
        }

        .shopping-nutrition-select-shell {
            position: relative;
            width: 100%;
        }

        .shopping-nutrition-select {
            padding-right: 46px;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: none;
        }

        .shopping-nutrition-arrow {
            position: absolute;
            z-index: 3;
            top: 50%;
            right: 9px;

            width: 27px;
            height: 27px;

            display: grid;
            place-items: center;

            border: 1px solid #d4deed;
            border-radius: 8px;

            color: #5579ad;
            background: #eaf1ff;

            pointer-events: none;

            transform: translateY(-50%);
            transition:
                transform 180ms ease,
                color 180ms ease,
                background 180ms ease;
        }

        .shopping-nutrition-arrow svg {
            width: 14px;
            height: 14px;
        }

        .shopping-nutrition-select-shell:focus-within
        .shopping-nutrition-arrow {
            color: #ffffff;
            background: #7d9fd3;
            transform:
                translateY(-50%)
                rotate(180deg);
        }

        .shopping-nutrition-error {
            display: block;
            margin-top: 5px;
            color: #c94255;
            font-size: 9px;
            line-height: 1.45;
        }

        .shopping-nutrition-help {
            margin: 11px 0 0;
            padding: 9px 10px;
            border: 1px solid #cfe3da;
            border-radius: 9px;
            color: #477968;
            background: #eef9f5;
            font-size: 9px;
            line-height: 1.5;
        }

        @media (max-width: 520px) {
            .shopping-nutrition-grid {
                grid-template-columns: 1fr;
            }

            .shopping-nutrition-field.is-full {
                grid-column: auto;
            }
        }


    </style>

    <div class="shop-stack">
        {{-- Hero --}}
        <section class="shop-hero">
            <div class="shop-hero-layout">
                <div class="shop-hero-content">
                    <div class="shop-kicker">
                        <x-heroicon-o-shopping-cart />

                        <span>Daftar Belanja</span>
                    </div>

                    <h1 class="shop-hero-title">
                        Belanja lebih terencana,
                        <span>tanpa ada yang tertinggal.</span>
                    </h1>

                    <p class="shop-hero-description">
                        Catat bahan makanan, jumlah, kategori, dan
                        kebutuhan khusus sebelum berbelanja. Tandai
                        item yang sudah dibeli agar progres selalu jelas.
                    </p>

                    <div class="shop-hero-actions">
                        <button
                            type="button"
                            class="shop-button shop-button-primary"
                            wire:click="createItem"
                        >
                            <x-heroicon-o-plus />

                            <span>Tambah Item</span>
                        </button>

                        <a
                            href="{{ route('user.meal-plan') }}"
                            class="shop-button shop-button-outline"
                        >
                            <x-heroicon-o-calendar-days />

                            <span>Buka Meal Plan</span>
                        </a>
                    </div>
                </div>

                <aside class="shop-progress-card">
                    <div class="shop-progress-head">
                        <div>
                            <h2 class="shop-progress-title">
                                Progress Belanja
                            </h2>

                            <p class="shop-progress-copy">
                                Item yang sudah dibeli dibandingkan
                                dengan seluruh kebutuhan belanja.
                            </p>
                        </div>

                        <strong class="shop-progress-percentage">
                            {{ $shoppingPercentage }}%
                        </strong>
                    </div>

                    <div
                        class="shop-progress-track"
                        role="progressbar"
                        aria-label="Progress daftar belanja"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        aria-valuenow="{{ $shoppingPercentage }}"
                    >
                        <div
                            class="shop-progress-bar"
                            style="width: {{ $shoppingPercentage }}%;"
                        ></div>
                    </div>

                    <div class="shop-progress-meta">
                        <article class="shop-progress-stat">
                            <strong>
                                {{ $purchasedItems }} item
                            </strong>

                            <span>Sudah dibeli</span>
                        </article>

                        <article class="shop-progress-stat">
                            <strong>
                                {{ $pendingItems }} item
                            </strong>

                            <span>Masih diperlukan</span>
                        </article>
                    </div>
                </aside>
            </div>
        </section>

        {{-- Notifikasi --}}
        @if (session('belanja_success'))
            <div class="shop-alert shop-alert-success">
                <x-heroicon-o-check-circle />

                <div>
                    {{ session('belanja_success') }}
                </div>
            </div>
        @endif

        @if (session('belanja_error'))
            <div class="shop-alert shop-alert-error">
                <x-heroicon-o-exclamation-circle />

                <div>
                    {{ session('belanja_error') }}
                </div>
            </div>
        @endif

        {{-- Ringkasan --}}
        <section class="shop-summary-grid">
            <article class="shop-summary-card">
                <div class="shop-summary-icon">
                    <x-heroicon-o-list-bullet />
                </div>

                <strong class="shop-summary-value">
                    {{ number_format($totalItems, 0, ',', '.') }}
                </strong>

                <span class="shop-summary-label">
                    Total item belanja
                </span>
            </article>

            <article class="shop-summary-card">
                <div class="shop-summary-icon">
                    <x-heroicon-o-check-circle />
                </div>

                <strong class="shop-summary-value">
                    {{ number_format($purchasedItems, 0, ',', '.') }}
                </strong>

                <span class="shop-summary-label">
                    Sudah dibeli
                </span>
            </article>

            <article class="shop-summary-card">
                <div class="shop-summary-icon">
                    <x-heroicon-o-clock />
                </div>

                <strong class="shop-summary-value">
                    {{ number_format($pendingItems, 0, ',', '.') }}
                </strong>

                <span class="shop-summary-label">
                    Belum dibeli
                </span>
            </article>

            <article class="shop-summary-card">
                <div class="shop-summary-icon">
                    <x-heroicon-o-chart-bar />
                </div>

                <strong class="shop-summary-value">
                    {{ $shoppingPercentage }}%
                </strong>

                <span class="shop-summary-label">
                    Penyelesaian belanja
                </span>
            </article>
        </section>

        {{-- Daftar dan form --}}
        <section class="shop-content-grid">
            <article class="shop-panel">
                <div
                    class="shop-loading-line"
                    wire:loading
                    wire:target="search,statusFilter,togglePurchased,deleteItem,clearPurchasedItems"
                ></div>

                <div class="shop-panel-head">
                    <div>
                        <h2 class="shop-section-title">
                            Kebutuhan Belanja
                        </h2>

                        <p class="shop-section-description">
                            Item pada halaman ini dikelompokkan
                            berdasarkan kategori agar lebih mudah
                            diperiksa ketika berbelanja.
                        </p>
                    </div>

                    @if ($purchasedItems > 0)
                        <button
                            type="button"
                            class="shop-button shop-button-danger"
                            wire:click="clearPurchasedItems"
                            wire:confirm="Hapus semua item yang sudah dibeli?"
                            wire:loading.attr="disabled"
                            wire:target="clearPurchasedItems"
                        >
                            <x-heroicon-o-trash />

                            <span
                                wire:loading.remove
                                wire:target="clearPurchasedItems"
                            >
                                Bersihkan Selesai
                            </span>

                            <span
                                wire:loading
                                wire:target="clearPurchasedItems"
                            >
                                Membersihkan...
                            </span>
                        </button>
                    @endif
                </div>

                <div class="shop-panel-body">
                    <div class="shop-filter-area">
                        <div class="shop-filter-grid">
                            <div class="shop-form-group">
                                <label
                                    for="search"
                                    class="shop-label"
                                >
                                    Cari item belanja
                                </label>

                                <div class="shop-search-wrapper">
                                    <x-heroicon-o-magnifying-glass
                                        class="shop-search-icon"
                                    />

                                    <input
                                        id="search"
                                        type="search"
                                        class="shop-input"
                                        placeholder="Cari bahan, kategori, atau catatan..."
                                        wire:model.live.debounce.400ms="search"
                                    >
                                </div>
                            </div>

                            <div class="shop-form-group">
                                <label
                                    for="statusFilter"
                                    class="shop-label"
                                >
                                    Status item
                                </label>

                                <select
                                    id="statusFilter"
                                    class="shop-select"
                                    wire:model.live="statusFilter"
                                >
                                    <option value="">
                                        Semua status
                                    </option>

                                    <option value="belum_dibeli">
                                        Belum dibeli
                                    </option>

                                    <option value="sudah_dibeli">
                                        Sudah dibeli
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="shop-filter-status">
                            <p class="shop-filter-copy">
                                Filter diterapkan otomatis saat kata
                                kunci atau status diubah.
                            </p>

                            @if ($filterAktif)
                                <span class="shop-filter-badge">
                                    <x-heroicon-o-funnel />

                                    <span>
                                        {{
                                            $statusLabels[
                                                $statusFilter
                                            ] ?? 'Filter aktif'
                                        }}
                                    </span>
                                </span>
                            @endif
                        </div>
                    </div>

                    @if ($items->count() > 0)
                        <div class="shop-group-list">
                            @foreach ($groupedItems as $category => $categoryItems)
                                <section
                                    class="shop-category-group"
                                    wire:key="shopping-category-{{ md5($category) }}"
                                >
                                    <div class="shop-category-head">
                                        <div class="shop-category-title-wrap">
                                            <div class="shop-category-icon">
                                                <x-heroicon-o-tag />
                                            </div>

                                            <div>
                                                <h3 class="shop-category-title">
                                                    {{ $category }}
                                                </h3>

                                                <p class="shop-category-copy">
                                                    {{
                                                        $categoryItems
                                                            ->where(
                                                                'sudah_dibeli',
                                                                true
                                                            )
                                                            ->count()
                                                    }}
                                                    dari
                                                    {{ $categoryItems->count() }}
                                                    item sudah dibeli
                                                </p>
                                            </div>
                                        </div>

                                        <span class="shop-category-count">
                                            {{ $categoryItems->count() }}
                                            item
                                        </span>
                                    </div>

                                    <div class="shop-item-list">
                                        @foreach ($categoryItems as $item)
                                            <article
                                                class="shop-item {{
                                                    ! empty(
                                                        $item['sudah_dibeli']
                                                    )
                                                        ? 'is-purchased'
                                                        : ''
                                                }}"
                                                wire:key="shopping-item-{{ $item['id'] }}"
                                            >
                                                <button
                                                    type="button"
                                                    class="shop-check-button {{
                                                        ! empty(
                                                            $item[
                                                                'sudah_dibeli'
                                                            ]
                                                        )
                                                            ? 'is-purchased'
                                                            : ''
                                                    }}"
                                                    wire:click="togglePurchased({{ (int) $item['id'] }})"
                                                    wire:loading.attr="disabled"
                                                    title="{{
                                                        ! empty(
                                                            $item[
                                                                'sudah_dibeli'
                                                            ]
                                                        )
                                                            ? 'Tandai belum dibeli'
                                                            : 'Tandai sudah dibeli'
                                                    }}"
                                                >
                                                    @if (! empty($item['sudah_dibeli']))
                                                        <x-heroicon-o-check />
                                                    @else
                                                        <x-heroicon-o-shopping-cart />
                                                    @endif
                                                </button>

                                                <div class="shop-item-main">
                                                    <h4
                                                        class="shop-item-name {{
                                                            ! empty(
                                                                $item[
                                                                    'sudah_dibeli'
                                                                ]
                                                            )
                                                                ? 'is-purchased'
                                                                : ''
                                                        }}"
                                                    >
                                                        {{
                                                            $item['nama_item']
                                                            ?? 'Item tanpa nama'
                                                        }}
                                                    </h4>

                                                    <div class="shop-item-meta">
                                                        <span class="shop-item-quantity">
                                                            <x-heroicon-o-scale />

                                                            {{
                                                                number_format(
                                                                    (float) (
                                                                        $item[
                                                                            'jumlah'
                                                                        ]
                                                                        ?? 1
                                                                    ),
                                                                    1,
                                                                    ',',
                                                                    '.'
                                                                )
                                                            }}

                                                            {{
                                                                $item['satuan']
                                                                ?? 'pcs'
                                                            }}
                                                        </span>

                                                        @if (! empty($item['sudah_dibeli']))
                                                            <span class="shop-item-status is-purchased">
                                                                <x-heroicon-o-check-circle />

                                                                Sudah dibeli
                                                            </span>
                                                        @else
                                                            <span class="shop-item-status is-pending">
                                                                <x-heroicon-o-clock />

                                                                Belum dibeli
                                                            </span>
                                                        @endif
                                                    </div>

                                                    @if (filled($item['catatan'] ?? null))
                                                        <div class="shop-item-note">
                                                            <x-heroicon-o-document-text />

                                                            <span>
                                                                {{ $item['catatan'] }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="shop-item-actions">
                                                    <button
                                                        type="button"
                                                        class="shop-button shop-button-outline"
                                                        wire:click="editItem({{ (int) $item['id'] }})"
                                                        wire:loading.attr="disabled"
                                                    >
                                                        <x-heroicon-o-pencil-square />

                                                        <span>Edit</span>
                                                    </button>

                                                    <button
                                                        type="button"
                                                        class="shop-button shop-button-danger"
                                                        wire:click="deleteItem({{ (int) $item['id'] }})"
                                                        wire:confirm="Hapus item belanja ini?"
                                                        wire:loading.attr="disabled"
                                                    >
                                                        <x-heroicon-o-trash />

                                                        <span>Hapus</span>
                                                    </button>
                                                </div>
                                            </article>
                                        @endforeach
                                    </div>
                                </section>
                            @endforeach
                        </div>

                        @if (
                            method_exists($items, 'hasPages')
                            && $items->hasPages()
                        )
                            <div class="shop-pagination">
                                {{ $items->links() }}
                            </div>
                        @endif
                    @else
                        <div class="shop-empty">
                            <div>
                                <div class="shop-empty-icon">
                                    @if ($filterAktif)
                                        <x-heroicon-o-magnifying-glass />
                                    @else
                                        <x-heroicon-o-shopping-cart />
                                    @endif
                                </div>

                                <h3 class="shop-empty-title">
                                    @if ($filterAktif)
                                        Item tidak ditemukan
                                    @else
                                        Daftar belanja masih kosong
                                    @endif
                                </h3>

                                <p class="shop-empty-copy">
                                    @if ($filterAktif)
                                        Tidak ada item yang sesuai dengan
                                        kata kunci atau status yang dipilih.
                                    @else
                                        Tambahkan kebutuhan belanja
                                        pertamamu agar persiapan Meal Plan
                                        lebih teratur.
                                    @endif
                                </p>

                                @if (! $filterAktif)
                                    <div class="shop-empty-actions">
                                        <button
                                            type="button"
                                            class="shop-button shop-button-primary"
                                            wire:click="createItem"
                                        >
                                            <x-heroicon-o-plus />

                                            <span>Tambah Item</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </article>

            <aside class="shop-panel">
                <div
                    class="shop-loading-line"
                    wire:loading
                    wire:target="saveItem"
                ></div>

                <div class="shop-panel-head">
                    <div>
                        <h2 class="shop-section-title">
                            {{
                                $editingId
                                    ? 'Edit Item Belanja'
                                    : 'Tambah Item Belanja'
                            }}
                        </h2>

                        <p class="shop-section-description">
                            Masukkan nama bahan, jumlah, satuan,
                            kategori, dan catatan pembelian.
                        </p>
                    </div>

                    @if ($showForm)
                        <button
                            type="button"
                            class="shop-button shop-button-soft"
                            wire:click="cancelForm"
                        >
                            <x-heroicon-o-x-mark />

                            <span>Tutup</span>
                        </button>
                    @endif
                </div>

                <div class="shop-panel-body">
                    @if ($showForm)
                        <form wire:submit.prevent="saveItem">
                            <div class="shop-form-grid">
                                <div class="shop-form-group">
                                    <label
                                        for="nama_item"
                                        class="shop-label"
                                    >
                                        Nama item
                                        <span class="shop-required">*</span>
                                    </label>

                                    <input
                                        id="nama_item"
                                        type="text"
                                        class="shop-input"
                                        placeholder="Contoh: dada ayam, brokoli, beras merah"
                                        wire:model="nama_item"
                                    >

                                    @error('nama_item')
                                        <span class="shop-field-error">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="shop-form-row">
                                    <div class="shop-form-group">
                                        <label
                                            for="jumlah"
                                            class="shop-label"
                                        >
                                            Jumlah
                                            <span class="shop-required">*</span>
                                        </label>

                                        <input
                                            id="jumlah"
                                            type="number"
                                            min="0.1"
                                            max="100000"
                                            step="0.1"
                                            class="shop-input"
                                            wire:model="jumlah"
                                        >

                                        @error('jumlah')
                                            <span class="shop-field-error">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="shop-form-group">
                                        <label
                                            for="satuan"
                                            class="shop-label"
                                        >
                                            Satuan
                                            <span class="shop-required">*</span>
                                        </label>

                                        <input
                                            id="satuan"
                                            type="text"
                                            class="shop-input"
                                            placeholder="pcs, gram, kg, pack"
                                            wire:model="satuan"
                                        >

                                        @error('satuan')
                                            <span class="shop-field-error">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="shop-form-group">
                                    <label
                                        for="kategori"
                                        class="shop-label"
                                    >
                                        Kategori
                                    </label>

                                    <input
                                        id="kategori"
                                        type="text"
                                        class="shop-input"
                                        placeholder="Contoh: Protein, Sayur, Karbohidrat"
                                        wire:model="kategori"
                                    >

                                    <p class="shop-field-hint">
                                        Item dengan kategori yang sama
                                        akan dikelompokkan otomatis.
                                    </p>

                                    @error('kategori')
                                        <span class="shop-field-error">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="shop-form-group">
                                    <label
                                        for="catatan"
                                        class="shop-label"
                                    >
                                        Catatan pembelian
                                    </label>

                                    <textarea
                                        id="catatan"
                                        class="shop-textarea"
                                        placeholder="Opsional, contoh: pilih yang rendah lemak."
                                        wire:model="catatan"
                                    ></textarea>

                                    @error('catatan')
                                        <span class="shop-field-error">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                
                        {{-- START INFORMASI NUTRISI MAKANAN --}}
                        <section
                            class="shopping-nutrition-box"
                            data-shopping-nutrition-fields
                        >
                            <header class="shopping-nutrition-header">
                                <h3 class="shopping-nutrition-title">
                                    Informasi Nutrisi Makanan
                                </h3>

                                <p class="shopping-nutrition-description">
                                    Lengkapi nilai nutrisi untuk satu porsi.
                                    Data ini akan disimpan ke Koleksi Makanan.
                                </p>
                            </header>

                            <div class="shopping-nutrition-grid">
                                <div
                                    class="shopping-nutrition-field is-full"
                                >
                                    <label
                                        for="kategori_makanan_id"
                                        class="shopping-nutrition-label"
                                    >
                                        Kategori makanan

                                        <span
                                            class="shopping-nutrition-required"
                                        >
                                            *
                                        </span>
                                    </label>

                                    <div
                                        class="shopping-nutrition-select-shell"
                                    >
                                        <select
                                            id="kategori_makanan_id"
                                            class="shopping-nutrition-select"
                                            wire:model="kategori_makanan_id"
                                        >
                                            <option value="">
                                                Pilih kategori makanan
                                            </option>

                                            @foreach (
                                                $kategoriOptions
                                                as $id => $label
                                            )
                                                <option value="{{ $id }}">
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <span
                                            class="shopping-nutrition-arrow"
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

                                    @error('kategori_makanan_id')
                                        <span
                                            class="shopping-nutrition-error"
                                        >
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="shopping-nutrition-field">
                                    <label
                                        for="kalori"
                                        class="shopping-nutrition-label"
                                    >
                                        Kalori per porsi

                                        <span
                                            class="shopping-nutrition-required"
                                        >
                                            *
                                        </span>
                                    </label>

                                    <input
                                        id="kalori"
                                        type="number"
                                        min="0"
                                        max="10000"
                                        step="1"
                                        class="shopping-nutrition-input"
                                        placeholder="Contoh: 250"
                                        wire:model="kalori"
                                    >

                                    @error('kalori')
                                        <span
                                            class="shopping-nutrition-error"
                                        >
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="shopping-nutrition-field">
                                    <label
                                        for="protein"
                                        class="shopping-nutrition-label"
                                    >
                                        Protein per porsi

                                        <span
                                            class="shopping-nutrition-required"
                                        >
                                            *
                                        </span>
                                    </label>

                                    <input
                                        id="protein"
                                        type="number"
                                        min="0"
                                        max="1000"
                                        step="0.1"
                                        class="shopping-nutrition-input"
                                        placeholder="Dalam gram"
                                        wire:model="protein"
                                    >

                                    @error('protein')
                                        <span
                                            class="shopping-nutrition-error"
                                        >
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="shopping-nutrition-field">
                                    <label
                                        for="karbohidrat"
                                        class="shopping-nutrition-label"
                                    >
                                        Karbohidrat per porsi

                                        <span
                                            class="shopping-nutrition-required"
                                        >
                                            *
                                        </span>
                                    </label>

                                    <input
                                        id="karbohidrat"
                                        type="number"
                                        min="0"
                                        max="1000"
                                        step="0.1"
                                        class="shopping-nutrition-input"
                                        placeholder="Dalam gram"
                                        wire:model="karbohidrat"
                                    >

                                    @error('karbohidrat')
                                        <span
                                            class="shopping-nutrition-error"
                                        >
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="shopping-nutrition-field">
                                    <label
                                        for="lemak"
                                        class="shopping-nutrition-label"
                                    >
                                        Lemak per porsi

                                        <span
                                            class="shopping-nutrition-required"
                                        >
                                            *
                                        </span>
                                    </label>

                                    <input
                                        id="lemak"
                                        type="number"
                                        min="0"
                                        max="1000"
                                        step="0.1"
                                        class="shopping-nutrition-input"
                                        placeholder="Dalam gram"
                                        wire:model="lemak"
                                    >

                                    @error('lemak')
                                        <span
                                            class="shopping-nutrition-error"
                                        >
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <p class="shopping-nutrition-help">
                                Makanan hanya muncul pada dropdown Meal Plan
                                ketika item telah ditandai sebagai sudah dibeli.
                            </p>
                        </section>
                        {{-- END INFORMASI NUTRISI MAKANAN --}}

<label class="shop-checkbox-card">
                                    <input
                                        type="checkbox"
                                        wire:model="sudah_dibeli"
                                    >

                                    <span>
                                        <strong class="shop-checkbox-title">
                                            Tandai sudah dibeli
                                        </strong>

                                        <span class="shop-checkbox-copy">
                                            Aktifkan apabila item ini
                                            sudah berhasil dibeli.
                                        </span>
                                    </span>
                                </label>
                            </div>

                            <div class="shop-form-actions">
                                <button
                                    type="button"
                                    class="shop-button shop-button-soft"
                                    wire:click="cancelForm"
                                    wire:loading.attr="disabled"
                                >
                                    <x-heroicon-o-x-mark />

                                    <span>Batal</span>
                                </button>

                                <button
                                    type="submit"
                                    class="shop-button shop-button-primary"
                                    wire:loading.attr="disabled"
                                    wire:target="saveItem"
                                >
                                    <x-heroicon-o-check />

                                    <span
                                        wire:loading.remove
                                        wire:target="saveItem"
                                    >
                                        {{
                                            $editingId
                                                ? 'Simpan Perubahan'
                                                : 'Simpan Item'
                                        }}
                                    </span>

                                    <span
                                        wire:loading
                                        wire:target="saveItem"
                                    >
                                        Menyimpan...
                                    </span>
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="shop-empty is-form">
                            <div>
                                <div class="shop-empty-icon">
                                    <x-heroicon-o-plus />
                                </div>

                                <h3 class="shop-empty-title">
                                    Form belum dibuka
                                </h3>

                                <p class="shop-empty-copy">
                                    Klik tombol Tambah Item untuk
                                    mencatat kebutuhan belanja baru.
                                </p>

                                <div class="shop-empty-actions">
                                    <button
                                        type="button"
                                        class="shop-button shop-button-primary"
                                        wire:click="createItem"
                                    >
                                        <x-heroicon-o-plus />

                                        <span>Tambah Item</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </aside>
        </section>
    </div>
</div>