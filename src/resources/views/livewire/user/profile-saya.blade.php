<div class="profile-ui">
    @php
        $authUser = auth()->user();

        $avatarUrl = $authUser?->google_avatar;

        $nameParts = collect(
            preg_split('/\s+/', trim($name ?: 'Pengguna'))
        )->filter();

        $initials = $nameParts
            ->take(2)
            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');

        $initials = $initials ?: 'U';

        $profileFields = [
            $name,
            $email,
            $gender,
            $age,
            $height_cm,
            $weight_kg,
            $activity_level,
        ];

        $completedFields = collect($profileFields)
            ->filter(fn ($value) => filled($value))
            ->count();

        $completionPercentage = (int) round(
            ($completedFields / count($profileFields)) * 100
        );

        $profileComplete = $completionPercentage === 100;

        $genderLabel = match ($gender) {
            'male' => 'Laki-laki',
            'female' => 'Perempuan',
            default => 'Belum dipilih',
        };

        $activityLabel = $activity_level
            && isset($activityOptions[$activity_level])
                ? $activityOptions[$activity_level]
                : 'Belum dipilih';

        $calorieTarget = (int) ($daily_calorie_target ?? 0);
    @endphp

    <style>
        .profile-ui {
            --profile-blue: #7c9fd3;
            --profile-blue-dark: #5579ad;
            --profile-blue-soft: #e8f1ff;

            --profile-violet: #a697d6;
            --profile-violet-dark: #7160a5;
            --profile-violet-soft: #f0ecff;

            --profile-mint: #7fc7b2;
            --profile-mint-dark: #438674;
            --profile-mint-soft: #e6f8f2;

            --profile-peach: #eab186;
            --profile-peach-dark: #a76739;
            --profile-peach-soft: #fff1e6;

            --profile-yellow: #ddb85f;
            --profile-yellow-dark: #82631f;
            --profile-yellow-soft: #fff8df;

            --profile-red: #ba1a1a;
            --profile-red-dark: #8f1919;
            --profile-red-soft: #fff2f0;

            --profile-green: #347a63;
            --profile-green-soft: #e8f8f1;

            --profile-text: #191c20;
            --profile-muted: #626a76;
            --profile-faint: #8a919d;

            --profile-border: #dfe3eb;
            --profile-border-strong: #cbd2dd;

            --profile-surface: #ffffff;
            --profile-surface-soft: #f7f8fc;
            --profile-background: #fbfcff;

            --profile-shadow:
                0 12px 34px rgba(68, 83, 110, 0.07);

            --profile-shadow-hover:
                0 20px 48px rgba(68, 83, 110, 0.13);

            width: 100%;
            color: var(--profile-text);
        }

        .profile-ui * {
            box-sizing: border-box;
        }

        .profile-stack {
            display: grid;
            gap: 24px;
        }

        /*
        |--------------------------------------------------------------------------
        | Tombol
        |--------------------------------------------------------------------------
        */

        .profile-button {
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

        .profile-button:hover {
            transform: translateY(-1px);
        }

        .profile-button:disabled {
            cursor: wait;
            opacity: 0.58;
            transform: none;
        }

        .profile-button svg {
            width: 17px;
            height: 17px;
            flex: 0 0 17px;
        }

        .profile-button-primary {
            color: #ffffff;
            background: var(--profile-blue);
            box-shadow:
                0 10px 22px rgba(124, 159, 211, 0.24);
        }

        .profile-button-primary:hover {
            background: var(--profile-blue-dark);
        }

        .profile-button-outline {
            color: var(--profile-blue-dark);
            border-color: rgba(85, 121, 173, 0.48);
            background: #ffffff;
        }

        .profile-button-outline:hover {
            background: var(--profile-blue-soft);
        }

        .profile-button-soft {
            color: var(--profile-muted);
            border-color: var(--profile-border);
            background: var(--profile-surface-soft);
        }

        .profile-button-soft:hover {
            color: var(--profile-text);
            border-color: var(--profile-border-strong);
            background: #ffffff;
        }

        .profile-button-success {
            color: #ffffff;
            background: var(--profile-mint-dark);
        }

        .profile-button-success:hover {
            background: #356f60;
        }

        .profile-button-block {
            width: 100%;
        }

        /*
        |--------------------------------------------------------------------------
        | Hero
        |--------------------------------------------------------------------------
        */

        .profile-hero {
            position: relative;
            min-height: 310px;
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

        .profile-hero::before,
        .profile-hero::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
        }

        .profile-hero::before {
            top: -110px;
            right: -70px;
            width: 280px;
            height: 280px;
            background: rgba(124, 159, 211, 0.18);
        }

        .profile-hero::after {
            right: 18%;
            bottom: -110px;
            width: 190px;
            height: 190px;
            background: rgba(127, 199, 178, 0.22);
        }

        .profile-hero-layout {
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

        .profile-hero-content {
            max-width: 720px;
        }

        .profile-kicker {
            min-height: 31px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 11px;
            border: 1px solid rgba(85, 121, 173, 0.22);
            border-radius: 999px;
            color: var(--profile-blue-dark);
            background: rgba(255, 255, 255, 0.68);
            backdrop-filter: blur(8px);
            font-size: 10px;
            line-height: 1;
            font-weight: 700;
        }

        .profile-kicker svg {
            width: 15px;
            height: 15px;
        }

        .profile-hero-title {
            max-width: 700px;
            margin: 18px 0 0;
            color: var(--profile-text);
            font-size: clamp(34px, 4vw, 48px);
            line-height: 1.1;
            font-weight: 700;
            letter-spacing: -0.045em;
        }

        .profile-hero-title span {
            color: var(--profile-blue-dark);
        }

        .profile-hero-description {
            max-width: 620px;
            margin: 15px 0 0;
            color: #505967;
            font-size: 13px;
            line-height: 1.75;
        }

        /*
        |--------------------------------------------------------------------------
        | Kartu pengguna di hero
        |--------------------------------------------------------------------------
        */

        .profile-identity-card {
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.78);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.64);
            box-shadow:
                0 14px 30px rgba(68, 83, 110, 0.08);
            backdrop-filter: blur(12px);
        }

        .profile-identity-top {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .profile-avatar {
            width: 66px;
            height: 66px;
            flex: 0 0 66px;
            overflow: hidden;
            display: grid;
            place-items: center;
            border: 3px solid rgba(255, 255, 255, 0.86);
            border-radius: 20px;
            color: #ffffff;
            background:
                linear-gradient(
                    135deg,
                    var(--profile-blue),
                    var(--profile-violet)
                );
            box-shadow:
                0 12px 22px rgba(85, 121, 173, 0.18);
            font-size: 21px;
            line-height: 1;
            font-weight: 700;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
        }

        .profile-identity-text {
            min-width: 0;
        }

        .profile-identity-name {
            overflow: hidden;
            margin: 0;
            color: var(--profile-text);
            font-size: 14px;
            line-height: 1.35;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .profile-identity-email {
            overflow: hidden;
            margin: 5px 0 0;
            color: var(--profile-muted);
            font-size: 9px;
            line-height: 1.4;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .profile-completion {
            margin-top: 18px;
        }

        .profile-completion-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .profile-completion-label {
            color: var(--profile-muted);
            font-size: 9px;
            font-weight: 600;
        }

        .profile-completion-value {
            color: var(--profile-blue-dark);
            font-size: 11px;
            font-weight: 700;
        }

        .profile-progress-track {
            width: 100%;
            height: 9px;
            overflow: hidden;
            margin-top: 9px;
            border-radius: 999px;
            background: rgba(210, 216, 226, 0.82);
        }

        .profile-progress-bar {
            height: 100%;
            border-radius: inherit;
            background:
                linear-gradient(
                    90deg,
                    var(--profile-blue),
                    var(--profile-violet),
                    var(--profile-mint)
                );
            transition: width 350ms ease;
        }

        .profile-completion-copy {
            margin: 9px 0 0;
            color: var(--profile-muted);
            font-size: 8px;
            line-height: 1.5;
        }

        /*
        |--------------------------------------------------------------------------
        | Alert
        |--------------------------------------------------------------------------
        */

        .profile-alert {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            padding: 14px 16px;
            border: 1px solid var(--profile-border);
            border-radius: 14px;
            font-size: 11px;
            line-height: 1.6;
            font-weight: 600;
        }

        .profile-alert svg {
            width: 19px;
            height: 19px;
            flex: 0 0 19px;
        }

        .profile-alert-success {
            color: var(--profile-green);
            border-color: #badfd2;
            background: var(--profile-green-soft);
        }

        .profile-alert-error {
            color: var(--profile-red-dark);
            border-color: #efb8b4;
            background: var(--profile-red-soft);
        }

        .profile-alert-info {
            color: var(--profile-yellow-dark);
            border-color: #ead89b;
            background: var(--profile-yellow-soft);
        }

        /*
        |--------------------------------------------------------------------------
        | Ringkasan
        |--------------------------------------------------------------------------
        */

        .profile-summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .profile-summary-card {
            min-width: 0;
            padding: 17px;
            border: 1px solid var(--profile-border);
            border-radius: 17px;
            background: #ffffff;
            box-shadow: var(--profile-shadow);
        }

        .profile-summary-icon {
            width: 39px;
            height: 39px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            color: var(--profile-blue-dark);
            background: var(--profile-blue-soft);
        }

        .profile-summary-card:nth-child(2)
        .profile-summary-icon {
            color: var(--profile-mint-dark);
            background: var(--profile-mint-soft);
        }

        .profile-summary-card:nth-child(3)
        .profile-summary-icon {
            color: var(--profile-violet-dark);
            background: var(--profile-violet-soft);
        }

        .profile-summary-card:nth-child(4)
        .profile-summary-icon {
            color: var(--profile-peach-dark);
            background: var(--profile-peach-soft);
        }

        .profile-summary-icon svg {
            width: 20px;
            height: 20px;
        }

        .profile-summary-value {
            display: block;
            overflow: hidden;
            margin-top: 12px;
            color: var(--profile-text);
            font-size: 21px;
            line-height: 1.15;
            font-weight: 700;
            letter-spacing: -0.025em;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .profile-summary-label {
            display: block;
            margin-top: 5px;
            color: var(--profile-muted);
            font-size: 8px;
            line-height: 1.45;
            font-weight: 600;
        }

        /*
        |--------------------------------------------------------------------------
        | Layout konten
        |--------------------------------------------------------------------------
        */

        .profile-content-grid {
            display: grid;
            grid-template-columns:
                minmax(0, 1.35fr)
                minmax(310px, 0.65fr);
            align-items: start;
            gap: 24px;
        }

        .profile-side-stack {
            display: grid;
            gap: 24px;
        }

        .profile-panel {
            overflow: hidden;
            border: 1px solid var(--profile-border);
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.97);
            box-shadow: var(--profile-shadow);
        }

        .profile-panel-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            padding: 22px 24px;
            border-bottom: 1px solid var(--profile-border);
        }

        .profile-panel-body {
            padding: 24px;
        }

        .profile-section-title {
            margin: 0;
            color: var(--profile-text);
            font-size: 20px;
            line-height: 1.35;
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        .profile-section-description {
            max-width: 720px;
            margin: 6px 0 0;
            color: var(--profile-muted);
            font-size: 11px;
            line-height: 1.65;
        }

        /*
        |--------------------------------------------------------------------------
        | Form
        |--------------------------------------------------------------------------
        */

        .profile-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px;
        }

        .profile-form-group {
            min-width: 0;
        }

        .profile-form-group.is-full {
            grid-column: 1 / -1;
        }

        .profile-label {
            display: block;
            margin: 0 0 7px;
            color: var(--profile-muted);
            font-size: 9px;
            line-height: 1.3;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .profile-required {
            color: var(--profile-red);
        }

        .profile-input,
        .profile-select {
            width: 100%;
            min-height: 44px;
            padding: 10px 12px;
            border: 1px solid var(--profile-border-strong);
            border-radius: 10px;
            color: var(--profile-text);
            background: #fbfcff;
            outline: none;
            font-size: 11px;
            transition:
                border-color 180ms ease,
                box-shadow 180ms ease,
                background 180ms ease;
        }

        .profile-input::placeholder {
            color: #a0a6b0;
        }

        .profile-input:focus,
        .profile-select:focus {
            border-color: var(--profile-blue);
            background: #ffffff;
            box-shadow:
                0 0 0 3px rgba(124, 159, 211, 0.14);
        }

        .profile-field-error {
            display: block;
            margin-top: 6px;
            color: var(--profile-red);
            font-size: 9px;
            line-height: 1.4;
        }

        .profile-field-hint {
            margin: 6px 0 0;
            color: var(--profile-faint);
            font-size: 8px;
            line-height: 1.5;
        }

        /*
        |--------------------------------------------------------------------------
        | Pilihan gender
        |--------------------------------------------------------------------------
        */

        .profile-radio-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .profile-radio-card {
            min-height: 88px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px;
            border: 1px solid var(--profile-border);
            border-radius: 14px;
            background: var(--profile-surface-soft);
            cursor: pointer;
            transition:
                border-color 180ms ease,
                background 180ms ease,
                transform 180ms ease;
        }

        .profile-radio-card:hover {
            border-color: var(--profile-blue);
            background: var(--profile-blue-soft);
            transform: translateY(-1px);
        }

        .profile-radio-card:has(input:checked) {
            border-color: var(--profile-blue);
            background: var(--profile-blue-soft);
            box-shadow:
                0 0 0 3px rgba(124, 159, 211, 0.1);
        }

        .profile-radio-card input {
            width: 18px;
            height: 18px;
            flex: 0 0 18px;
            margin: 1px 0 0;
            accent-color: var(--profile-blue-dark);
        }

        .profile-radio-title {
            display: block;
            color: var(--profile-text);
            font-size: 10px;
            line-height: 1.4;
            font-weight: 700;
        }

        .profile-radio-copy {
            display: block;
            margin-top: 4px;
            color: var(--profile-muted);
            font-size: 8px;
            line-height: 1.55;
        }

        .profile-form-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        /*
        |--------------------------------------------------------------------------
        | Target kalori
        |--------------------------------------------------------------------------
        */

        .profile-calorie-card {
            position: relative;
            overflow: hidden;
            padding: 22px;
            border: 1px solid #c3e2d7;
            border-radius: 17px;
            background:
                radial-gradient(
                    circle at 90% 5%,
                    rgba(255, 255, 255, 0.8),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    var(--profile-mint-soft),
                    #f8fbff
                );
        }

        .profile-calorie-card::after {
            content: "";
            position: absolute;
            right: -42px;
            bottom: -55px;
            width: 135px;
            height: 135px;
            border-radius: 999px;
            background: rgba(127, 199, 178, 0.14);
        }

        .profile-calorie-icon {
            position: relative;
            z-index: 2;
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            color: var(--profile-mint-dark);
            background: rgba(255, 255, 255, 0.76);
        }

        .profile-calorie-icon svg {
            width: 21px;
            height: 21px;
        }

        .profile-calorie-label {
            position: relative;
            z-index: 2;
            display: block;
            margin-top: 16px;
            color: var(--profile-muted);
            font-size: 9px;
            font-weight: 600;
        }

        .profile-calorie-value {
            position: relative;
            z-index: 2;
            display: block;
            margin-top: 6px;
            color: var(--profile-mint-dark);
            font-size: 38px;
            line-height: 1;
            font-weight: 700;
            letter-spacing: -0.04em;
        }

        .profile-calorie-unit {
            position: relative;
            z-index: 2;
            display: block;
            margin-top: 7px;
            color: var(--profile-muted);
            font-size: 9px;
            font-weight: 600;
        }

        /*
        |--------------------------------------------------------------------------
        | Ringkasan profil
        |--------------------------------------------------------------------------
        */

        .profile-detail-list {
            display: grid;
            margin-top: 17px;
        }

        .profile-detail-row {
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 12px 0;
            border-bottom: 1px solid var(--profile-border);
        }

        .profile-detail-row:last-child {
            border-bottom: 0;
        }

        .profile-detail-label {
            color: var(--profile-muted);
            font-size: 9px;
            line-height: 1.4;
            font-weight: 600;
        }

        .profile-detail-value {
            max-width: 62%;
            color: var(--profile-text);
            font-size: 10px;
            line-height: 1.45;
            font-weight: 700;
            text-align: right;
        }

        .profile-detail-note {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-top: 16px;
            padding: 11px;
            border: 1px solid #d5dff0;
            border-radius: 11px;
            color: var(--profile-blue-dark);
            background: var(--profile-blue-soft);
            font-size: 8px;
            line-height: 1.55;
        }

        .profile-detail-note svg {
            width: 14px;
            height: 14px;
            flex: 0 0 14px;
        }

        /*
        |--------------------------------------------------------------------------
        | Password
        |--------------------------------------------------------------------------
        */

        .profile-password-grid {
            display: grid;
            gap: 14px;
        }

        .profile-security-note {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-bottom: 16px;
            padding: 12px;
            border: 1px solid #d9d0f1;
            border-radius: 11px;
            color: var(--profile-violet-dark);
            background: var(--profile-violet-soft);
            font-size: 8px;
            line-height: 1.55;
        }

        .profile-security-note svg {
            width: 16px;
            height: 16px;
            flex: 0 0 16px;
        }

        /*
        |--------------------------------------------------------------------------
        | Loading
        |--------------------------------------------------------------------------
        */

        .profile-loading-line {
            height: 3px;
            overflow: hidden;
            margin-bottom: -3px;
            border-radius: 999px;
            background: transparent;
        }

        .profile-loading-line::after {
            content: "";
            width: 38%;
            height: 100%;
            display: block;
            border-radius: inherit;
            background:
                linear-gradient(
                    90deg,
                    var(--profile-blue),
                    var(--profile-violet),
                    var(--profile-mint)
                );
            animation:
                profile-loading 900ms ease-in-out infinite alternate;
        }

        @keyframes profile-loading {
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

        @media (max-width: 1120px) {
            .profile-hero-layout,
            .profile-content-grid {
                grid-template-columns: 1fr;
            }

            .profile-identity-card {
                max-width: 620px;
            }
        }

        @media (max-width: 760px) {
            .profile-stack {
                gap: 17px;
            }

            .profile-hero {
                min-height: auto;
                padding: 24px 20px;
                border-radius: 18px;
            }

            .profile-hero-title {
                font-size: 31px;
            }

            .profile-hero-description {
                font-size: 12px;
            }

            .profile-summary-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .profile-panel {
                border-radius: 18px;
            }

            .profile-panel-head {
                flex-direction: column;
                padding: 18px;
            }

            .profile-panel-head .profile-button {
                width: 100%;
            }

            .profile-panel-body {
                padding: 18px;
            }

            .profile-form-grid,
            .profile-radio-grid {
                grid-template-columns: 1fr;
            }

            .profile-form-group.is-full {
                grid-column: auto;
            }

            .profile-form-actions {
                display: grid;
                grid-template-columns: 1fr;
            }

            .profile-form-actions .profile-button {
                width: 100%;
            }
        }

        @media (max-width: 450px) {
            .profile-summary-grid {
                grid-template-columns: 1fr;
            }

            .profile-hero-title {
                font-size: 28px;
            }

            .profile-identity-top {
                align-items: flex-start;
            }

            .profile-detail-row {
                align-items: flex-start;
                flex-direction: column;
            }

            .profile-detail-value {
                max-width: none;
                text-align: left;
            }
        }
    </style>

    <div class="profile-stack">
        {{-- Hero --}}
        <section class="profile-hero">
            <div class="profile-hero-layout">
                <div class="profile-hero-content">
                    <div class="profile-kicker">
                        <x-heroicon-o-user-circle />

                        <span>Profil Pengguna</span>
                    </div>

                    <h1 class="profile-hero-title">
                        Lengkapi profil untuk
                        <span>target kalori yang akurat.</span>
                    </h1>

                    <p class="profile-hero-description">
                        Data usia, gender, tinggi badan, berat badan,
                        dan tingkat aktivitas digunakan untuk menghitung
                        kebutuhan energi harian secara otomatis.
                    </p>
                </div>

                <aside class="profile-identity-card">
                    <div class="profile-identity-top">
                        <div class="profile-avatar">
                            @if ($avatarUrl)
                                <img
                                    src="{{ $avatarUrl }}"
                                    alt="Foto profil {{ $name ?: 'pengguna' }}"
                                    referrerpolicy="no-referrer"
                                >
                            @else
                                {{ $initials }}
                            @endif
                        </div>

                        <div class="profile-identity-text">
                            <h2 class="profile-identity-name">
                                {{ $name ?: 'Pengguna' }}
                            </h2>

                            <p class="profile-identity-email">
                                {{ $email ?: 'Email belum tersedia' }}
                            </p>
                        </div>
                    </div>

                    <div class="profile-completion">
                        <div class="profile-completion-head">
                            <span class="profile-completion-label">
                                Kelengkapan profil
                            </span>

                            <strong class="profile-completion-value">
                                {{ $completionPercentage }}%
                            </strong>
                        </div>

                        <div
                            class="profile-progress-track"
                            role="progressbar"
                            aria-label="Kelengkapan profil"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            aria-valuenow="{{ $completionPercentage }}"
                        >
                            <div
                                class="profile-progress-bar"
                                style="width: {{ $completionPercentage }}%;"
                            ></div>
                        </div>

                        <p class="profile-completion-copy">
                            @if ($profileComplete)
                                Seluruh data utama profil sudah lengkap.
                            @else
                                Lengkapi data yang masih kosong agar
                                target kalori dapat dihitung.
                            @endif
                        </p>
                    </div>
                </aside>
            </div>
        </section>

        {{-- Notifikasi --}}
        @if (session('profile_success'))
            <div class="profile-alert profile-alert-success">
                <x-heroicon-o-check-circle />

                <div>
                    {{ session('profile_success') }}
                </div>
            </div>
        @endif

        @if (session('password_success'))
            <div class="profile-alert profile-alert-success">
                <x-heroicon-o-check-circle />

                <div>
                    {{ session('password_success') }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="profile-alert profile-alert-error">
                <x-heroicon-o-exclamation-circle />

                <div>
                    Periksa kembali data pada form. Terdapat input
                    yang belum valid atau belum lengkap.
                </div>
            </div>
        @endif

        @if (! $daily_calorie_target)
            <div class="profile-alert profile-alert-info">
                <x-heroicon-o-information-circle />

                <div>
                    Target kalori belum tersedia. Lengkapi seluruh data
                    tubuh kemudian tekan tombol Simpan Profil.
                </div>
            </div>
        @endif

        {{-- Ringkasan --}}
        <section class="profile-summary-grid">
            <article class="profile-summary-card">
                <div class="profile-summary-icon">
                    <x-heroicon-o-fire />
                </div>

                <strong class="profile-summary-value">
                    @if ($calorieTarget > 0)
                        {{
                            number_format(
                                $calorieTarget,
                                0,
                                ',',
                                '.'
                            )
                        }}
                    @else
                        -
                    @endif
                </strong>

                <span class="profile-summary-label">
                    Target kalori harian
                </span>
            </article>

            <article class="profile-summary-card">
                <div class="profile-summary-icon">
                    <x-heroicon-o-scale />
                </div>

                <strong class="profile-summary-value">
                    @if (filled($weight_kg))
                        {{
                            number_format(
                                (float) $weight_kg,
                                1,
                                ',',
                                '.'
                            )
                        }} kg
                    @else
                        -
                    @endif
                </strong>

                <span class="profile-summary-label">
                    Berat badan
                </span>
            </article>

            <article class="profile-summary-card">
                <div class="profile-summary-icon">
                    <x-heroicon-o-arrows-up-down />
                </div>

                <strong class="profile-summary-value">
                    @if (filled($height_cm))
                        {{ $height_cm }} cm
                    @else
                        -
                    @endif
                </strong>

                <span class="profile-summary-label">
                    Tinggi badan
                </span>
            </article>

            <article class="profile-summary-card">
                <div class="profile-summary-icon">
                    <x-heroicon-o-calendar-days />
                </div>

                <strong class="profile-summary-value">
                    @if (filled($age))
                        {{ $age }} tahun
                    @else
                        -
                    @endif
                </strong>

                <span class="profile-summary-label">
                    Usia pengguna
                </span>
            </article>
        </section>

        {{-- Konten utama --}}
        <section class="profile-content-grid">
            {{-- Form profil --}}
            <article class="profile-panel">
                <div
                    class="profile-loading-line"
                    wire:loading
                    wire:target="saveProfile,resetProfileForm"
                ></div>

                <div class="profile-panel-head">
                    <div>
                        <h2 class="profile-section-title">
                            Data Profil dan Tubuh
                        </h2>

                        <p class="profile-section-description">
                            Perbarui informasi akun dan data tubuh.
                            Target kalori akan dihitung ulang ketika
                            profil berhasil disimpan.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="profile-button profile-button-soft"
                        wire:click="resetProfileForm"
                        wire:loading.attr="disabled"
                        wire:target="resetProfileForm"
                    >
                        <x-heroicon-o-arrow-path />

                        <span
                            wire:loading.remove
                            wire:target="resetProfileForm"
                        >
                            Reset Form
                        </span>

                        <span
                            wire:loading
                            wire:target="resetProfileForm"
                        >
                            Mereset...
                        </span>
                    </button>
                </div>

                <div class="profile-panel-body">
                    <form wire:submit.prevent="saveProfile">
                        <div class="profile-form-grid">
                            <div class="profile-form-group">
                                <label
                                    for="name"
                                    class="profile-label"
                                >
                                    Nama lengkap
                                    <span class="profile-required">*</span>
                                </label>

                                <input
                                    id="name"
                                    type="text"
                                    class="profile-input"
                                    placeholder="Masukkan nama lengkap"
                                    wire:model="name"
                                    autocomplete="name"
                                >

                                @error('name')
                                    <span class="profile-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="profile-form-group">
                                <label
                                    for="email"
                                    class="profile-label"
                                >
                                    Alamat email
                                    <span class="profile-required">*</span>
                                </label>

                                <input
                                    id="email"
                                    type="email"
                                    class="profile-input"
                                    placeholder="nama@email.com"
                                    wire:model="email"
                                    autocomplete="email"
                                >

                                @error('email')
                                    <span class="profile-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="profile-form-group is-full">
                                <label class="profile-label">
                                    Gender
                                    <span class="profile-required">*</span>
                                </label>

                                <div class="profile-radio-grid">
                                    <label class="profile-radio-card">
                                        <input
                                            type="radio"
                                            value="male"
                                            wire:model="gender"
                                        >

                                        <span>
                                            <strong class="profile-radio-title">
                                                Laki-laki
                                            </strong>

                                            <span class="profile-radio-copy">
                                                Digunakan untuk perhitungan
                                                kebutuhan kalori pria.
                                            </span>
                                        </span>
                                    </label>

                                    <label class="profile-radio-card">
                                        <input
                                            type="radio"
                                            value="female"
                                            wire:model="gender"
                                        >

                                        <span>
                                            <strong class="profile-radio-title">
                                                Perempuan
                                            </strong>

                                            <span class="profile-radio-copy">
                                                Digunakan untuk perhitungan
                                                kebutuhan kalori wanita.
                                            </span>
                                        </span>
                                    </label>
                                </div>

                                @error('gender')
                                    <span class="profile-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="profile-form-group">
                                <label
                                    for="age"
                                    class="profile-label"
                                >
                                    Usia
                                    <span class="profile-required">*</span>
                                </label>

                                <input
                                    id="age"
                                    type="number"
                                    min="10"
                                    max="100"
                                    class="profile-input"
                                    placeholder="Contoh: 21"
                                    wire:model="age"
                                >

                                <p class="profile-field-hint">
                                    Usia yang diperbolehkan 10–100 tahun.
                                </p>

                                @error('age')
                                    <span class="profile-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="profile-form-group">
                                <label
                                    for="height_cm"
                                    class="profile-label"
                                >
                                    Tinggi badan
                                    <span class="profile-required">*</span>
                                </label>

                                <input
                                    id="height_cm"
                                    type="number"
                                    min="100"
                                    max="250"
                                    class="profile-input"
                                    placeholder="Dalam sentimeter"
                                    wire:model="height_cm"
                                >

                                <p class="profile-field-hint">
                                    Masukkan tinggi antara 100–250 cm.
                                </p>

                                @error('height_cm')
                                    <span class="profile-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="profile-form-group">
                                <label
                                    for="weight_kg"
                                    class="profile-label"
                                >
                                    Berat badan
                                    <span class="profile-required">*</span>
                                </label>

                                <input
                                    id="weight_kg"
                                    type="number"
                                    min="25"
                                    max="300"
                                    step="0.1"
                                    class="profile-input"
                                    placeholder="Dalam kilogram"
                                    wire:model="weight_kg"
                                >

                                <p class="profile-field-hint">
                                    Masukkan berat antara 25–300 kg.
                                </p>

                                @error('weight_kg')
                                    <span class="profile-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="profile-form-group">
                                <label
                                    for="activity_level"
                                    class="profile-label"
                                >
                                    Tingkat aktivitas
                                    <span class="profile-required">*</span>
                                </label>

                                <select
                                    id="activity_level"
                                    class="profile-select"
                                    wire:model="activity_level"
                                >
                                    <option value="">
                                        Pilih tingkat aktivitas
                                    </option>

                                    @foreach ($activityOptions as $value => $label)
                                        <option value="{{ $value }}">
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>

                                <p class="profile-field-hint">
                                    Pilih aktivitas yang paling mendekati
                                    rutinitas harianmu.
                                </p>

                                @error('activity_level')
                                    <span class="profile-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="profile-form-actions">
                            <button
                                type="button"
                                class="profile-button profile-button-soft"
                                wire:click="resetProfileForm"
                                wire:loading.attr="disabled"
                            >
                                <x-heroicon-o-x-mark />

                                <span>Batalkan Perubahan</span>
                            </button>

                            <button
                                type="submit"
                                class="profile-button profile-button-primary"
                                wire:loading.attr="disabled"
                                wire:target="saveProfile"
                            >
                                <x-heroicon-o-check />

                                <span
                                    wire:loading.remove
                                    wire:target="saveProfile"
                                >
                                    Simpan Profil
                                </span>

                                <span
                                    wire:loading
                                    wire:target="saveProfile"
                                >
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </article>

            {{-- Kolom kanan --}}
            <aside class="profile-side-stack">
                {{-- Ringkasan target --}}
                <section class="profile-panel">
                    <div class="profile-panel-head">
                        <div>
                            <h2 class="profile-section-title">
                                Target Kalori
                            </h2>

                            <p class="profile-section-description">
                                Hasil perhitungan berdasarkan data tubuh
                                dan aktivitas terbaru.
                            </p>
                        </div>
                    </div>

                    <div class="profile-panel-body">
                        <div class="profile-calorie-card">
                            <div class="profile-calorie-icon">
                                <x-heroicon-o-fire />
                            </div>

                            <span class="profile-calorie-label">
                                Target kalori harian
                            </span>

                            <strong class="profile-calorie-value">
                                @if ($calorieTarget > 0)
                                    {{
                                        number_format(
                                            $calorieTarget,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}
                                @else
                                    -
                                @endif
                            </strong>

                            <span class="profile-calorie-unit">
                                kkal per hari
                            </span>
                        </div>

                        <div class="profile-detail-list">
                            <div class="profile-detail-row">
                                <span class="profile-detail-label">
                                    Nama
                                </span>

                                <strong class="profile-detail-value">
                                    {{ $name ?: '-' }}
                                </strong>
                            </div>

                            <div class="profile-detail-row">
                                <span class="profile-detail-label">
                                    Email
                                </span>

                                <strong class="profile-detail-value">
                                    {{ $email ?: '-' }}
                                </strong>
                            </div>

                            <div class="profile-detail-row">
                                <span class="profile-detail-label">
                                    Gender
                                </span>

                                <strong class="profile-detail-value">
                                    {{ $genderLabel }}
                                </strong>
                            </div>

                            <div class="profile-detail-row">
                                <span class="profile-detail-label">
                                    Aktivitas
                                </span>

                                <strong class="profile-detail-value">
                                    {{ $activityLabel }}
                                </strong>
                            </div>

                            <div class="profile-detail-row">
                                <span class="profile-detail-label">
                                    Status data
                                </span>

                                <strong class="profile-detail-value">
                                    {{
                                        $profileComplete
                                            ? 'Lengkap'
                                            : 'Belum lengkap'
                                    }}
                                </strong>
                            </div>
                        </div>

                        <div class="profile-detail-note">
                            <x-heroicon-o-calculator />

                            <span>
                                Setelah profil disimpan, dashboard akan
                                menggunakan target kalori terbaru secara
                                otomatis.
                            </span>
                        </div>
                    </div>
                </section>

                {{-- Password --}}
                <section class="profile-panel">
                    <div
                        class="profile-loading-line"
                        wire:loading
                        wire:target="updatePassword"
                    ></div>

                    <div class="profile-panel-head">
                        <div>
                            <h2 class="profile-section-title">
                                Keamanan Akun
                            </h2>

                            <p class="profile-section-description">
                                Perbarui password untuk menjaga keamanan
                                akun pengguna.
                            </p>
                        </div>
                    </div>

                    <div class="profile-panel-body">
                        <div class="profile-security-note">
                            <x-heroicon-o-shield-check />

                            <span>
                                Gunakan password minimal delapan karakter
                                dan hindari memakai password yang sama
                                dengan akun lain.
                            </span>
                        </div>

                        <form wire:submit.prevent="updatePassword">
                            <div class="profile-password-grid">
                                <div class="profile-form-group">
                                    <label
                                        for="current_password"
                                        class="profile-label"
                                    >
                                        Password saat ini
                                        <span class="profile-required">*</span>
                                    </label>

                                    <input
                                        id="current_password"
                                        type="password"
                                        class="profile-input"
                                        placeholder="Masukkan password saat ini"
                                        wire:model="current_password"
                                        autocomplete="current-password"
                                    >

                                    @error('current_password')
                                        <span class="profile-field-error">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="profile-form-group">
                                    <label
                                        for="password"
                                        class="profile-label"
                                    >
                                        Password baru
                                        <span class="profile-required">*</span>
                                    </label>

                                    <input
                                        id="password"
                                        type="password"
                                        class="profile-input"
                                        placeholder="Minimal 8 karakter"
                                        wire:model="password"
                                        autocomplete="new-password"
                                    >

                                    @error('password')
                                        <span class="profile-field-error">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="profile-form-group">
                                    <label
                                        for="password_confirmation"
                                        class="profile-label"
                                    >
                                        Konfirmasi password baru
                                        <span class="profile-required">*</span>
                                    </label>

                                    <input
                                        id="password_confirmation"
                                        type="password"
                                        class="profile-input"
                                        placeholder="Ulangi password baru"
                                        wire:model="password_confirmation"
                                        autocomplete="new-password"
                                    >
                                </div>

                                <button
                                    type="submit"
                                    class="profile-button profile-button-success profile-button-block"
                                    wire:loading.attr="disabled"
                                    wire:target="updatePassword"
                                >
                                    <x-heroicon-o-key />

                                    <span
                                        wire:loading.remove
                                        wire:target="updatePassword"
                                    >
                                        Simpan Password
                                    </span>

                                    <span
                                        wire:loading
                                        wire:target="updatePassword"
                                    >
                                        Menyimpan...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            </aside>
        </section>
    </div>
</div>