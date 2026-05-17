<div>
    @php
        $statusClass = match ($statusDiet) {
            'Masih Dalam Target' => 'status-success',
            'Target Kalori Terpenuhi' => 'status-info',
            default => 'status-danger',
        };
    @endphp

    <div class="page-header">
        <div>
            <h1 class="page-title">Beranda</h1>
            <p class="page-subtitle">
                Ringkasan diet harian kamu - {{ $tanggalHariIni }}
            </p>
        </div>

        <div class="status-badge {{ $statusClass }}">
            {{ $statusDiet }}
        </div>
    </div>

    <div class="stats-grid">
        <div class="card stat-card">
            <div class="stat-label">Status Diet Hari Ini</div>
            <div class="stat-value small">{{ $statusDiet }}</div>
        </div>

        <div class="card stat-card">
            <div class="stat-label">Target Kalori</div>
            <div class="stat-value">{{ number_format($targetKalori) }}</div>
            <div class="meal-plan-note">kkal per hari</div>
        </div>

        <div class="card stat-card">
            <div class="stat-label">Kalori Masuk</div>
            <div class="stat-value">{{ number_format($kaloriMasuk) }}</div>
            <div class="meal-plan-note">kkal sudah dikonsumsi</div>
        </div>

        <div class="card stat-card">
            <div class="stat-label">Sisa / Kelebihan Kalori</div>
            <div class="stat-value small">{{ $this->sisaKaloriLabel }}</div>
        </div>
    </div>

    <div class="card section-card">
        <div class="section-header">
            <div>
                <h2 class="section-title">Jadwal Makan Hari Ini</h2>
                <p class="section-subtitle">
                    Tandai makanan sebagai dikonsumsi untuk menghitung kalori masuk.
                </p>
            </div>

            <a href="{{ route('user.meal-plans') }}" class="btn btn-primary">
                Buat Meal Plan
            </a>
        </div>

        <div class="section-body">
            @forelse ($mealPlans as $mealPlan)
                <div class="meal-plan-box">
                    <h3 class="meal-plan-title">{{ $mealPlan->judul }}</h3>

                    @if ($mealPlan->catatan)
                        <p class="meal-plan-note">{{ $mealPlan->catatan }}</p>
                    @endif

                    @forelse ($mealPlan->items as $item)
                        <div class="meal-item">
                            <div class="meal-item-left">
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
                                        <span class="pill pill-green">Sudah Dikonsumsi</span>
                                    @else
                                        <span class="pill pill-yellow">Belum Dikonsumsi</span>
                                    @endif
                                </div>

                                <p class="meal-item-title">
                                    {{ $item->makanan?->nama ?? 'Makanan tidak ditemukan' }}
                                </p>

                                <p class="meal-item-meta">
                                    {{ $item->porsi }} porsi •
                                    {{ number_format(($item->makanan?->kalori ?? 0) * $item->porsi) }} kkal
                                </p>

                                @if ($item->catatan)
                                    <p class="meal-item-meta">
                                        Catatan: {{ $item->catatan }}
                                    </p>
                                @endif
                            </div>

                            <div>
                                <button
                                    type="button"
                                    wire:click="toggleKonsumsi({{ $item->id }})"
                                    wire:loading.attr="disabled"
                                    class="btn {{ $item->sudah_dikonsumsi ? 'btn-danger' : 'btn-success' }}"
                                >
                                    {{ $item->sudah_dikonsumsi ? 'Batalkan' : 'Tandai Dimakan' }}
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state" style="margin-top: 16px;">
                            <p class="empty-title">Belum ada makanan</p>
                            <p class="empty-text">
                                Meal plan ini belum memiliki detail makanan.
                            </p>
                        </div>
                    @endforelse
                </div>
            @empty
                <div class="empty-state">
                    <p class="empty-title">Belum ada jadwal makan hari ini</p>
                    <p class="empty-text">
                        Buat meal plan dengan tanggal hari ini agar jadwal makan muncul di beranda.
                    </p>

                    <div class="empty-actions">
                        <a href="{{ route('user.meal-plans') }}" class="btn btn-primary">
                            Buat Meal Plan Sekarang
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>