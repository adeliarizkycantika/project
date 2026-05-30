<div>
    <style>
        .shopping-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .shopping-stat {
            padding: 20px;
        }

        .shopping-stat-label {
            font-size: 14px;
            font-weight: 800;
            color: #64748b;
        }

        .shopping-stat-value {
            margin-top: 10px;
            font-size: 34px;
            font-weight: 900;
            color: #0f172a;
        }

        .manual-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 220px auto;
            gap: 12px;
            align-items: end;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: 1.3fr 220px 220px auto;
            gap: 12px;
            align-items: end;
        }

        .generate-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 12px;
            align-items: end;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 800;
            color: #334155;
        }

        .form-input,
        .form-select {
            width: 100%;
            height: 46px;
            padding: 0 14px;
            border: 1px solid #cbd5e1;
            border-radius: 14px;
            background: #ffffff;
            color: #0f172a;
            font-size: 14px;
            outline: none;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
        }

        .error-text {
            margin: 6px 0 0;
            color: #dc2626;
            font-size: 13px;
            font-weight: 700;
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

        .edit-info {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 14px;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            font-weight: 700;
            font-size: 14px;
        }

        .shopping-card {
            overflow: hidden;
        }

        .shopping-header {
            padding: 24px;
            border-bottom: 1px solid #e2e8f0;
        }

        .shopping-body {
            padding: 24px;
        }

        .shopping-item {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: center;
            padding: 18px;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            background: #ffffff;
            margin-bottom: 14px;
        }

        .shopping-item.checked {
            background: #f0fdf4;
            border-color: #bbf7d0;
        }

        .shopping-item.editing {
            background: #eff6ff;
            border-color: #93c5fd;
        }

        .shopping-left {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            flex: 1;
        }

        .check-button {
            width: 26px;
            height: 26px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            cursor: pointer;
            font-weight: 900;
        }

        .check-button.checked {
            background: #22c55e;
            color: #ffffff;
            border-color: #16a34a;
        }

        .item-name {
            margin: 0;
            font-size: 18px;
            font-weight: 900;
            color: #0f172a;
        }

        .item-name.checked {
            color: #64748b;
            text-decoration: line-through;
        }

        .item-meta {
            margin: 6px 0 0;
            font-size: 14px;
            color: #64748b;
            font-weight: 600;
        }

        .item-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .small-btn {
            padding: 9px 12px;
            font-size: 12px;
            border-radius: 12px;
        }

        @media (max-width: 1100px) {
            .manual-grid,
            .filter-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .generate-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {
            .shopping-stats,
            .manual-grid,
            .filter-grid,
            .generate-grid {
                grid-template-columns: 1fr;
            }

            .shopping-item {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="page-header">
        <div>
            <h1 class="page-title">
                Daftar Belanja Saya
            </h1>

            <p class="page-subtitle">
                Kelola daftar belanja dengan filter tanggal bebas, status belanja, dan pencarian item.
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

    <div class="shopping-stats">
        <div class="card shopping-stat">
            <div class="shopping-stat-label">Total Item</div>
            <div class="shopping-stat-value">{{ $this->totalItem }}</div>
        </div>

        <div class="card shopping-stat">
            <div class="shopping-stat-label">Belum Dibeli</div>
            <div class="shopping-stat-value">{{ $this->totalBelumDibeli }}</div>
        </div>

        <div class="card shopping-stat">
            <div class="shopping-stat-label">Sudah Dibeli</div>
            <div class="shopping-stat-value">{{ $this->totalSudahDibeli }}</div>
        </div>
    </div>

    <div class="card" style="padding: 24px; margin-bottom: 24px;">
        <h2 class="section-title" style="margin-bottom: 18px;">
            {{ $editingItemId ? 'Edit Item Belanja' : 'Tambah Item Belanja Manual' }}
        </h2>

        @if ($editingItemId)
            <div class="edit-info">
                Kamu sedang mengedit item daftar belanja. Klik Update untuk menyimpan perubahan atau Batal untuk keluar dari mode edit.
            </div>
        @endif

        <form wire:submit.prevent="{{ $editingItemId ? 'updateItemManual' : 'tambahItemManual' }}">
            <div class="manual-grid">
                <div>
                    <label class="form-label">Nama Item</label>

                    <input
                        type="text"
                        wire:model="nama_item"
                        class="form-input"
                        placeholder="Contoh: Beras, Telur, Susu"
                    >

                    @error('nama_item')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Jumlah</label>

                    <input
                        type="number"
                        min="0"
                        step="0.01"
                        wire:model="jumlah"
                        class="form-input"
                        placeholder="Contoh: 2"
                    >

                    @error('jumlah')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Satuan</label>

                    <input
                        type="text"
                        wire:model="satuan"
                        class="form-input"
                        placeholder="kg, pcs, gram"
                    >

                    @error('satuan')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Tanggal Belanja</label>

                    <input
                        type="date"
                        wire:model="tanggal_belanja"
                        class="form-input"
                    >

                    @error('tanggal_belanja')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display: flex; gap: 8px;">
                    <button
                        type="submit"
                        class="btn {{ $editingItemId ? 'btn-success' : 'btn-primary' }}"
                        style="height: 46px; width: 100%;"
                    >
                        {{ $editingItemId ? 'Update' : 'Tambah' }}
                    </button>

                    @if ($editingItemId)
                        <button
                            type="button"
                            wire:click="cancelEditItem"
                            class="btn btn-outline"
                            style="height: 46px;"
                        >
                            Batal
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <div class="card" style="padding: 24px; margin-bottom: 24px;">
        <h2 class="section-title" style="margin-bottom: 18px;">
            Filter Daftar Belanja
        </h2>

        <div class="filter-grid">
            <div>
                <label class="form-label">Cari Item</label>

                <input
                    type="text"
                    wire:model.live="search"
                    class="form-input"
                    placeholder="Cari nama item belanja..."
                >
            </div>

            <div>
                <label class="form-label">Tanggal</label>

                <input
                    type="date"
                    wire:model.live="selectedTanggalBelanja"
                    class="form-input"
                >
            </div>

            <div>
                <label class="form-label">Status</label>

                <select wire:model.live="selectedStatus" class="form-select">
                    <option value="semua">Semua Status</option>
                    <option value="belum">Belum Dibeli</option>
                    <option value="sudah">Sudah Dibeli</option>
                </select>
            </div>

            <div>
                <button
                    type="button"
                    wire:click="resetFilter"
                    class="btn btn-outline"
                    style="height: 46px; width: 100%;"
                >
                    Reset
                </button>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 24px; margin-bottom: 24px;">
        <h2 class="section-title" style="margin-bottom: 18px;">
            Generate dari Meal Plan
        </h2>

        <div class="generate-grid">
            <div>
                <label class="form-label">Pilih Meal Plan</label>

                <select wire:model="generateMealPlanId" class="form-select">
                    <option value="">Pilih meal plan untuk generate daftar belanja</option>

                    @foreach ($this->mealPlans as $mealPlan)
                        <option value="{{ $mealPlan->id }}">
                            {{ $mealPlan->judul }} - {{ $mealPlan->tanggal_rencana->format('d M Y') }}
                            ({{ $mealPlan->items_count }} menu, {{ $mealPlan->item_daftar_belanja_count }} item belanja)
                        </option>
                    @endforeach
                </select>
            </div>

            <button
                type="button"
                wire:click="generateDaftarBelanja"
                class="btn btn-success"
                style="height: 46px;"
            >
                Generate Belanja
            </button>
        </div>
    </div>

    <div class="card" style="padding: 24px; margin-bottom: 24px;">
        <button
            type="button"
            wire:click="clearCheckedItems"
            wire:confirm="Yakin ingin menghapus item yang sudah dibeli?"
            class="btn btn-danger"
        >
            Bersihkan Item yang Sudah Dibeli
        </button>
    </div>

    <div class="card shopping-card">
        <div class="shopping-header">
            <h2 class="section-title">
                Item Daftar Belanja
            </h2>

            <p class="section-subtitle">
                Checklist item yang sudah dibeli. Klik Edit untuk mengubah data item.
            </p>
        </div>

        <div class="shopping-body">
            @forelse ($this->itemDaftarBelanja as $item)
                <div class="shopping-item {{ $item->sudah_dibeli ? 'checked' : '' }} {{ $editingItemId === $item->id ? 'editing' : '' }}">
                    <div class="shopping-left">
                        <button
                            type="button"
                            wire:click="toggleDibeli({{ $item->id }})"
                            class="check-button {{ $item->sudah_dibeli ? 'checked' : '' }}"
                        >
                            @if ($item->sudah_dibeli)
                                ✓
                            @endif
                        </button>

                        <div>
                            <p class="item-name {{ $item->sudah_dibeli ? 'checked' : '' }}">
                                {{ $item->nama_item }}
                            </p>

                            <p class="item-meta">
                                @if ($item->jumlah)
                                    {{ number_format((float) $item->jumlah, 2, ',', '.') }}
                                @else
                                    -
                                @endif

                                {{ $item->satuan ?: '' }}
                            </p>

                            @if ($item->tanggal_belanja)
                                <p class="item-meta">
                                    Tanggal Belanja: {{ $item->tanggal_belanja->format('d M Y') }}
                                </p>
                            @endif

                            @if ($item->mealPlan)
                                <p class="item-meta">
                                    Meal Plan: {{ $item->mealPlan->judul }}
                                </p>
                            @else
                                <p class="item-meta">
                                    Input manual
                                </p>
                            @endif

                            @if ($editingItemId === $item->id)
                                <p class="item-meta" style="color: #1d4ed8; font-weight: 800;">
                                    Sedang diedit
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="item-actions">
                        <button
                            type="button"
                            wire:click="editItem({{ $item->id }})"
                            class="btn btn-outline small-btn"
                        >
                            Edit
                        </button>

                        <button
                            type="button"
                            wire:click="toggleDibeli({{ $item->id }})"
                            class="btn {{ $item->sudah_dibeli ? 'btn-outline' : 'btn-success' }} small-btn"
                        >
                            {{ $item->sudah_dibeli ? 'Batalkan' : 'Tandai Dibeli' }}
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
                        Belum ada daftar belanja
                    </p>

                    <p class="empty-text">
                        Tambahkan item manual atau generate dari meal plan.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>