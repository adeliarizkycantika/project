<div>
    <style>
        .food-grid {
            display: grid;
            grid-template-columns: 380px minmax(0, 1fr);
            gap: 24px;
        }

        .food-form-card {
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
            min-height: 90px;
            padding: 12px 14px;
            resize: vertical;
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

        .food-list {
            padding: 24px;
        }

        .food-card {
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            background: #ffffff;
            padding: 20px;
            margin-bottom: 18px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
        }

        .food-card:last-child {
            margin-bottom: 0;
        }

        .food-header {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .food-title {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
        }

        .food-meta {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 14px;
            font-weight: 600;
        }

        .nutrition-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
            margin: 14px 0;
        }

        .nutrition-box {
            border-radius: 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px;
        }

        .nutrition-label {
            font-size: 12px;
            color: #64748b;
            font-weight: 700;
        }

        .nutrition-value {
            margin-top: 4px;
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
        }

        .ingredient-list {
            margin-top: 16px;
            border-top: 1px solid #e2e8f0;
            padding-top: 16px;
        }

        .ingredient-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
            border-radius: 14px;
            background: #f8fafc;
            padding: 12px;
            margin-bottom: 10px;
        }

        .ingredient-row:last-child {
            margin-bottom: 0;
        }

        .ingredient-name {
            font-weight: 800;
            color: #0f172a;
        }

        .ingredient-meta {
            font-size: 13px;
            color: #64748b;
            margin-top: 2px;
        }

        .food-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .small-btn {
            padding: 9px 12px;
            font-size: 12px;
            border-radius: 12px;
        }

        @media (max-width: 980px) {
            .food-grid {
                grid-template-columns: 1fr;
            }

            .nutrition-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
    </style>

    <div class="page-header">
        <div>
            <h1 class="page-title">Makanan Saya</h1>
            <p class="page-subtitle">
                Tambahkan makanan pribadi dan bahan makanan agar bisa dipakai di meal plan.
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

    <div class="food-grid">
        <div>
            <div class="card food-form-card" style="margin-bottom: 24px;">
                <h2 class="form-title">
                    {{ $isEditing ? 'Edit Makanan' : 'Tambah Makanan' }}
                </h2>

                <form wire:submit.prevent="{{ $isEditing ? 'updateMakanan' : 'createMakanan' }}">
                    <div class="form-group">
                        <label class="form-label">Kategori</label>

                        <select wire:model="kategori_makanan_id" class="form-select">
                            <option value="">Pilih kategori</option>

                            @foreach ($this->kategoriMakanan as $kategori)
                                <option value="{{ $kategori->id }}">
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>

                        @error('kategori_makanan_id')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Makanan</label>

                        <input
                            type="text"
                            wire:model="nama"
                            class="form-input"
                            placeholder="Contoh: Roti Gandum Telur"
                        >

                        @error('nama')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>

                        <textarea
                            wire:model="deskripsi"
                            class="form-textarea"
                            placeholder="Deskripsi opsional"
                        ></textarea>

                        @error('deskripsi')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kalori</label>

                        <input
                            type="number"
                            min="0"
                            wire:model="kalori"
                            class="form-input"
                        >

                        @error('kalori')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Protein</label>

                        <input
                            type="number"
                            min="0"
                            step="0.01"
                            wire:model="protein"
                            class="form-input"
                        >

                        @error('protein')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Karbohidrat</label>

                        <input
                            type="number"
                            min="0"
                            step="0.01"
                            wire:model="karbohidrat"
                            class="form-input"
                        >

                        @error('karbohidrat')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Lemak</label>

                        <input
                            type="number"
                            min="0"
                            step="0.01"
                            wire:model="lemak"
                            class="form-input"
                        >

                        @error('lemak')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-primary" style="flex: 1;">
                            {{ $isEditing ? 'Update Makanan' : 'Simpan Makanan' }}
                        </button>

                        @if ($isEditing)
                            <button
                                type="button"
                                wire:click="cancelEdit"
                                class="btn btn-outline"
                            >
                                Batal
                            </button>
                        @endif
                    </div>
                </form>
            </div>

            <div class="card food-form-card">
                <h2 class="form-title">
                    Tambah Bahan Makanan
                </h2>

                <form wire:submit.prevent="addBahanMakanan">
                    <div class="form-group">
                        <label class="form-label">Pilih Makanan</label>

                        <select wire:model="bahan_makanan_target_id" class="form-select">
                            <option value="">Pilih makanan saya</option>

                            @foreach ($this->makananSaya as $makanan)
                                <option value="{{ $makanan->id }}">
                                    {{ $makanan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Bahan</label>

                        <input
                            type="text"
                            wire:model="bahan_nama"
                            class="form-input"
                            placeholder="Contoh: Telur"
                        >

                        @error('bahan_nama')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jumlah</label>

                        <input
                            type="number"
                            min="0"
                            step="0.01"
                            wire:model="bahan_jumlah"
                            class="form-input"
                            placeholder="Contoh: 2"
                        >

                        @error('bahan_jumlah')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Satuan</label>

                        <input
                            type="text"
                            wire:model="bahan_satuan"
                            class="form-input"
                            placeholder="gram, pcs, ml, sdm"
                        >

                        @error('bahan_satuan')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success" style="width: 100%;">
                        Simpan Bahan
                    </button>
                </form>
            </div>
        </div>

        <div class="card food-list">
            <h2 class="section-title" style="margin-bottom: 18px;">
                Daftar Makanan Saya
            </h2>

            @forelse ($this->makananSaya as $makanan)
                <div class="food-card">
                    <div class="food-header">
                        <div>
                            <h3 class="food-title">
                                {{ $makanan->nama }}
                            </h3>

                            <p class="food-meta">
                                {{ $makanan->kategori?->nama ?? 'Tanpa Kategori' }}
                            </p>

                            @if ($makanan->deskripsi)
                                <p class="food-meta">
                                    {{ $makanan->deskripsi }}
                                </p>
                            @endif
                        </div>

                        <div class="food-actions">
                            <button
                                type="button"
                                wire:click="pilihMakananUntukBahan({{ $makanan->id }})"
                                class="btn btn-success small-btn"
                            >
                                Tambah Bahan
                            </button>

                            <button
                                type="button"
                                wire:click="editMakanan({{ $makanan->id }})"
                                class="btn btn-outline small-btn"
                            >
                                Edit
                            </button>

                            <button
                                type="button"
                                wire:click="deleteMakanan({{ $makanan->id }})"
                                wire:confirm="Yakin ingin menghapus makanan ini?"
                                class="btn btn-danger small-btn"
                            >
                                Hapus
                            </button>
                        </div>
                    </div>

                    <div class="nutrition-grid">
                        <div class="nutrition-box">
                            <div class="nutrition-label">Kalori</div>
                            <div class="nutrition-value">{{ number_format($makanan->kalori) }} kkal</div>
                        </div>

                        <div class="nutrition-box">
                            <div class="nutrition-label">Protein</div>
                            <div class="nutrition-value">{{ $makanan->protein }} g</div>
                        </div>

                        <div class="nutrition-box">
                            <div class="nutrition-label">Karbohidrat</div>
                            <div class="nutrition-value">{{ $makanan->karbohidrat }} g</div>
                        </div>

                        <div class="nutrition-box">
                            <div class="nutrition-label">Lemak</div>
                            <div class="nutrition-value">{{ $makanan->lemak }} g</div>
                        </div>
                    </div>

                    <div class="ingredient-list">
                        <strong>Bahan Makanan</strong>

                        @forelse ($makanan->bahanMakanan as $bahan)
                            <div class="ingredient-row">
                                <div>
                                    <div class="ingredient-name">
                                        {{ $bahan->nama }}
                                    </div>

                                    <div class="ingredient-meta">
                                        {{ $bahan->jumlah ?? '-' }} {{ $bahan->satuan }}
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    wire:click="deleteBahanMakanan({{ $bahan->id }})"
                                    wire:confirm="Yakin ingin menghapus bahan ini?"
                                    class="btn btn-danger small-btn"
                                >
                                    Hapus
                                </button>
                            </div>
                        @empty
                            <p class="food-meta">
                                Belum ada bahan makanan.
                            </p>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <p class="empty-title">Belum ada makanan pribadi</p>
                    <p class="empty-text">
                        Tambahkan makanan pertama kamu dari form sebelah kiri.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>