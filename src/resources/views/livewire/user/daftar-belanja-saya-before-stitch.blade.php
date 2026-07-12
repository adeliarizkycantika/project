<div class="belanja-page">
    <style>
        .belanja-page {
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

        .belanja-hero {
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

        .belanja-hero::after {
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

        .progress-wrap {
            width: 100%;
            height: 12px;
            border-radius: 999px;
            overflow: hidden;
            background: #eef5ef;
            margin-top: 12px;
        }

        .progress-bar {
            height: 100%;
            width: {{ (int) ($summary['percentage'] ?? 0) }}%;
            border-radius: inherit;
            background: linear-gradient(90deg, var(--pm-green), var(--pm-primary));
        }

        .content-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(340px, .75fr);
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

        .filter-grid,
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

        .checkbox-box {
            border-radius: 18px;
            padding: 14px;
            background: #fffafc;
            border: 1px solid #f3dce5;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .checkbox-box input {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            accent-color: var(--pm-primary);
        }

        .checkbox-box strong {
            display: block;
            color: #242c26;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .checkbox-box span {
            display: block;
            color: var(--pm-muted);
            font-size: 12px;
            line-height: 1.45;
        }

        .item-list {
            display: grid;
            gap: 12px;
        }

        .item-card {
            border-radius: 22px;
            background: #fffafc;
            border: 1px solid #f4dfe7;
            padding: 16px;
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            gap: 14px;
            align-items: center;
        }

        .item-check {
            width: 44px;
            height: 44px;
            border-radius: 17px;
            display: grid;
            place-items: center;
            border: 1px solid #f0d7e0;
            background: #fff;
            color: var(--pm-primary-dark);
            cursor: pointer;
            font-size: 19px;
        }

        .item-check.done {
            background: #edf9f0;
            color: #2e7a4e;
            border-color: #caebd3;
        }

        .item-name {
            margin: 0;
            color: #242c26;
            font-weight: 950;
            line-height: 1.3;
        }

        .item-name.done {
            color: #88908b;
            text-decoration: line-through;
        }

        .item-detail {
            margin-top: 6px;
            color: var(--pm-muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .item-tags {
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

        .tag-done {
            background: #edf9f0;
            color: #2e7a4e;
            border-color: #caebd3;
        }

        .tag-pending {
            background: #fff4f8;
            color: #c74c7a;
            border-color: #ffd7e4;
        }

        .item-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
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

        .pagination-wrap {
            margin-top: 20px;
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
            .belanja-hero,
            .card-head,
            .card-body {
                padding: 18px;
            }

            .hero-content {
                flex-direction: column;
            }

            .hero-content .btn-main,
            .hero-content .btn-soft {
                width: 100%;
            }

            .summary-grid,
            .filter-grid,
            .form-grid {
                grid-template-columns: 1fr;
            }

            .item-card {
                grid-template-columns: 1fr;
            }

            .item-check {
                width: 100%;
            }

            .item-actions {
                flex-direction: column;
            }

            .item-actions .btn-soft,
            .item-actions .btn-danger {
                width: 100%;
            }
        }
    </style>

    <section class="belanja-hero">
        <div class="hero-content">
            <div>
                <div class="hero-eyebrow">
                    <span>🛒</span>
                    <span>Daftar Belanja</span>
                </div>

                <h1 class="hero-title">
                    Catat kebutuhan bahan
                    <span>sebelum belanja.</span>
                </h1>

                <p class="hero-desc">
                    Simpan bahan makanan, jumlah, kategori, dan status belanja
                    supaya persiapan meal plan lebih rapi dan tidak ada yang tertinggal.
                </p>
            </div>

            <button type="button" class="btn-main" wire:click="createItem">
                <span>＋</span>
                <span>Tambah Item</span>
            </button>
        </div>
    </section>

    @if (session('belanja_success'))
        <div class="alert-success">
            {{ session('belanja_success') }}
        </div>
    @endif

    @if (session('belanja_error'))
        <div class="alert-error">
            {{ session('belanja_error') }}
        </div>
    @endif

    <section class="summary-grid">
        <div class="summary-card">
            <div class="summary-icon">🧾</div>
            <div class="summary-value">
                {{ number_format((int) ($summary['total'] ?? 0), 0, ',', '.') }}
            </div>
            <div class="summary-label">Total item</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon">✅</div>
            <div class="summary-value">
                {{ number_format((int) ($summary['purchased'] ?? 0), 0, ',', '.') }}
            </div>
            <div class="summary-label">Sudah dibeli</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon">⏳</div>
            <div class="summary-value">
                {{ number_format((int) ($summary['pending'] ?? 0), 0, ',', '.') }}
            </div>
            <div class="summary-label">Belum dibeli</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon">📊</div>
            <div class="summary-value">
                {{ number_format((int) ($summary['percentage'] ?? 0), 0, ',', '.') }}%
            </div>
            <div class="summary-label">Progress belanja</div>
            <div class="progress-wrap">
                <div class="progress-bar"></div>
            </div>
        </div>
    </section>

    <section class="content-grid">
        <div class="content-card">
            <div class="card-head">
                <div>
                    <h2 class="card-title">Item Belanja</h2>
                    <p class="card-subtitle">
                        Cari, filter, tandai selesai, edit, atau hapus item belanja.
                    </p>
                </div>

                <button
                    type="button"
                    class="btn-danger"
                    wire:click="clearPurchasedItems"
                    wire:confirm="Hapus semua item yang sudah dibeli?"
                >
                    Bersihkan selesai
                </button>
            </div>

            <div class="card-body">
                <div class="filter-grid">
                    <div class="form-group">
                        <label class="form-label" for="search">Cari Item</label>
                        <input
                            id="search"
                            type="search"
                            class="form-input"
                            placeholder="Cari bahan, kategori, atau catatan..."
                            wire:model.live.debounce.400ms="search"
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="statusFilter">Status</label>
                        <select
                            id="statusFilter"
                            class="form-select"
                            wire:model.live="statusFilter"
                        >
                            <option value="">Semua status</option>
                            <option value="belum_dibeli">Belum dibeli</option>
                            <option value="sudah_dibeli">Sudah dibeli</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 22px;">
                    @if ($items->count() > 0)
                        <div class="item-list">
                            @foreach ($items as $item)
                                <article class="item-card" wire:key="belanja-item-{{ $item['id'] }}">
                                    <button
                                        type="button"
                                        class="item-check {{ $item['sudah_dibeli'] ? 'done' : '' }}"
                                        wire:click="togglePurchased({{ (int) $item['id'] }})"
                                        title="Ubah status"
                                    >
                                        {{ $item['sudah_dibeli'] ? '✓' : '○' }}
                                    </button>

                                    <div>
                                        <h3 class="item-name {{ $item['sudah_dibeli'] ? 'done' : '' }}">
                                            {{ $item['nama_item'] }}
                                        </h3>

                                        <div class="item-detail">
                                            {{ number_format((float) $item['jumlah'], 1, ',', '.') }}
                                            {{ $item['satuan'] }}
                                            · {{ $item['kategori'] }}
                                        </div>

                                        <div class="item-tags">
                                            @if ($item['sudah_dibeli'])
                                                <span class="tag tag-done">✅ Sudah dibeli</span>
                                            @else
                                                <span class="tag tag-pending">⏳ Belum dibeli</span>
                                            @endif
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
                                            class="btn-soft"
                                            wire:click="editItem({{ (int) $item['id'] }})"
                                        >
                                            Edit
                                        </button>

                                        <button
                                            type="button"
                                            class="btn-danger"
                                            wire:click="deleteItem({{ (int) $item['id'] }})"
                                            wire:confirm="Hapus item belanja ini?"
                                        >
                                            Hapus
                                        </button>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="pagination-wrap">
                            {{ $items->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">🛒</div>
                            <h4>Belum ada item belanja</h4>
                            <p>
                                Tambahkan bahan makanan pertama kamu agar kebutuhan belanja untuk meal plan lebih teratur.
                            </p>

                            <div style="margin-top: 16px;">
                                <button type="button" class="btn-main" wire:click="createItem">
                                    Tambah Item
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <aside class="content-card">
            <div class="card-head">
                <div>
                    <h2 class="card-title">
                        {{ $editingId ? 'Edit Item' : 'Tambah Item' }}
                    </h2>
                    <p class="card-subtitle">
                        Isi bahan atau kebutuhan belanja yang ingin kamu catat.
                    </p>
                </div>

                @if ($showForm)
                    <button type="button" class="btn-soft" wire:click="cancelForm">
                        Tutup
                    </button>
                @endif
            </div>

            <div class="card-body">
                @if ($showForm)
                    <form wire:submit.prevent="saveItem">
                        <div class="form-grid">
                            <div class="form-group full">
                                <label class="form-label" for="nama_item">Nama Item</label>
                                <input
                                    id="nama_item"
                                    type="text"
                                    class="form-input"
                                    placeholder="Contoh: Dada ayam, brokoli, beras merah"
                                    wire:model="nama_item"
                                >
                                @error('nama_item')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="jumlah">Jumlah</label>
                                <input
                                    id="jumlah"
                                    type="number"
                                    step="0.1"
                                    min="0.1"
                                    class="form-input"
                                    wire:model="jumlah"
                                >
                                @error('jumlah')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="satuan">Satuan</label>
                                <input
                                    id="satuan"
                                    type="text"
                                    class="form-input"
                                    placeholder="pcs, gram, kg, pack"
                                    wire:model="satuan"
                                >
                                @error('satuan')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group full">
                                <label class="form-label" for="kategori">Kategori</label>
                                <input
                                    id="kategori"
                                    type="text"
                                    class="form-input"
                                    placeholder="Contoh: Protein, Sayur, Karbohidrat"
                                    wire:model="kategori"
                                >
                                @error('kategori')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group full">
                                <label class="form-label" for="catatan">Catatan</label>
                                <textarea
                                    id="catatan"
                                    class="form-textarea"
                                    placeholder="Opsional, contoh: beli yang rendah lemak"
                                    wire:model="catatan"
                                ></textarea>
                                @error('catatan')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group full">
                                <label class="checkbox-box">
                                    <input type="checkbox" wire:model="sudah_dibeli">
                                    <span>
                                        <strong>Tandai sudah dibeli</strong>
                                        <span>Aktifkan jika item ini sudah kamu beli.</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 18px;">
                            <button type="submit" class="btn-main" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="saveItem">
                                    {{ $editingId ? 'Simpan Perubahan' : 'Simpan Item' }}
                                </span>
                                <span wire:loading wire:target="saveItem">
                                    Menyimpan...
                                </span>
                            </button>

                            <button type="button" class="btn-soft" wire:click="cancelForm">
                                Batal
                            </button>
                        </div>
                    </form>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">🧺</div>
                        <h4>Form belum dibuka</h4>
                        <p>
                            Klik tombol tambah item untuk mencatat kebutuhan belanja baru.
                        </p>

                        <div style="margin-top: 16px;">
                            <button type="button" class="btn-main" wire:click="createItem">
                                Tambah Item
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </aside>
    </section>
</div>