<div class="food-page">
    @php
        $totalMakanan = $makanans->total();
        $totalKategori = count($kategoriOptions);

        $recommendationImage =
            $siteSetting?->recommendation_image_url;

        $visibilityLabels = [
            '' => 'Semua makanan',
            'mine' => 'Makanan saya',
            'public' => 'Makanan publik',
            'recommended' => 'Makanan rekomendasi',
        ];

        $activeVisibilityLabel =
            $visibilityLabels[$visibilityFilter]
            ?? 'Semua makanan';

        $activeCategoryLabel =
            $kategoriFilter !== ''
            && isset($kategoriOptions[$kategoriFilter])
                ? $kategoriOptions[$kategoriFilter]
                : 'Semua kategori';
    @endphp

    <style>
        .food-page {
            --food-blue: #7d9fd3;
            --food-blue-dark: #5578ad;
            --food-blue-soft: #eaf1ff;

            --food-violet: #a99adc;
            --food-violet-soft: #f0ecff;

            --food-mint: #79c7b2;
            --food-mint-dark: #39816e;
            --food-mint-soft: #e7f8f2;

            --food-peach: #e9ad7f;
            --food-peach-soft: #fff0e5;

            --food-yellow: #d1a744;
            --food-yellow-soft: #fff8df;

            --food-red: #b82b3c;
            --food-red-soft: #fff1f3;

            --food-text: #191c20;
            --food-muted: #68717f;
            --food-faint: #9299a4;
            --food-border: #dfe3eb;
            --food-border-strong: #cbd3df;
            --food-surface: #ffffff;
            --food-background: #f8faff;

            --food-shadow:
                0 12px 34px rgba(65, 80, 110, 0.07);

            --food-shadow-hover:
                0 20px 46px rgba(65, 80, 110, 0.13);

            width: 100%;
            color: var(--food-text);
        }

        .food-page * {
            box-sizing: border-box;
        }

        .food-stack {
            display: grid;
            gap: 22px;
        }

        /*
        |--------------------------------------------------------------------------
        | Tombol
        |--------------------------------------------------------------------------
        */

        .food-button {
            min-height: 41px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px 15px;
            border: 1px solid transparent;
            border-radius: 10px;
            outline: none;
            cursor: pointer;
            text-decoration: none;
            font: inherit;
            font-size: 10px;
            line-height: 1.2;
            font-weight: 700;
            white-space: nowrap;
            transition:
                transform 180ms ease,
                background 180ms ease,
                border-color 180ms ease,
                box-shadow 180ms ease,
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
            width: 16px;
            height: 16px;
            flex: 0 0 16px;
        }

        .food-button-primary {
            color: #ffffff;
            background: var(--food-blue);
            box-shadow:
                0 10px 22px rgba(125, 159, 211, 0.24);
        }

        .food-button-primary:hover {
            background: var(--food-blue-dark);
        }

        .food-button-outline {
            color: var(--food-blue-dark);
            border-color: #b9c9e2;
            background: #ffffff;
        }

        .food-button-outline:hover {
            background: var(--food-blue-soft);
        }

        .food-button-soft {
            color: var(--food-muted);
            border-color: var(--food-border);
            background: #f8f9fc;
        }

        .food-button-soft:hover {
            color: var(--food-text);
            border-color: var(--food-border-strong);
            background: #ffffff;
        }

        .food-button-danger {
            color: var(--food-red);
            border-color: #f0bdc5;
            background: var(--food-red-soft);
        }

        .food-button-danger:hover {
            color: #ffffff;
            border-color: var(--food-red);
            background: var(--food-red);
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
            min-height: 260px;
            overflow: hidden;
            padding: 32px;
            border: 1px solid rgba(125, 159, 211, 0.18);
            border-radius: 22px;
            background:
                radial-gradient(
                    circle at 92% 5%,
                    rgba(255, 255, 255, 0.7),
                    transparent 32%
                ),
                linear-gradient(
                    135deg,
                    #e7e2ff 0%,
                    #dce8ff 52%,
                    #d4f5eb 100%
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
            top: -100px;
            right: -55px;
            width: 260px;
            height: 260px;
            background: rgba(125, 159, 211, 0.16);
        }

        .food-hero::after {
            right: 15%;
            bottom: -105px;
            width: 180px;
            height: 180px;
            background: rgba(121, 199, 178, 0.22);
        }

        .food-hero-layout {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns:
                minmax(0, 1.35fr)
                minmax(300px, 0.65fr);
            align-items: center;
            gap: 30px;
        }

        .food-kicker {
            min-height: 30px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 10px;
            border: 1px solid rgba(85, 120, 173, 0.22);
            border-radius: 999px;
            color: var(--food-blue-dark);
            background: rgba(255, 255, 255, 0.68);
            font-size: 9px;
            font-weight: 700;
        }

        .food-kicker svg {
            width: 14px;
            height: 14px;
        }

        .food-hero-title {
            max-width: 700px;
            margin: 17px 0 0;
            color: var(--food-text);
            font-size: clamp(33px, 4vw, 47px);
            line-height: 1.08;
            font-weight: 700;
            letter-spacing: -0.045em;
        }

        .food-hero-title span {
            color: var(--food-blue-dark);
        }

        .food-hero-copy {
            max-width: 620px;
            margin: 14px 0 0;
            color: #545e6b;
            font-size: 12px;
            line-height: 1.75;
        }

        .food-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
            margin-top: 22px;
        }

        .food-hero-stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            padding: 15px;
            border: 1px solid rgba(255, 255, 255, 0.78);
            border-radius: 17px;
            background: rgba(255, 255, 255, 0.62);
            backdrop-filter: blur(12px);
        }

        .food-stat {
            min-width: 0;
            padding: 13px;
            border: 1px solid rgba(207, 215, 227, 0.84);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.8);
        }

        .food-stat-icon {
            width: 30px;
            height: 30px;
            display: grid;
            place-items: center;
            border-radius: 9px;
            color: var(--food-blue-dark);
            background: var(--food-blue-soft);
        }

        .food-stat:nth-child(2) .food-stat-icon {
            color: #725ea8;
            background: var(--food-violet-soft);
        }

        .food-stat:nth-child(3) .food-stat-icon {
            color: var(--food-mint-dark);
            background: var(--food-mint-soft);
        }

        .food-stat:nth-child(4) .food-stat-icon {
            color: #9a6034;
            background: var(--food-peach-soft);
        }

        .food-stat-icon svg {
            width: 15px;
            height: 15px;
        }

        .food-stat-value {
            display: block;
            overflow: hidden;
            margin-top: 9px;
            color: var(--food-text);
            font-size: 16px;
            line-height: 1.2;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .food-stat-label {
            display: block;
            margin-top: 4px;
            color: var(--food-muted);
            font-size: 7px;
            line-height: 1.45;
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
            gap: 10px;
            padding: 13px 15px;
            border: 1px solid var(--food-border);
            border-radius: 13px;
            font-size: 10px;
            line-height: 1.6;
            font-weight: 600;
        }

        .food-alert svg {
            width: 18px;
            height: 18px;
            flex: 0 0 18px;
        }

        .food-alert-success {
            color: var(--food-mint-dark);
            border-color: #bce1d6;
            background: var(--food-mint-soft);
        }

        .food-alert-error {
            color: var(--food-red);
            border-color: #efbbc4;
            background: var(--food-red-soft);
        }

        /*
        |--------------------------------------------------------------------------
        | Panel
        |--------------------------------------------------------------------------
        */

        .food-panel {
            overflow: hidden;
            border: 1px solid var(--food-border);
            border-radius: 21px;
            background: #ffffff;
            box-shadow: var(--food-shadow);
        }

        .food-panel-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            padding: 20px 22px;
            border-bottom: 1px solid var(--food-border);
        }

        .food-panel-body {
            padding: 22px;
        }

        .food-section-title {
            margin: 0;
            color: var(--food-text);
            font-size: 18px;
            line-height: 1.35;
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        .food-section-copy {
            margin: 5px 0 0;
            color: var(--food-muted);
            font-size: 9px;
            line-height: 1.6;
        }

        /*
        |--------------------------------------------------------------------------
        | Form
        |--------------------------------------------------------------------------
        */

        .food-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 13px;
        }

        .food-form-group {
            min-width: 0;
        }

        .food-form-group.is-full {
            grid-column: 1 / -1;
        }

        .food-label {
            display: block;
            margin-bottom: 6px;
            color: var(--food-muted);
            font-size: 8px;
            line-height: 1.3;
            font-weight: 700;
        }

        .food-required {
            color: var(--food-red);
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
            font: inherit;
            font-size: 10px;
            transition:
                border-color 180ms ease,
                box-shadow 180ms ease,
                background 180ms ease;
        }

        .food-input,
        .food-select {
            min-height: 43px;
            padding: 9px 11px;
        }

        .food-textarea {
            min-height: 94px;
            padding: 10px 11px;
            resize: vertical;
        }

        .food-input:focus,
        .food-select:focus,
        .food-textarea:focus {
            border-color: var(--food-blue);
            background: #ffffff;
            box-shadow:
                0 0 0 3px rgba(125, 159, 211, 0.14);
        }

        .food-input::placeholder,
        .food-textarea::placeholder {
            color: #a2a8b2;
        }

        .food-error {
            display: block;
            margin-top: 5px;
            color: var(--food-red);
            font-size: 8px;
            line-height: 1.4;
        }

        /*
        |--------------------------------------------------------------------------
        | Select dengan panah
        |--------------------------------------------------------------------------
        */

        .food-select-shell {
            position: relative;
            width: 100%;
        }

        .food-select-shell .food-select {
            padding-right: 45px;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: none;
        }

        .food-select-arrow {
            position: absolute;
            z-index: 2;
            top: 50%;
            right: 9px;
            width: 27px;
            height: 27px;
            display: grid;
            place-items: center;
            border: 1px solid #d4deed;
            border-radius: 8px;
            color: var(--food-blue-dark);
            background: var(--food-blue-soft);
            pointer-events: none;
            transform: translateY(-50%);
            transition:
                transform 180ms ease,
                color 180ms ease,
                background 180ms ease;
        }

        .food-select-arrow svg {
            width: 14px;
            height: 14px;
        }

        .food-select-shell:focus-within
        .food-select-arrow {
            color: #ffffff;
            background: var(--food-blue);
            transform:
                translateY(-50%)
                rotate(180deg);
        }

        /*
        |--------------------------------------------------------------------------
        | Checkbox
        |--------------------------------------------------------------------------
        */

        .food-toggle-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 11px;
        }

        .food-toggle {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px;
            border: 1px solid var(--food-border);
            border-radius: 12px;
            background: #f8f9fc;
            cursor: pointer;
        }

        .food-toggle input {
            width: 17px;
            height: 17px;
            flex: 0 0 17px;
            margin-top: 1px;
            accent-color: var(--food-blue-dark);
        }

        .food-toggle strong {
            display: block;
            color: var(--food-text);
            font-size: 9px;
            line-height: 1.4;
        }

        .food-toggle span {
            display: block;
            margin-top: 3px;
            color: var(--food-muted);
            font-size: 7px;
            line-height: 1.5;
        }

        .food-form-actions {
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 9px;
            margin-top: 17px;
        }

        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        .food-filter-box {
            padding: 14px;
            border: 1px solid var(--food-border);
            border-radius: 14px;
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
                minmax(240px, 1.3fr)
                minmax(180px, 0.7fr)
                minmax(180px, 0.7fr);
            gap: 11px;
        }

        .food-search-shell {
            position: relative;
        }

        .food-search-shell svg {
            position: absolute;
            top: 50%;
            left: 12px;
            width: 16px;
            height: 16px;
            color: var(--food-faint);
            transform: translateY(-50%);
            pointer-events: none;
        }

        .food-search-shell .food-input {
            padding-left: 37px;
        }

        .food-filter-note {
            margin: 10px 0 0;
            color: var(--food-muted);
            font-size: 8px;
            line-height: 1.5;
        }

        .food-result-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin: 18px 0 12px;
            color: var(--food-muted);
            font-size: 8px;
            line-height: 1.5;
        }

        /*
        |--------------------------------------------------------------------------
        | Kartu makanan
        |--------------------------------------------------------------------------
        */

        .food-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .food-card {
            min-width: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--food-border);
            border-radius: 17px;
            background: #ffffff;
            box-shadow: var(--food-shadow);
            transition:
                transform 180ms ease,
                box-shadow 180ms ease,
                border-color 180ms ease;
        }

        .food-card:hover {
            border-color: #c6d2e4;
            box-shadow: var(--food-shadow-hover);
            transform: translateY(-2px);
        }

        .food-card-visual {
            position: relative;
            min-height: 130px;
            display: grid;
            place-items: center;
            background:
                radial-gradient(
                    circle at 90% 6%,
                    rgba(255, 255, 255, 0.66),
                    transparent 31%
                ),
                linear-gradient(
                    135deg,
                    #e8e5ff,
                    #edf7ff
                );
        }

        .food-card-visual.has-recommendation-image {
            overflow: hidden;
            background: #eaf1ff;
        }

        .food-card-image {
            position: absolute;
            inset: 0;
            z-index: 1;
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
        }

        .food-card-visual.has-recommendation-image::after {
            content: "";
            position: absolute;
            z-index: 2;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(
                    180deg,
                    rgba(16, 24, 40, 0.03) 35%,
                    rgba(16, 24, 40, 0.22) 100%
                );
        }

        .food-card-visual.has-recommendation-image
        .food-calorie-chip {
            z-index: 3;
        }

        .food-card:nth-child(3n + 2)
        .food-card-visual {
            background:
                radial-gradient(
                    circle at 90% 6%,
                    rgba(255, 255, 255, 0.7),
                    transparent 31%
                ),
                linear-gradient(
                    135deg,
                    #fff0ea,
                    #fff8df
                );
        }

        .food-card:nth-child(3n + 3)
        .food-card-visual {
            background:
                radial-gradient(
                    circle at 90% 6%,
                    rgba(255, 255, 255, 0.7),
                    transparent 31%
                ),
                linear-gradient(
                    135deg,
                    #e1f7f1,
                    #edf1ff
                );
        }

        .food-emoji {
            font-size: 37px;
            line-height: 1;
        }

        .food-calorie-chip {
            position: absolute;
            right: 11px;
            bottom: 10px;
            min-height: 29px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 9px;
            border: 1px solid rgba(255, 255, 255, 0.9);
            border-radius: 999px;
            color: var(--food-text);
            background: rgba(255, 255, 255, 0.88);
            font-size: 8px;
            font-weight: 700;
            backdrop-filter: blur(8px);
        }

        .food-calorie-chip svg {
            width: 12px;
            height: 12px;
            color: #b96a38;
        }

        .food-card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 14px;
        }

        .food-card-name {
            margin: 0;
            color: var(--food-text);
            font-size: 12px;
            line-height: 1.45;
            font-weight: 700;
        }

        .food-category {
            width: fit-content;
            min-height: 24px;
            display: inline-flex;
            align-items: center;
            margin-top: 7px;
            padding: 5px 8px;
            border: 1px solid #bfe3d7;
            border-radius: 999px;
            color: var(--food-mint-dark);
            background: var(--food-mint-soft);
            font-size: 7px;
            font-weight: 700;
        }

        .food-description {
            flex: 1;
            margin: 10px 0 0;
            color: var(--food-muted);
            font-size: 8px;
            line-height: 1.65;
        }

        .food-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 11px;
        }

        .food-badge {
            min-height: 24px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 8px;
            border: 1px solid var(--food-border);
            border-radius: 999px;
            font-size: 7px;
            line-height: 1;
            font-weight: 700;
        }

        .food-badge svg {
            width: 11px;
            height: 11px;
        }

        .food-badge-public {
            color: var(--food-mint-dark);
            border-color: #bfe3d7;
            background: var(--food-mint-soft);
        }

        .food-badge-private {
            color: var(--food-violet);
            border-color: #d7cff0;
            background: var(--food-violet-soft);
        }

        .food-badge-recommended {
            color: #8d691c;
            border-color: #ead492;
            background: var(--food-yellow-soft);
        }

        .food-recommendation {
            margin-top: 9px;
            padding: 8px;
            border: 1px solid #ead492;
            border-radius: 9px;
            color: #7e611f;
            background: var(--food-yellow-soft);
            font-size: 7px;
            line-height: 1.55;
        }

        .food-nutrition {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 7px;
            margin-top: 12px;
        }

        .food-nutrition-item {
            padding: 8px;
            border: 1px solid var(--food-border);
            border-radius: 9px;
            background: #fafbfe;
        }

        .food-nutrition-item strong {
            display: block;
            color: var(--food-text);
            font-size: 9px;
            line-height: 1.2;
        }

        .food-nutrition-item span {
            display: block;
            margin-top: 3px;
            color: var(--food-muted);
            font-size: 7px;
        }

        .food-portion {
            margin-top: 9px;
            color: var(--food-muted);
            font-size: 7px;
            line-height: 1.5;
        }

        .food-card-actions {
            display: grid;
            grid-template-columns: 1fr;
            gap: 7px;
            margin-top: 13px;
        }

        .food-owner-actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 7px;
        }

        .food-card-actions .food-button {
            min-height: 36px;
            padding: 7px 10px;
            font-size: 8px;
        }

        /*
        |--------------------------------------------------------------------------
        | Empty dan pagination
        |--------------------------------------------------------------------------
        */

        .food-empty {
            min-height: 250px;
            display: grid;
            place-items: center;
            padding: 28px;
            border: 1px dashed var(--food-border-strong);
            border-radius: 15px;
            background: #fbfcff;
            text-align: center;
        }

        .food-empty-icon {
            width: 54px;
            height: 54px;
            display: grid;
            place-items: center;
            margin: 0 auto 12px;
            border-radius: 16px;
            color: var(--food-blue-dark);
            background: var(--food-blue-soft);
        }

        .food-empty-icon svg {
            width: 25px;
            height: 25px;
        }

        .food-empty-title {
            margin: 0;
            color: var(--food-text);
            font-size: 13px;
            font-weight: 700;
        }

        .food-empty-copy {
            max-width: 420px;
            margin: 6px auto 0;
            color: var(--food-muted);
            font-size: 8px;
            line-height: 1.65;
        }

        .food-pagination {
            margin-top: 19px;
            padding-top: 16px;
            border-top: 1px solid var(--food-border);
        }

        /*
        |--------------------------------------------------------------------------
        | Modal Meal Plan
        |--------------------------------------------------------------------------
        */

        .food-modal-backdrop {
            position: fixed;
            z-index: 9999;
            inset: 0;
            overflow-y: auto;
            display: grid;
            place-items: center;
            padding: 22px;
            background: rgba(28, 35, 49, 0.48);
            backdrop-filter: blur(6px);
        }

        .food-modal {
            width: min(100%, 580px);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            background: #ffffff;
            box-shadow:
                0 30px 80px rgba(21, 29, 45, 0.28);
        }

        .food-modal-head {
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            padding: 22px;
            border-bottom: 1px solid var(--food-border);
            background:
                linear-gradient(
                    135deg,
                    #e9e4ff,
                    #dff2ff,
                    #dff6ee
                );
        }

        .food-modal-head::after {
            content: "";
            position: absolute;
            right: -45px;
            bottom: -75px;
            width: 150px;
            height: 150px;
            border-radius: 999px;
            background: rgba(125, 159, 211, 0.16);
            pointer-events: none;
        }

        .food-modal-title-wrap {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .food-modal-kicker {
            color: var(--food-blue-dark);
            font-size: 8px;
            font-weight: 700;
        }

        .food-modal-title {
            margin: 7px 0 0;
            color: var(--food-text);
            font-size: 19px;
            line-height: 1.35;
            font-weight: 700;
        }

        .food-modal-copy {
            margin: 5px 0 0;
            color: var(--food-muted);
            font-size: 9px;
            line-height: 1.55;
        }

        .food-modal-close {
            position: relative;
            z-index: 3;
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            display: grid;
            place-items: center;
            padding: 0;
            border: 1px solid rgba(125, 159, 211, 0.24);
            border-radius: 10px;
            color: var(--food-blue-dark);
            background: rgba(255, 255, 255, 0.78);
            cursor: pointer;
        }

        .food-modal-close svg {
            width: 17px;
            height: 17px;
        }

        .food-modal-body {
            padding: 22px;
        }

        .food-selected-summary {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr);
            align-items: center;
            gap: 12px;
            margin-bottom: 17px;
            padding: 12px;
            border: 1px solid var(--food-border);
            border-radius: 13px;
            background: #f8faff;
        }

        .food-selected-icon {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            background: var(--food-blue-soft);
            font-size: 21px;
        }

        .food-selected-name {
            margin: 0;
            color: var(--food-text);
            font-size: 10px;
            font-weight: 700;
        }

        .food-selected-meta {
            margin: 4px 0 0;
            color: var(--food-muted);
            font-size: 8px;
            line-height: 1.5;
        }

        .food-modal-actions {
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 9px;
            margin-top: 18px;
        }

        /*
        |--------------------------------------------------------------------------
        | Responsive
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1180px) {
            .food-hero-layout {
                grid-template-columns: 1fr;
            }

            .food-hero-stats {
                max-width: 620px;
            }

            .food-filter-grid {
                grid-template-columns: 1fr;
            }

            .food-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .food-stack {
                gap: 16px;
            }

            .food-hero {
                min-height: auto;
                padding: 22px 19px;
                border-radius: 18px;
            }

            .food-hero-title {
                font-size: 30px;
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
                padding: 17px;
            }

            .food-panel-head .food-button {
                width: 100%;
            }

            .food-panel-body {
                padding: 17px;
            }

            .food-form-grid,
            .food-toggle-grid,
            .food-grid {
                grid-template-columns: 1fr;
            }

            .food-form-group.is-full {
                grid-column: auto;
            }

            .food-form-actions,
            .food-modal-actions {
                display: grid;
                grid-template-columns: 1fr;
            }

            .food-form-actions .food-button,
            .food-modal-actions .food-button {
                width: 100%;
            }

            .food-result-meta {
                align-items: flex-start;
                flex-direction: column;
            }

            .food-modal-backdrop {
                align-items: end;
                padding: 0;
            }

            .food-modal {
                width: 100%;
                max-height: 92vh;
                overflow-y: auto;
                border-radius: 20px 20px 0 0;
            }
        }

        @media (max-width: 440px) {
            .food-hero-stats,
            .food-nutrition,
            .food-owner-actions {
                grid-template-columns: 1fr;
            }

            .food-hero-title {
                font-size: 27px;
            }
        }
    </style>

    <div class="food-stack">
        {{-- Hero --}}
        <section class="food-hero">
            <div class="food-hero-layout">
                <div>
                    <div class="food-kicker">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4.5 19.5h15m-13.5-3h12a3 3 0 0 0 3-3v-3a9 9 0 1 0-18 0v3a3 3 0 0 0 3 3Z"
                            />
                        </svg>

                        <span>Database Makanan</span>
                    </div>

                    <h1 class="food-hero-title">
                        Temukan dan kelola
                        <span>makanan sehatmu.</span>
                    </h1>

                    <p class="food-hero-copy">
                        Simpan data nutrisi makanan kemudian tambahkan
                        langsung ke Meal Plan tanpa perlu mencarinya
                        kembali pada halaman lain.
                    </p>

                    <div class="food-hero-actions">
                        <button
                            type="button"
                            class="food-button food-button-primary"
                            wire:click="createMakanan"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    d="M12 5v14M5 12h14"
                                />
                            </svg>

                            <span>Tambah Makanan</span>
                        </button>

                        <a
                            href="{{ route('user.meal-plan') }}"
                            class="food-button food-button-outline"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8 2v3m8-3v3M3.5 9h17M5 4h14a2 2 0 0 1 2 2v14H3V6a2 2 0 0 1 2-2Z"
                                />
                            </svg>

                            <span>Buka Meal Plan</span>
                        </a>
                    </div>
                </div>

                <aside class="food-hero-stats">
                    <article class="food-stat">
                        <div class="food-stat-icon">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    d="M5 7h14M5 12h14M5 17h9"
                                />
                            </svg>
                        </div>

                        <strong class="food-stat-value">
                            {{ $totalMakanan }}
                        </strong>

                        <span class="food-stat-label">
                            Total makanan ditemukan
                        </span>
                    </article>

                    <article class="food-stat">
                        <div class="food-stat-icon">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linejoin="round"
                                    d="M20 13 11 22l-9-9V4h9l9 9Z"
                                />
                            </svg>
                        </div>

                        <strong class="food-stat-value">
                            {{ $totalKategori }}
                        </strong>

                        <span class="food-stat-label">
                            Kategori tersedia
                        </span>
                    </article>

                    <article class="food-stat">
                        <div class="food-stat-icon">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 5h16l-6 7v5l-4 2v-7L4 5Z"
                                />
                            </svg>
                        </div>

                        <strong class="food-stat-value">
                            {{ $activeCategoryLabel }}
                        </strong>

                        <span class="food-stat-label">
                            Filter kategori
                        </span>
                    </article>

                    <article class="food-stat">
                        <div class="food-stat-icon">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"
                                />
                                <circle cx="12" cy="12" r="2.5" />
                            </svg>
                        </div>

                        <strong class="food-stat-value">
                            {{ $activeVisibilityLabel }}
                        </strong>

                        <span class="food-stat-label">
                            Jenis makanan
                        </span>
                    </article>
                </aside>
            </div>
        </section>

        {{-- Notifikasi --}}
        @if (session('makanan_success'))
            <div class="food-alert food-alert-success">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m5 12 4 4L19 6"
                    />
                </svg>

                <div>
                    {{ session('makanan_success') }}
                </div>
            </div>
        @endif

        @if (session('makanan_error'))
            <div class="food-alert food-alert-error">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <circle cx="12" cy="12" r="9" />
                    <path
                        stroke-linecap="round"
                        d="M12 7v6m0 4h.01"
                    />
                </svg>

                <div>
                    {{ session('makanan_error') }}
                </div>
            </div>
        @endif

        {{-- Form tambah/edit makanan --}}
        @if ($showForm)
            <section class="food-panel">
                <div class="food-panel-head">
                    <div>
                        <h2 class="food-section-title">
                            {{
                                $editingId
                                    ? 'Edit Makanan'
                                    : 'Tambah Makanan Baru'
                            }}
                        </h2>

                        <p class="food-section-copy">
                            Isi data nutrisi per porsi agar perhitungan
                            kalori pada Meal Plan lebih akurat.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="food-button food-button-soft"
                        wire:click="cancelForm"
                    >
                        Tutup
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
                                    placeholder="Contoh: Nasi merah ayam panggang"
                                    wire:model="nama"
                                >

                                @error('nama')
                                    <span class="food-error">
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

                                <div class="food-select-shell">
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

                                    <span class="food-select-arrow">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m7 10 5 5 5-5"
                                            />
                                        </svg>
                                    </span>
                                </div>

                                @error('kategori_makanan_id')
                                    <span class="food-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group">
                                <label
                                    for="kalori"
                                    class="food-label"
                                >
                                    Kalori
                                    <span class="food-required">*</span>
                                </label>

                                <input
                                    id="kalori"
                                    type="number"
                                    min="0"
                                    max="10000"
                                    step="1"
                                    class="food-input"
                                    placeholder="Contoh: 320"
                                    wire:model="kalori"
                                >

                                @error('kalori')
                                    <span class="food-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group is-full">
                                <label
                                    for="deskripsi"
                                    class="food-label"
                                >
                                    Deskripsi
                                </label>

                                <textarea
                                    id="deskripsi"
                                    class="food-textarea"
                                    placeholder="Deskripsi singkat makanan"
                                    wire:model="deskripsi"
                                ></textarea>

                                @error('deskripsi')
                                    <span class="food-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group">
                                <label
                                    for="protein"
                                    class="food-label"
                                >
                                    Protein (gram)
                                </label>

                                <input
                                    id="protein"
                                    type="number"
                                    min="0"
                                    step="0.1"
                                    class="food-input"
                                    wire:model="protein"
                                >

                                @error('protein')
                                    <span class="food-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group">
                                <label
                                    for="karbohidrat"
                                    class="food-label"
                                >
                                    Karbohidrat (gram)
                                </label>

                                <input
                                    id="karbohidrat"
                                    type="number"
                                    min="0"
                                    step="0.1"
                                    class="food-input"
                                    wire:model="karbohidrat"
                                >

                                @error('karbohidrat')
                                    <span class="food-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group">
                                <label
                                    for="lemak"
                                    class="food-label"
                                >
                                    Lemak (gram)
                                </label>

                                <input
                                    id="lemak"
                                    type="number"
                                    min="0"
                                    step="0.1"
                                    class="food-input"
                                    wire:model="lemak"
                                >

                                @error('lemak')
                                    <span class="food-error">
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
                                    <span class="food-error">
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
                                    placeholder="porsi, mangkuk, potong"
                                    wire:model="satuan"
                                >

                                @error('satuan')
                                    <span class="food-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group is-full">
                                <div class="food-toggle-grid">
                                    <label class="food-toggle">
                                        <input
                                            type="checkbox"
                                            wire:model="is_public"
                                        >

                                        <span>
                                            <strong>Makanan publik</strong>
                                            <span>
                                                Bisa digunakan pengguna lain.
                                            </span>
                                        </span>
                                    </label>

                                    <label class="food-toggle">
                                        <input
                                            type="checkbox"
                                            wire:model="is_recommended"
                                        >

                                        <span>
                                            <strong>Rekomendasi</strong>
                                            <span>
                                                Ditandai sebagai menu rekomendasi.
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            @if ($is_recommended)
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
                                        placeholder="Alasan makanan ini direkomendasikan"
                                        wire:model="recommended_note"
                                    ></textarea>

                                    @error('recommended_note')
                                        <span class="food-error">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <div class="food-form-actions">
                            <button
                                type="button"
                                class="food-button food-button-soft"
                                wire:click="cancelForm"
                            >
                                Batal
                            </button>

                            <button
                                type="submit"
                                class="food-button food-button-primary"
                                wire:loading.attr="disabled"
                                wire:target="saveMakanan"
                            >
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

        {{-- Koleksi --}}
        <section class="food-panel">
            <div class="food-panel-head">
                <div>
                    <h2 class="food-section-title">
                        Koleksi Makanan
                    </h2>

                    <p class="food-section-copy">
                        Cari makanan, gunakan filter, kemudian tambahkan
                        langsung ke jadwal Meal Plan.
                    </p>
                </div>

                <button
                    type="button"
                    class="food-button food-button-primary"
                    wire:click="createMakanan"
                >
                    Tambah Makanan
                </button>
            </div>

            <div class="food-panel-body">
                <div class="food-filter-box">
                    <div class="food-filter-grid">
                        <div class="food-form-group">
                            <label
                                for="search"
                                class="food-label"
                            >
                                Cari makanan
                            </label>

                            <div class="food-search-shell">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <circle cx="11" cy="11" r="7" />
                                    <path
                                        stroke-linecap="round"
                                        d="m16.5 16.5 4 4"
                                    />
                                </svg>

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

                            <div class="food-select-shell">
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

                                <span class="food-select-arrow">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m7 10 5 5 5-5"
                                        />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="food-form-group">
                            <label
                                for="visibilityFilter"
                                class="food-label"
                            >
                                Jenis makanan
                            </label>

                            <div class="food-select-shell">
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
                                        Makanan rekomendasi
                                    </option>
                                </select>

                                <span class="food-select-arrow">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m7 10 5 5 5-5"
                                        />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <p class="food-filter-note">
                        Filter diterapkan otomatis saat nilai pencarian
                        atau pilihan diubah.
                    </p>
                </div>

                <div class="food-result-meta">
                    <span>
                        Menampilkan {{ $makanans->count() }}
                        dari {{ $makanans->total() }} makanan.
                    </span>

                    <span>
                        Halaman {{ $makanans->currentPage() }}
                        dari {{ max(1, $makanans->lastPage()) }}
                    </span>
                </div>

                @if ($makanans->count() > 0)
                    <div class="food-grid">
                        @foreach ($makanans as $makanan)
                            @php
                                $foodName = mb_strtolower(
                                    $makanan['nama'] ?? ''
                                );

                                $foodCategory = mb_strtolower(
                                    $makanan['kategori'] ?? ''
                                );

                                $emoji = match (true) {
                                    str_contains($foodName, 'ayam') => '🍗',
                                    str_contains($foodName, 'telur') => '🥚',
                                    str_contains($foodName, 'roti') => '🍞',
                                    str_contains($foodName, 'oat') => '🥣',
                                    str_contains($foodName, 'susu') => '🥛',
                                    str_contains($foodName, 'pisang') => '🍌',
                                    str_contains($foodName, 'ikan') => '🐟',
                                    str_contains($foodName, 'salad') => '🥗',
                                    str_contains($foodName, 'nasi') => '🍚',
                                    str_contains($foodCategory, 'minum') => '🥤',
                                    str_contains($foodCategory, 'snack') => '🍓',
                                    default => '🍽️',
                                };
                            @endphp

                            <article
                                class="food-card"
                                wire:key="food-card-{{ $makanan['id'] }}"
                            >
                                <div
                                    class="food-card-visual {{
                                        $recommendationImage
                                            ? 'has-recommendation-image'
                                            : ''
                                    }}"
                                >
                                    @if ($recommendationImage)
                                        <img
                                            src="{{ $recommendationImage }}"
                                            alt="Foto {{ $makanan['nama'] }}"
                                            class="food-card-image"
                                            loading="lazy"
                                        >
                                    @else
                                        <span class="food-emoji">
                                            {{ $emoji }}
                                        </span>
                                    @endif

                                    <span class="food-calorie-chip">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 22c4 0 7-3 7-7 0-5-3-7-5-11-1 3-3 4-4 7-1-1-2-2-2-4-2 2-3 5-3 8 0 4 3 7 7 7Z"
                                            />
                                        </svg>

                                        {{
                                            number_format(
                                                (int) ($makanan['kalori'] ?? 0),
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }}
                                        kkal
                                    </span>
                                </div>

                                <div class="food-card-body">
                                    <h3 class="food-card-name">
                                        {{ $makanan['nama'] }}
                                    </h3>

                                    <span class="food-category">
                                        {{ $makanan['kategori'] }}
                                    </span>

                                    <p class="food-description">
                                        {{
                                            filled($makanan['deskripsi'] ?? null)
                                                ? $makanan['deskripsi']
                                                : 'Belum ada deskripsi makanan.'
                                        }}
                                    </p>

                                    <div class="food-badges">
                                        @if ($makanan['is_public'])
                                            <span class="food-badge food-badge-public">
                                                Publik
                                            </span>
                                        @else
                                            <span class="food-badge food-badge-private">
                                                Pribadi
                                            </span>
                                        @endif

                                        @if ($makanan['is_recommended'])
                                            <span class="food-badge food-badge-recommended">
                                                Rekomendasi
                                            </span>
                                        @endif
                                    </div>

                                    @if (
                                        $makanan['is_recommended']
                                        && filled($makanan['recommended_note'])
                                    )
                                        <div class="food-recommendation">
                                            {{ $makanan['recommended_note'] }}
                                        </div>
                                    @endif

                                    <div class="food-nutrition">
                                        <div class="food-nutrition-item">
                                            <strong>
                                                {{
                                                    number_format(
                                                        (float) $makanan['protein'],
                                                        1,
                                                        ',',
                                                        '.'
                                                    )
                                                }}g
                                            </strong>

                                            <span>Protein</span>
                                        </div>

                                        <div class="food-nutrition-item">
                                            <strong>
                                                {{
                                                    number_format(
                                                        (float) $makanan['karbohidrat'],
                                                        1,
                                                        ',',
                                                        '.'
                                                    )
                                                }}g
                                            </strong>

                                            <span>Karbohidrat</span>
                                        </div>

                                        <div class="food-nutrition-item">
                                            <strong>
                                                {{
                                                    number_format(
                                                        (float) $makanan['lemak'],
                                                        1,
                                                        ',',
                                                        '.'
                                                    )
                                                }}g
                                            </strong>

                                            <span>Lemak</span>
                                        </div>

                                        <div class="food-nutrition-item">
                                            <strong>
                                                {{
                                                    number_format(
                                                        (float) $makanan['porsi'],
                                                        1,
                                                        ',',
                                                        '.'
                                                    )
                                                }}
                                            </strong>

                                            <span>{{ $makanan['satuan'] }}</span>
                                        </div>
                                    </div>

                                    <p class="food-portion">
                                        Nutrisi ditampilkan untuk
                                        {{ $makanan['porsi'] }}
                                        {{ $makanan['satuan'] }}.
                                    </p>

                                    <div class="food-card-actions">
                                        <button
                                            type="button"
                                            class="food-button food-button-primary food-button-block"
                                            wire:click="openMealPlanForm({{ (int) $makanan['id'] }})"
                                            wire:loading.attr="disabled"
                                            wire:target="openMealPlanForm"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    d="M12 5v14M5 12h14"
                                                />
                                            </svg>

                                            <span>
                                                Tambah ke Meal Plan
                                            </span>
                                        </button>

                                        @if ($makanan['is_owner'])
                                            <div class="food-owner-actions">
                                                <button
                                                    type="button"
                                                    class="food-button food-button-outline"
                                                    wire:click="editMakanan({{ (int) $makanan['id'] }})"
                                                >
                                                    Edit
                                                </button>

                                                <button
                                                    type="button"
                                                    class="food-button food-button-danger"
                                                    wire:click="deleteMakanan({{ (int) $makanan['id'] }})"
                                                    wire:confirm="Hapus data makanan ini?"
                                                >
                                                    Hapus
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if ($makanans->hasPages())
                        <div class="food-pagination">
                            {{ $makanans->links() }}
                        </div>
                    @endif
                @else
                    <div class="food-empty">
                        <div>
                            <div class="food-empty-icon">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <circle cx="11" cy="11" r="7" />
                                    <path
                                        stroke-linecap="round"
                                        d="m16.5 16.5 4 4"
                                    />
                                </svg>
                            </div>

                            <h3 class="food-empty-title">
                                Makanan tidak ditemukan
                            </h3>

                            <p class="food-empty-copy">
                                Ubah kata kunci atau filter, atau tambahkan
                                data makanan baru ke koleksi.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>

    {{-- Modal tambah ke Meal Plan --}}
    @if ($showMealPlanForm)
        <div
            class="food-modal-backdrop"
            wire:click.self="closeMealPlanForm"
        >
            <section
                class="food-modal"
                role="dialog"
                aria-modal="true"
                aria-labelledby="meal-plan-modal-title"
            >
                <div class="food-modal-head">
                    <div class="food-modal-title-wrap">
                        <span class="food-modal-kicker">
                            Tambah ke jadwal makan
                        </span>

                        <h2
                            id="meal-plan-modal-title"
                            class="food-modal-title"
                        >
                            Tambah ke Meal Plan
                        </h2>

                        <p class="food-modal-copy">
                            Tentukan tanggal, waktu makan, jumlah porsi,
                            dan catatan menu.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="food-modal-close"
                        wire:click="closeMealPlanForm"
                        aria-label="Tutup modal"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                d="M6 6l12 12M18 6 6 18"
                            />
                        </svg>
                    </button>
                </div>

                <div class="food-modal-body">
                    @if ($selectedMealPlanMakanan)
                        <div class="food-selected-summary">
                            <div class="food-selected-icon">
                                🍽️
                            </div>

                            <div>
                                <h3 class="food-selected-name">
                                    {{ $selectedMealPlanMakanan['nama'] }}
                                </h3>

                                <p class="food-selected-meta">
                                    {{
                                        number_format(
                                            (int) $selectedMealPlanMakanan['kalori'],
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}
                                    kkal per
                                    {{
                                        number_format(
                                            (float) $selectedMealPlanMakanan['porsi'],
                                            1,
                                            ',',
                                            '.'
                                        )
                                    }}
                                    {{ $selectedMealPlanMakanan['satuan'] }}
                                </p>
                            </div>
                        </div>
                    @endif

                    <form wire:submit.prevent="addMakananToMealPlan">
                        <div class="food-form-grid">
                            <div class="food-form-group is-full">
                                <label
                                    for="mealPlanDate"
                                    class="food-label"
                                >
                                    Tanggal Meal Plan
                                    <span class="food-required">*</span>
                                </label>

                                <input
                                    id="mealPlanDate"
                                    type="date"
                                    class="food-input"
                                    wire:model="mealPlanDate"
                                >

                                @error('mealPlanDate')
                                    <span class="food-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group">
                                <label
                                    for="mealPlanMealTime"
                                    class="food-label"
                                >
                                    Waktu makan
                                    <span class="food-required">*</span>
                                </label>

                                <div class="food-select-shell">
                                    <select
                                        id="mealPlanMealTime"
                                        class="food-select"
                                        wire:model="mealPlanMealTime"
                                    >
                                        @foreach ($mealTimeOptions as $value => $label)
                                            <option value="{{ $value }}">
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <span class="food-select-arrow">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m7 10 5 5 5-5"
                                            />
                                        </svg>
                                    </span>
                                </div>

                                @error('mealPlanMealTime')
                                    <span class="food-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group">
                                <label
                                    for="mealPlanPorsi"
                                    class="food-label"
                                >
                                    Jumlah porsi
                                    <span class="food-required">*</span>
                                </label>

                                <input
                                    id="mealPlanPorsi"
                                    type="number"
                                    min="0.1"
                                    max="100"
                                    step="0.1"
                                    class="food-input"
                                    wire:model="mealPlanPorsi"
                                >

                                @error('mealPlanPorsi')
                                    <span class="food-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="food-form-group is-full">
                                <label
                                    for="mealPlanCatatan"
                                    class="food-label"
                                >
                                    Catatan
                                </label>

                                <textarea
                                    id="mealPlanCatatan"
                                    class="food-textarea"
                                    placeholder="Opsional, contoh: dikonsumsi setelah olahraga"
                                    wire:model="mealPlanCatatan"
                                ></textarea>

                                @error('mealPlanCatatan')
                                    <span class="food-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="food-modal-actions">
                            <button
                                type="button"
                                class="food-button food-button-soft"
                                wire:click="closeMealPlanForm"
                                wire:loading.attr="disabled"
                            >
                                Batal
                            </button>

                            <button
                                type="submit"
                                class="food-button food-button-primary"
                                wire:loading.attr="disabled"
                                wire:target="addMakananToMealPlan"
                            >
                                <span
                                    wire:loading.remove
                                    wire:target="addMakananToMealPlan"
                                >
                                    Tambahkan ke Meal Plan
                                </span>

                                <span
                                    wire:loading
                                    wire:target="addMakananToMealPlan"
                                >
                                    Menambahkan...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    @endif
</div>