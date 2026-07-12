<div class="makanan-page">
    <style>
        .makanan-page {
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

        .makanan-hero {
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

        .makanan-hero::after {
            content: "";
            position: absolute;
            width: 210px;
            height: 210px;
            border-radius: 999px;
            right: -70px;
            bottom: -85px;
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

        .btn-main:hover,
        .btn-green:hover {
            transform: translateY(-1px);
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
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .form-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
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

        .toggle-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .toggle-box {
            border-radius: 18px;
            padding: 14px;
            background: #fffafc;
            border: 1px solid #f3dce5;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .toggle-box input {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            accent-color: var(--pm-primary);
        }

        .toggle-box strong {
            display: block;
            color: #242c26;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .toggle-box span {
            display: block;
            color: var(--pm-muted);
            font-size: 12px;
            line-height: 1.45;
        }

        .makanan-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .makanan-card {
            display: flex;
            flex-direction: column;
            min-height: 100%;
            border-radius: 24px;
            background: #fff;
            border: 1px solid #f0dfe5;
            box-shadow: 0 12px 28px rgba(37, 44, 39, .05);
            overflow: hidden;
        }

        .makanan-visual {
            height: 118px;
            background:
                radial-gradient(circle at 25% 30%, rgba(255, 255, 255, .8), transparent 25%),
                linear-gradient(135deg, #ffe1ec, #ecf8ee);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
        }

        .makanan-content {
            padding: 17px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .makanan-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .makanan-name {
            margin: 0;
            font-size: 16px;
            font-weight: 900;
            color: #242c26;
            line-height: 1.35;
        }

        .makanan-category {
            display: inline-flex;
            align-items: center;
            margin-top: 8px;
            padding: 5px 9px;
            border-radius: 999px;
            background: #f5faf6;
            border: 1px solid #dbeee1;
            color: #4c7f5e;
            font-weight: 900;
            font-size: 11px;
        }

        .makanan-desc {
            margin: 10px 0 0;
            color: var(--pm-muted);
            font-size: 13px;
            line-height: 1.55;
            flex: 1;
        }

        .badge-stack {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-top: 12px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border-radius: 999px;
            padding: 6px 9px;
            font-size: 11px;
            font-weight: 900;
            border: 1px solid transparent;
        }

        .badge-public {
            background: #edf9f0;
            color: #2e7a4e;
            border-color: #caebd3;
        }

        .badge-private {
            background: #fff4f8;
            color: #c74c7a;
            border-color: #ffd7e4;
        }

        .badge-recommended {
            background: #fff8df;
            color: #987021;
            border-color: #f7e7a8;
        }

        .nutrition-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            margin: 14px 0;
        }

        .nutrition-box {
            border-radius: 14px;
            background: #fff8fb;
            border: 1px solid #f4dfe7;
            padding: 9px;
        }

        .nutrition-box strong {
            display: block;
            font-size: 14px;
            color: #242c26;
        }

        .nutrition-box span {
            display: block;
            margin-top: 2px;
            font-size: 11px;
            font-weight: 800;
            color: var(--pm-muted);
        }

        .card-actions {
            display: flex;
            gap: 8px;
            margin-top: auto;
        }

        .card-actions .btn-soft,
        .card-actions .btn-danger {
            flex: 1;
            min-height: 38px;
            padding: 9px 12px;
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
            max-width: 420px;
            color: var(--pm-muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .pagination-wrap {
            margin-top: 20px;
        }

        @media (max-width: 1100px) {
            .makanan-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 720px) {
            .makanan-hero,
            .card-head,
            .card-body {
                padding: 18px;
            }

            .hero-content {
                flex-direction: column;
            }

            .hero-content .btn-main {
                width: 100%;
            }

            .makanan-grid,
            .form-grid,
            .toggle-row {
                grid-template-columns: 1fr;
            }

            .card-actions {
                flex-direction: column;
            }
        }
    </style>

    <section class="makanan-hero">
        <div class="hero-content">
            <div>
                <div class="hero-eyebrow">
                    <span>🥬</span>
                    <span>Database Makanan</span>
                </div>

                <h1 class="hero-title">
                    Kelola makanan sehat
                    <span>untuk meal plan kamu.</span>
                </h1>

                <p class="hero-desc">
                    Tambahkan makanan beserta kandungan kalori, protein, karbohidrat,
                    dan lemak agar bisa dipakai untuk menyusun meal plan harian.
                </p>
            </div>

            <button type="button" class="btn-main" wire:click="createMakanan">
                <span>＋</span>
                <span>Tambah Makanan</span>
            </button>
        </div>
    </section>

    @if (session('makanan_success'))
        <div class="alert-success">
            {{ session('makanan_success') }}
        </div>
    @endif

    @if (session('makanan_error'))
        <div class="alert-error">
            {{ session('makanan_error') }}
        </div>
    @endif

    @if ($showForm)
        <section class="content-card">
            <div class="card-head">
                <div>
                    <h2 class="card-title">
                        {{ $editingId ? 'Edit Makanan' : 'Tambah Makanan Baru' }}
                    </h2>
                    <p class="card-subtitle">
                        Isi data nutrisi per porsi agar perhitungan kalori lebih akurat.
                    </p>
                </div>

                <button type="button" class="btn-soft" wire:click="cancelForm">
                    Tutup
                </button>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="saveMakanan">
                    <div class="form-grid">
                        <div class="form-group full">
                            <label class="form-label" for="nama">Nama Makanan</label>
                            <input
                                id="nama"
                                type="text"
                                class="form-input"
                                placeholder="Contoh: Nasi merah ayam panggang"
                                wire:model="nama"
                            >
                            @error('nama')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="kategori_makanan_id">Kategori</label>
                            <select
                                id="kategori_makanan_id"
                                class="form-select"
                                wire:model="kategori_makanan_id"
                            >
                                <option value="">Tanpa kategori</option>
                                @foreach ($kategoriOptions as $id => $label)
                                    <option value="{{ $id }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('kategori_makanan_id')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="kalori">Kalori / Porsi</label>
                            <input
                                id="kalori"
                                type="number"
                                min="0"
                                class="form-input"
                                placeholder="Contoh: 350"
                                wire:model="kalori"
                            >
                            @error('kalori')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="protein">Protein / Porsi</label>
                            <input
                                id="protein"
                                type="number"
                                min="0"
                                step="0.1"
                                class="form-input"
                                placeholder="gram"
                                wire:model="protein"
                            >
                            @error('protein')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="karbohidrat">Karbohidrat / Porsi</label>
                            <input
                                id="karbohidrat"
                                type="number"
                                min="0"
                                step="0.1"
                                class="form-input"
                                placeholder="gram"
                                wire:model="karbohidrat"
                            >
                            @error('karbohidrat')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="lemak">Lemak / Porsi</label>
                            <input
                                id="lemak"
                                type="number"
                                min="0"
                                step="0.1"
                                class="form-input"
                                placeholder="gram"
                                wire:model="lemak"
                            >
                            @error('lemak')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="porsi">Jumlah Porsi</label>
                            <input
                                id="porsi"
                                type="number"
                                min="0.1"
                                step="0.1"
                                class="form-input"
                                wire:model="porsi"
                            >
                            @error('porsi')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="satuan">Satuan</label>
                            <input
                                id="satuan"
                                type="text"
                                class="form-input"
                                placeholder="Contoh: porsi, gram, mangkuk"
                                wire:model="satuan"
                            >
                            @error('satuan')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label class="form-label" for="deskripsi">Deskripsi</label>
                            <textarea
                                id="deskripsi"
                                class="form-textarea"
                                placeholder="Contoh: Cocok untuk makan siang tinggi protein."
                                wire:model="deskripsi"
                            ></textarea>
                            @error('deskripsi')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <div class="toggle-row">
                                <label class="toggle-box">
                                    <input type="checkbox" wire:model="is_public">
                                    <span>
                                        <strong>Tampilkan untuk publik</strong>
                                        <span>Makanan bisa muncul sebagai pilihan umum.</span>
                                    </span>
                                </label>

                                <label class="toggle-box">
                                    <input type="checkbox" wire:model="is_recommended">
                                    <span>
                                        <strong>Jadikan rekomendasi</strong>
                                        <span>Makanan bisa muncul di rekomendasi dashboard.</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group full">
                            <label class="form-label" for="recommended_note">Catatan Rekomendasi</label>
                            <textarea
                                id="recommended_note"
                                class="form-textarea"
                                placeholder="Opsional, contoh: tinggi protein dan cocok untuk setelah olahraga."
                                wire:model="recommended_note"
                            ></textarea>
                            @error('recommended_note')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 18px;">
                        <button type="submit" class="btn-main" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="saveMakanan">
                                {{ $editingId ? 'Simpan Perubahan' : 'Simpan Makanan' }}
                            </span>
                            <span wire:loading wire:target="saveMakanan">
                                Menyimpan...
                            </span>
                        </button>

                        <button type="button" class="btn-soft" wire:click="cancelForm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </section>
    @endif

    <section class="content-card">
        <div class="card-head">
            <div>
                <h2 class="card-title">Daftar Makanan</h2>
                <p class="card-subtitle">
                    Cari, filter, edit, atau hapus makanan yang kamu punya.
                </p>
            </div>
        </div>

        <div class="card-body">
            <div class="filter-grid">
                <div class="form-group">
                    <label class="form-label" for="search">Cari Makanan</label>
                    <input
                        id="search"
                        type="search"
                        class="form-input"
                        placeholder="Cari nama atau deskripsi..."
                        wire:model.live.debounce.400ms="search"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="kategoriFilter">Kategori</label>
                    <select
                        id="kategoriFilter"
                        class="form-select"
                        wire:model.live="kategoriFilter"
                    >
                        <option value="">Semua kategori</option>
                        @foreach ($kategoriOptions as $id => $label)
                            <option value="{{ $id }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="visibilityFilter">Filter</label>
                    <select
                        id="visibilityFilter"
                        class="form-select"
                        wire:model.live="visibilityFilter"
                    >
                        <option value="">Semua makanan</option>
                        <option value="mine">Makanan saya</option>
                        <option value="public">Publik</option>
                        <option value="recommended">Rekomendasi</option>
                    </select>
                </div>
            </div>

            <div style="margin-top: 22px;">
                @if ($makanans->count() > 0)
                    <div class="makanan-grid">
                        @foreach ($makanans as $makanan)
                            <article class="makanan-card" wire:key="makanan-card-{{ $makanan['id'] }}">
                                <div class="makanan-visual">
                                    🥗
                                </div>

                                <div class="makanan-content">
                                    <div class="makanan-top">
                                        <div>
                                            <h3 class="makanan-name">
                                                {{ $makanan['nama'] }}
                                            </h3>

                                            <span class="makanan-category">
                                                {{ $makanan['kategori'] }}
                                            </span>
                                        </div>
                                    </div>

                                    <p class="makanan-desc">
                                        {{ $makanan['deskripsi'] ?: 'Belum ada deskripsi makanan.' }}
                                    </p>

                                    <div class="badge-stack">
                                        @if ($makanan['is_public'])
                                            <span class="badge badge-public">🌿 Publik</span>
                                        @else
                                            <span class="badge badge-private">🔒 Pribadi</span>
                                        @endif

                                        @if ($makanan['is_recommended'])
                                            <span class="badge badge-recommended">⭐ Rekomendasi</span>
                                        @endif
                                    </div>

                                    <div class="nutrition-grid">
                                        <div class="nutrition-box">
                                            <strong>{{ number_format((float) $makanan['kalori'], 0, ',', '.') }}</strong>
                                            <span>Kalori</span>
                                        </div>

                                        <div class="nutrition-box">
                                            <strong>{{ number_format((float) $makanan['protein'], 1, ',', '.') }}g</strong>
                                            <span>Protein</span>
                                        </div>

                                        <div class="nutrition-box">
                                            <strong>{{ number_format((float) $makanan['karbohidrat'], 1, ',', '.') }}g</strong>
                                            <span>Karbo</span>
                                        </div>

                                        <div class="nutrition-box">
                                            <strong>{{ number_format((float) $makanan['lemak'], 1, ',', '.') }}g</strong>
                                            <span>Lemak</span>
                                        </div>
                                    </div>

                                    <div style="color: var(--pm-muted); font-size: 12px; font-weight: 800; margin-bottom: 14px;">
                                        {{ number_format((float) $makanan['porsi'], 1, ',', '.') }}
                                        {{ $makanan['satuan'] }}
                                    </div>

                                    @if (! empty($makanan['recommended_note']))
                                        <div style="border-radius: 15px; padding: 10px; background: #fff8df; color: #987021; font-size: 12px; line-height: 1.5; margin-bottom: 14px;">
                                            {{ $makanan['recommended_note'] }}
                                        </div>
                                    @endif

                                    @if ($makanan['is_owner'])
                                        <div class="card-actions">
                                            <button
                                                type="button"
                                                class="btn-soft"
                                                wire:click="editMakanan({{ (int) $makanan['id'] }})"
                                            >
                                                Edit
                                            </button>

                                            <button
                                                type="button"
                                                class="btn-danger"
                                                wire:click="deleteMakanan({{ (int) $makanan['id'] }})"
                                                wire:confirm="Hapus makanan ini?"
                                            >
                                                Hapus
                                            </button>
                                        </div>
                                    @else
                                        <div style="margin-top: auto;">
                                            <span class="badge badge-public">
                                                Makanan publik
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="pagination-wrap">
                        {{ $makanans->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">🥬</div>
                        <h4>Belum ada data makanan</h4>
                        <p>
                            Tambahkan makanan pertama kamu supaya bisa dipakai untuk menyusun meal plan
                            dan rekomendasi menu harian.
                        </p>

                        <div style="margin-top: 16px;">
                            <button type="button" class="btn-main" wire:click="createMakanan">
                                Tambah Makanan
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>