<div class="meal-plan-page">
    <style>
        .meal-plan-page {
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

        .meal-hero {
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

        .meal-hero::after {
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
        .alert-error {
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

        .date-card {
            border-radius: 26px;
            background: #fff;
            border: 1px solid #f0e2e6;
            box-shadow: 0 14px 36px rgba(37, 44, 39, .06);
            padding: 20px;
            margin-bottom: 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .date-nav {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .date-title {
            margin: 0;
            font-size: 18px;
            font-weight: 900;
            color: #242c26;
        }

        .date-subtitle {
            margin: 5px 0 0;
            color: var(--pm-muted);
            font-size: 13px;
            font-weight: 700;
        }

        .content-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(340px, .9fr);
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
            line-height: 1;
        }

        .summary-label {
            margin-top: 7px;
            color: var(--pm-muted);
            font-size: 12px;
            font-weight: 800;
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
            font-weight: 800;
        }

        .meal-group-list {
            display: grid;
            gap: 16px;
        }

        .meal-group {
            border-radius: 24px;
            background: #fffafc;
            border: 1px solid #f4dfe7;
            overflow: hidden;
        }

        .meal-group-head {
            padding: 16px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-bottom: 1px solid #f3e0e7;
        }

        .meal-group-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 950;
            color: #242c26;
        }

        .meal-group-total {
            color: var(--pm-muted);
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .meal-items {
            display: grid;
            gap: 10px;
            padding: 14px;
        }

        .meal-item {
            border-radius: 19px;
            background: #fff;
            border: 1px solid #f0e2e6;
            padding: 15px;
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 14px;
            align-items: center;
        }

        .meal-name {
            margin: 0;
            color: #242c26;
            font-weight: 950;
            line-height: 1.3;
        }

        .meal-detail {
            margin-top: 6px;
            color: var(--pm-muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .meal-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-top: 10px;
        }

        .tag {
            display: inline-flex;
            align-items: center;
            padding: 5px 9px;
            border-radius: 999px;
            background: #f5faf6;
            border: 1px solid #dbeee1;
            color: #4c7f5e;
            font-weight: 900;
            font-size: 11px;
        }

        .item-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .status-pill {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 7px;
            border-radius: 999px;
            padding: 9px 12px;
            font-weight: 900;
            font-size: 12px;
            border: 1px solid transparent;
            cursor: pointer;
            white-space: nowrap;
        }

        .status-done {
            background: #edf9f0;
            color: #2e7a4e;
            border-color: #caebd3;
        }

        .status-plan {
            background: #fff4f8;
            color: #c74c7a;
            border-color: #ffd7e4;
        }

        .small-note {
            margin-top: 9px;
            color: var(--pm-muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .empty-state {
            text-align: center;
            padding: 38px 16px;
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
            max-width: 440px;
            color: var(--pm-muted);
            font-size: 13px;
            line-height: 1.6;
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
            .meal-hero,
            .card-head,
            .card-body {
                padding: 18px;
            }

            .hero-content {
                flex-direction: column;
            }

            .hero-content .btn-main,
            .hero-content .btn-soft,
            .date-card .btn-soft,
            .date-card .btn-danger,
            .date-card .btn-main {
                width: 100%;
            }

            .date-card {
                align-items: stretch;
            }

            .date-nav {
                width: 100%;
                flex-direction: column;
            }

            .summary-grid,
            .form-grid {
                grid-template-columns: 1fr;
            }

            .meal-item {
                grid-template-columns: 1fr;
            }

            .item-actions {
                flex-direction: column;
            }
        }
    </style>

    <section class="meal-hero">
        <div class="hero-content">
            <div>
                <div class="hero-eyebrow">
                    <span>🍽️</span>
                    <span>Meal Plan Harian</span>
                </div>

                <h1 class="hero-title">
                    Susun jadwal makan
                    <span>lebih terarah.</span>
                </h1>

                <p class="hero-desc">
                    Pilih tanggal, tambahkan makanan ke waktu makan tertentu,
                    lalu tandai menu yang sudah dikonsumsi agar progres kalori lebih rapi.
                </p>
            </div>

            <button type="button" class="btn-main" wire:click="createMealPlan">
                <span>＋</span>
                <span>Siapkan Meal Plan</span>
            </button>
        </div>
    </section>

    @if (session('meal_plan_success'))
        <div class="alert-success">
            {{ session('meal_plan_success') }}
        </div>
    @endif

    @if (session('meal_plan_error'))
        <div class="alert-error">
            {{ session('meal_plan_error') }}
        </div>
    @endif

    <section class="date-card">
        <div>
            <h2 class="date-title">
                {{ $dateLabel }}
            </h2>

            <p class="date-subtitle">
                {{ $hasMealPlan ? 'Meal plan sudah tersedia untuk tanggal ini.' : 'Belum ada meal plan. Tambahkan item untuk membuat otomatis.' }}
            </p>
        </div>

        <div class="date-nav">
            <button type="button" class="btn-soft" wire:click="previousDate">
                ← Sebelumnya
            </button>

            <input
                type="date"
                class="form-input"
                style="min-width: 180px;"
                wire:model.live="selectedDate"
            >

            <button type="button" class="btn-soft" wire:click="nextDate">
                Berikutnya →
            </button>

            <button type="button" class="btn-green" wire:click="todayDate">
                Hari Ini
            </button>

            @if ($hasMealPlan)
                <button
                    type="button"
                    class="btn-danger"
                    wire:click="deleteMealPlan"
                    wire:confirm="Hapus semua meal plan pada tanggal ini?"
                >
                    Hapus Plan
                </button>
            @endif
        </div>
    </section>

    <section class="summary-grid">
        <div class="summary-card">
            <div class="summary-icon">🍱</div>
            <div class="summary-value">
                {{ number_format((int) ($summary['jumlah_menu'] ?? 0), 0, ',', '.') }}
            </div>
            <div class="summary-label">Jumlah menu</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon">🔥</div>
            <div class="summary-value">
                {{ number_format((int) ($summary['total_kalori'] ?? 0), 0, ',', '.') }}
            </div>
            <div class="summary-label">Total kalori</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon">✅</div>
            <div class="summary-value">
                {{ number_format((int) ($summary['consumed_kalori'] ?? 0), 0, ',', '.') }}
            </div>
            <div class="summary-label">Kalori dikonsumsi</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon">💪</div>
            <div class="summary-value">
                {{ number_format((float) ($summary['total_protein'] ?? 0), 1, ',', '.') }}g
            </div>
            <div class="summary-label">Total protein</div>
        </div>
    </section>

    <section class="content-grid">
        <div class="content-card">
            <div class="card-head">
                <div>
                    <h2 class="card-title">Jadwal Makan</h2>
                    <p class="card-subtitle">
                        Daftar menu yang masuk ke meal plan tanggal terpilih.
                    </p>
                </div>
            </div>

            <div class="card-body">
                @if (count($mealPlanItems) > 0)
                    <div class="meal-group-list">
                        @foreach ($groupedItems as $group)
                            <div class="meal-group" wire:key="meal-group-{{ $group['key'] }}">
                                <div class="meal-group-head">
                                    <div class="meal-group-title">
                                        <span>{{ $group['icon'] }}</span>
                                        <span>{{ $group['label'] }}</span>
                                    </div>

                                    <div class="meal-group-total">
                                        {{ number_format((int) $group['total_kalori'], 0, ',', '.') }} kkal
                                    </div>
                                </div>

                                <div class="meal-items">
                                    @if (count($group['items']) > 0)
                                        @foreach ($group['items'] as $item)
                                            <div class="meal-item" wire:key="meal-plan-item-{{ $item['id'] }}">
                                                <div>
                                                    <h3 class="meal-name">
                                                        {{ $item['nama'] }}
                                                    </h3>

                                                    <div class="meal-detail">
                                                        {{ number_format((float) $item['porsi'], 1, ',', '.') }} porsi
                                                        · {{ number_format((int) $item['total_kalori'], 0, ',', '.') }} kkal
                                                    </div>

                                                    <div class="meal-tags">
                                                        <span class="tag">
                                                            Protein {{ number_format((float) $item['total_protein'], 1, ',', '.') }}g
                                                        </span>
                                                        <span class="tag">
                                                            Karbo {{ number_format((float) $item['total_karbohidrat'], 1, ',', '.') }}g
                                                        </span>
                                                        <span class="tag">
                                                            Lemak {{ number_format((float) $item['total_lemak'], 1, ',', '.') }}g
                                                        </span>
                                                    </div>

                                                    @if (! empty($item['catatan']))
                                                        <div class="small-note">
                                                            {{ $item['catatan'] }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="item-actions">
                                                    <button
                                                        type="button"
                                                        wire:click="toggleConsumed({{ (int) $item['id'] }})"
                                                        class="status-pill {{ $item['is_consumed'] ? 'status-done' : 'status-plan' }}"
                                                    >
                                                        @if ($item['is_consumed'])
                                                            <span>✅</span>
                                                            <span>Sudah dimakan</span>
                                                        @else
                                                            <span>⏳</span>
                                                            <span>Belum dimakan</span>
                                                        @endif
                                                    </button>

                                                    <button
                                                        type="button"
                                                        class="btn-danger"
                                                        wire:click="deleteItem({{ (int) $item['id'] }})"
                                                        wire:confirm="Hapus item meal plan ini?"
                                                    >
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="empty-state" style="padding: 24px 14px;">
                                            <div class="empty-icon">🍽️</div>
                                            <h4>Belum ada menu {{ strtolower($group['label']) }}</h4>
                                            <p>
                                                Tambahkan makanan dari form di samping.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">🍽️</div>
                        <h4>Belum ada menu di tanggal ini</h4>
                        <p>
                            Pilih makanan dari daftar, tentukan waktu makan,
                            lalu simpan agar meal plan otomatis dibuat.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <aside class="content-card">
            <div class="card-head">
                <div>
                    <h2 class="card-title">Tambah Menu</h2>
                    <p class="card-subtitle">
                        Masukkan makanan ke meal plan tanggal terpilih.
                    </p>
                </div>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="addMealPlanItem">
                    <div class="form-grid">
                        <div class="form-group full">
                            <label class="form-label" for="makananSearch">Cari Makanan</label>
                            <input
                                id="makananSearch"
                                type="search"
                                class="form-input"
                                placeholder="Ketik nama makanan..."
                                wire:model.live.debounce.400ms="makananSearch"
                            >
                        </div>

                        <div class="form-group full">
                            <label class="form-label" for="selectedMakananId">Pilih Makanan</label>
                            <select
                                id="selectedMakananId"
                                class="form-select"
                                wire:model="selectedMakananId"
                            >
                                <option value="">Pilih makanan</option>
                                @foreach ($makananOptions as $makanan)
                                    <option value="{{ $makanan['id'] }}">
                                        {{ $makanan['nama'] }} · {{ number_format((int) $makanan['kalori'], 0, ',', '.') }} kkal
                                    </option>
                                @endforeach
                            </select>
                            @error('selectedMakananId')
                                <span class="form-error">{{ $message }}</span>
                            @enderror

                            @if (count($makananOptions) === 0)
                                <div class="small-note">
                                    Belum ada makanan. Tambahkan dulu dari halaman Makanan Saya.
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="selectedMealTime">Waktu Makan</label>
                            <select
                                id="selectedMealTime"
                                class="form-select"
                                wire:model="selectedMealTime"
                            >
                                @foreach ($mealTimeOptions as $value => $label)
                                    <option value="{{ $value }}">
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('selectedMealTime')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="selectedPorsi">Porsi</label>
                            <input
                                id="selectedPorsi"
                                type="number"
                                step="0.1"
                                min="0.1"
                                class="form-input"
                                wire:model="selectedPorsi"
                            >
                            @error('selectedPorsi')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label class="form-label" for="selectedCatatan">Catatan</label>
                            <textarea
                                id="selectedCatatan"
                                class="form-textarea"
                                placeholder="Opsional, contoh: makan setelah olahraga"
                                wire:model="selectedCatatan"
                            ></textarea>
                            @error('selectedCatatan')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-top: 18px;">
                        <button
                            type="submit"
                            class="btn-main"
                            wire:loading.attr="disabled"
                            style="width: 100%;"
                        >
                            <span wire:loading.remove wire:target="addMealPlanItem">
                                Tambahkan ke Meal Plan
                            </span>
                            <span wire:loading wire:target="addMealPlanItem">
                                Menambahkan...
                            </span>
                        </button>
                    </div>
                </form>

                <div style="margin-top: 14px;">
                    <a href="{{ route('user.makanan') }}" class="btn-soft" style="width: 100%;">
                        Kelola Data Makanan
                    </a>
                </div>
            </div>
        </aside>
    </section>
</div>