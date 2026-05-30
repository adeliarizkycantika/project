<div>
    <style>
        .mp-grid {
            display: grid;
            grid-template-columns: 380px minmax(0, 1fr);
            gap: 24px;
        }

        .form-stack {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .form-card {
            padding: 24px;
        }

        .form-title {
            margin: 0 0 18px;
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 800;
            color: #334155;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 14px;
            background: #ffffff;
            color: #0f172a;
            font-size: 14px;
            outline: none;
        }

        .form-input,
        .form-select {
            height: 46px;
            padding: 0 14px;
        }

        .form-textarea {
            min-height: 96px;
            padding: 12px 14px;
            resize: vertical;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
        }

        .error-text {
            margin: 6px 0 0;
            color: #dc2626;
            font-size: 13px;
            font-weight: 600;
        }

        .alert-success {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 14px;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            font-weight: 700;
        }

        .alert-warning {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 14px;
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
            font-weight: 700;
        }

        .filter-card {
            padding: 24px;
            margin-bottom: 24px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 220px auto;
            gap: 12px;
            align-items: end;
        }

        .meal-list-card {
            overflow: hidden;
        }

        .meal-list-header {
            padding: 24px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .meal-list-title {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
        }

        .meal-list-subtitle {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .meal-list-body {
            padding: 24px;
        }

        .meal-plan-panel {
            padding: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
            margin-bottom: 18px;
        }

        .meal-plan-panel:last-child {
            margin-bottom: 0;
        }

        .meal-plan-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .meal-plan-name {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
        }

        .meal-plan-date {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 14px;
            font-weight: 600;
        }

        .meal-plan-note {
            margin: 10px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .meal-plan-meta {
            margin: 10px 0 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 700;
        }

        .meal-plan-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .meal-item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 16px;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #f8fafc;
            margin-bottom: 12px;
        }

        .meal-item-row:last-child {
            margin-bottom: 0;
        }

        .meal-item-content {
            flex: 1;
            min-width: 240px;
        }

        .meal-item-name {
            margin: 10px 0 0;
            font-size: 17px;
            font-weight: 800;
            color: #0f172a;
        }

        .meal-item-desc {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .meal-item-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .small-btn {
            padding: 9px 12px;
            font-size: 12px;
            border-radius: 12px;
        }

        .filter-info {
            margin-top: 12px;
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
        }

        @media (max-width: 980px) {
            .mp-grid {
                grid-template-columns: 1fr;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="page-header">
        <div>
            <h1 class="page-title">
                Meal Plan Saya
            </h1>

            <p class="page-subtitle">
                Buat jadwal makan harian, tambahkan makanan, dan generate daftar belanja.
            </p>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('warning'))
        <div class="alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    <div class="mp-grid">
        <div class="form-stack">
            <div class="card form-card">
                <h2 class="form-title">
                    Buat Meal Plan
                </h2>

                <form wire:submit.prevent="createMealPlan">
                    <div class="form-group">
                        <label class="form-label">
                            Judul
                        </label>

                        <input
                            type="text"
                            wire:model="judul"
                            placeholder="Contoh: Meal Plan Hari Senin"
                            class="form-input"
                        >

                        @error('judul')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Tanggal Rencana
                        </label>

                        <input
                            type="date"
                            wire:model="tanggal_rencana"
                            class="form-input"
                        >

                        @error('tanggal_rencana')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Catatan
                        </label>

                        <textarea
                            wire:model="catatan"
                            placeholder="Catatan opsional"
                            class="form-textarea"
                        ></textarea>

                        @error('catatan')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        Simpan Meal Plan
                    </button>
                </form>
            </div>

            <div class="card form-card">
                <h2 class="form-title">
                    Tambah Makanan
                </h2>

                <form wire:submit.prevent="addItem">
                    <div class="form-group">
                        <label class="form-label">
                            Pilih Meal Plan
                        </label>

                        <select wire:model="selectedMealPlanId" class="form-select">
                            <option value="">Pilih meal plan</option>

                            @foreach ($this->mealPlanOptions as $mealPlan)
                                <option value="{{ $mealPlan->id }}">
                                    {{ $mealPlan->judul }} - {{ $mealPlan->tanggal_rencana->format('d M Y') }}
                                </option>
                            @endforeach
                        </select>

                        @error('selectedMealPlanId')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Makanan
                        </label>

                        <select wire:model="makanan_id" class="form-select">
                            <option value="">Pilih makanan</option>

                            @foreach ($this->makananOptions as $makanan)
                                <option value="{{ $makanan->id }}">
                                    {{ $makanan->nama }}
                                    @if ($makanan->user_id)
                                        - Makanan Saya
                                    @else
                                        - Global
                                    @endif
                                    - {{ $makanan->kalori }} kkal
                                </option>
                            @endforeach
                        </select>

                        @error('makanan_id')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Waktu Makan
                        </label>

                        <select wire:model="waktu_makan" class="form-select">
                            <option value="sarapan">Sarapan</option>
                            <option value="makan_siang">Makan Siang</option>
                            <option value="makan_malam">Makan Malam</option>
                            <option value="snack">Snack</option>
                        </select>

                        @error('waktu_makan')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Porsi
                        </label>

                        <input
                            type="number"
                            min="1"
                            wire:model="porsi"
                            class="form-input"
                        >

                        @error('porsi')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Catatan Item
                        </label>

                        <textarea
                            wire:model="catatan_item"
                            placeholder="Catatan opsional"
                            class="form-textarea"
                        ></textarea>

                        @error('catatan_item')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success" style="width: 100%;">
                        Tambah ke Meal Plan
                    </button>
                </form>
            </div>
        </div>

        <div>
            <div class="card filter-card">
                <h2 class="form-title">
                    Filter Meal Plan
                </h2>

                <div class="filter-grid">
                    <div>
                        <label class="form-label">
                            Cari Judul / Catatan
                        </label>

                        <input
                            type="text"
                            wire:model.live="searchMealPlan"
                            class="form-input"
                            placeholder="Cari meal plan..."
                        >
                    </div>

                    <div>
                        <label class="form-label">
                            Tanggal Rencana
                        </label>

                        <input
                            type="date"
                            wire:model.live="filterTanggalRencana"
                            class="form-input"
                        >
                    </div>

                    <div>
                        <button
                            type="button"
                            wire:click="resetFilterMealPlan"
                            class="btn btn-outline"
                            style="height: 46px; width: 100%;"
                        >
                            Reset
                        </button>
                    </div>
                </div>

                <p class="filter-info">
                    Menampilkan {{ $this->mealPlans->count() }} meal plan sesuai filter.
                </p>
            </div>

            <div class="card meal-list-card">
                <div class="meal-list-header">
                    <div>
                        <h2 class="meal-list-title">
                            Daftar Meal Plan
                        </h2>

                        <p class="meal-list-subtitle">
                            Kelola jadwal makan dan detail makanan kamu.
                        </p>
                    </div>
                </div>

                <div class="meal-list-body">
                    @forelse ($this->mealPlans as $mealPlan)
                        <div class="meal-plan-panel">
                            <div class="meal-plan-top">
                                <div>
                                    <h3 class="meal-plan-name">
                                        {{ $mealPlan->judul }}
                                    </h3>

                                    <p class="meal-plan-date">
                                        {{ $mealPlan->tanggal_rencana->format('d M Y') }}
                                    </p>

                                    @if ($mealPlan->catatan)
                                        <p class="meal-plan-note">
                                            {{ $mealPlan->catatan }}
                                        </p>
                                    @endif

                                    <p class="meal-plan-meta">
                                        {{ $mealPlan->items->count() }} menu •
                                        {{ $mealPlan->itemDaftarBelanja->count() }} item belanja
                                    </p>
                                </div>

                                <div class="meal-plan-actions">
                                    <button
                                        type="button"
                                        wire:click="selectMealPlan({{ $mealPlan->id }})"
                                        class="btn btn-outline small-btn"
                                    >
                                        Pilih
                                    </button>

                                    <button
                                        type="button"
                                        wire:click="generateDaftarBelanja({{ $mealPlan->id }})"
                                        class="btn btn-success small-btn"
                                    >
                                        Generate Belanja
                                    </button>

                                    <button
                                        type="button"
                                        wire:click="deleteMealPlan({{ $mealPlan->id }})"
                                        wire:confirm="Yakin ingin menghapus meal plan ini?"
                                        class="btn btn-danger small-btn"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </div>

                            @forelse ($mealPlan->items as $item)
                                <div class="meal-item-row">
                                    <div class="meal-item-content">
                                        <div class="pill-group">
                                            <span class="pill pill-gray">
                                                @switch($item->waktu_makan)
                                                    @case('sarapan')
                                                        Sarapan
                                                        @break

                                                    @case('makan_siang')
                                                        Makan Siang
                                                        @break

                                                    @case('makan_malam')
                                                        Makan Malam
                                                        @break

                                                    @case('snack')
                                                        Snack
                                                        @break

                                                    @default
                                                        {{ $item->waktu_makan }}
                                                @endswitch
                                            </span>

                                            @if ($item->sudah_dikonsumsi)
                                                <span class="pill pill-green">
                                                    Sudah Dikonsumsi
                                                </span>
                                            @else
                                                <span class="pill pill-yellow">
                                                    Belum Dikonsumsi
                                                </span>
                                            @endif
                                        </div>

                                        <p class="meal-item-name">
                                            {{ $item->makanan?->nama ?? 'Makanan tidak ditemukan' }}
                                        </p>

                                        <p class="meal-item-desc">
                                            {{ $item->porsi }} porsi •
                                            {{ number_format(($item->makanan?->kalori ?? 0) * $item->porsi) }} kkal
                                        </p>

                                        @if ($item->catatan)
                                            <p class="meal-item-desc">
                                                Catatan: {{ $item->catatan }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="meal-item-actions">
                                        <button
                                            type="button"
                                            wire:click="toggleKonsumsi({{ $item->id }})"
                                            class="btn {{ $item->sudah_dikonsumsi ? 'btn-danger' : 'btn-success' }} small-btn"
                                        >
                                            {{ $item->sudah_dikonsumsi ? 'Batalkan' : 'Tandai Dimakan' }}
                                        </button>

                                        <button
                                            type="button"
                                            wire:click="deleteItem({{ $item->id }})"
                                            wire:confirm="Yakin ingin menghapus item ini?"
                                            class="btn btn-danger small-btn"
                                        >
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <p class="empty-title">
                                        Belum ada makanan
                                    </p>

                                    <p class="empty-text">
                                        Pilih meal plan ini lalu tambahkan makanan dari form di sebelah kiri.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    @empty
                        <div class="empty-state">
                            <p class="empty-title">
                                Meal plan tidak ditemukan
                            </p>

                            <p class="empty-text">
                                Coba ubah kata pencarian atau reset filter.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>