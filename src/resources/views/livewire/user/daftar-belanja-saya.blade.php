<div class="min-h-screen bg-gray-50">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">
                Daftar Belanja Saya
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Kelola kebutuhan bahan makanan berdasarkan meal plan kamu.
            </p>
        </div>

        @if (session()->has('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('warning'))
            <div class="mb-6 rounded-xl border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm font-medium text-yellow-700">
                {{ session('warning') }}
            </div>
        @endif

        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="rounded-2xl border bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">
                    Total Item
                </p>

                <p class="mt-3 text-2xl font-bold text-gray-900">
                    {{ $this->totalItem }}
                </p>
            </div>

            <div class="rounded-2xl border bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">
                    Belum Dibeli
                </p>

                <p class="mt-3 text-2xl font-bold text-yellow-600">
                    {{ $this->totalBelumDibeli }}
                </p>
            </div>

            <div class="rounded-2xl border bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">
                    Sudah Dibeli
                </p>

                <p class="mt-3 text-2xl font-bold text-green-600">
                    {{ $this->totalSudahDibeli }}
                </p>
            </div>
        </div>

        <div class="mb-6 rounded-2xl border bg-white p-5 shadow-sm">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-semibold text-gray-700">
                        Filter / Generate dari Meal Plan
                    </label>

                    <select
                        wire:model.live="selectedMealPlanId"
                        class="w-full rounded-xl border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">Semua daftar belanja</option>

                        @foreach ($this->mealPlans as $mealPlan)
                            <option value="{{ $mealPlan->id }}">
                                {{ $mealPlan->judul }} - {{ $mealPlan->tanggal_rencana->format('d M Y') }}
                                ({{ $mealPlan->items_count }} menu, {{ $mealPlan->item_daftar_belanja_count }} item belanja)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button
                        type="button"
                        wire:click="generateDaftarBelanja"
                        class="w-full rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-700"
                    >
                        Generate Belanja
                    </button>

                    <button
                        type="button"
                        wire:click="clearCheckedItems"
                        wire:confirm="Yakin ingin menghapus item yang sudah dibeli?"
                        class="w-full rounded-xl border border-red-300 px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-50"
                    >
                        Bersihkan
                    </button>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border bg-white shadow-sm">
            <div class="border-b px-5 py-4">
                <h2 class="text-lg font-bold text-gray-900">
                    Item Daftar Belanja
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Checklist item yang sudah dibeli.
                </p>
            </div>

            <div class="p-5">
                @forelse ($this->itemDaftarBelanja as $item)
                    <div class="mb-3 flex flex-col gap-4 rounded-xl border p-4 last:mb-0 md:flex-row md:items-center md:justify-between {{ $item->sudah_dibeli ? 'bg-green-50' : 'bg-white' }}">
                        <div class="flex items-start gap-3">
                            <button
                                type="button"
                                wire:click="toggleDibeli({{ $item->id }})"
                                class="mt-1 flex h-6 w-6 items-center justify-center rounded-md border text-sm font-bold {{ $item->sudah_dibeli ? 'border-green-500 bg-green-500 text-white' : 'border-gray-300 bg-white text-gray-400' }}"
                            >
                                @if ($item->sudah_dibeli)
                                    ✓
                                @endif
                            </button>

                            <div>
                                <p class="font-semibold {{ $item->sudah_dibeli ? 'text-gray-500 line-through' : 'text-gray-900' }}">
                                    {{ $item->nama_item }}
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    @if ($item->jumlah)
                                        {{ number_format((float) $item->jumlah, 2, ',', '.') }}
                                    @else
                                        -
                                    @endif

                                    {{ $item->satuan }}
                                </p>

                                @if ($item->mealPlan)
                                    <p class="mt-1 text-xs text-gray-400">
                                        Meal Plan: {{ $item->mealPlan->judul }} -
                                        {{ $item->mealPlan->tanggal_rencana->format('d M Y') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <button
                                type="button"
                                wire:click="toggleDibeli({{ $item->id }})"
                                class="rounded-xl border px-3 py-2 text-xs font-semibold transition hover:bg-gray-50 {{ $item->sudah_dibeli ? 'border-yellow-300 text-yellow-700' : 'border-green-300 text-green-700' }}"
                            >
                                {{ $item->sudah_dibeli ? 'Batalkan' : 'Tandai Dibeli' }}
                            </button>

                            <button
                                type="button"
                                wire:click="deleteItem({{ $item->id }})"
                                wire:confirm="Yakin ingin menghapus item ini?"
                                class="rounded-xl border border-red-300 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-50"
                            >
                                Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed p-8 text-center">
                        <p class="font-semibold text-gray-900">
                            Belum ada daftar belanja.
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            Pilih meal plan lalu klik Generate Belanja, atau generate dari halaman Meal Plan.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>