<?php

namespace App\Livewire\User;

use App\Models\ItemDaftarBelanja;
use App\Models\MealPlan;
use App\Services\GenerateDaftarBelanjaService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class DaftarBelanjaSaya extends Component
{
    public ?int $generateMealPlanId = null;

    public ?string $selectedTanggalBelanja = null;

    public string $selectedStatus = 'semua';

    public string $search = '';

    public string $nama_item = '';

    public ?string $jumlah = null;

    public ?string $satuan = null;

    public string $tanggal_belanja = '';

    public ?int $editingItemId = null;

    public function mount(): void
    {
        $this->tanggal_belanja = now()->format('Y-m-d');
    }

    public function tambahItemManual(): void
    {
        $validated = $this->validate([
            'nama_item' => ['required', 'string', 'max:255'],
            'jumlah' => ['nullable', 'numeric', 'min:0'],
            'satuan' => ['nullable', 'string', 'max:50'],
            'tanggal_belanja' => ['required', 'date'],
        ]);

        ItemDaftarBelanja::create([
            'user_id' => $this->getUserId(),
            'meal_plan_id' => null,
            'tanggal_belanja' => $validated['tanggal_belanja'],
            'bahan_makanan_id' => null,
            'nama_item' => $validated['nama_item'],
            'jumlah' => $validated['jumlah'] ?? null,
            'satuan' => $validated['satuan'] ?? null,
            'sudah_dibeli' => false,
        ]);

        $this->resetFormManual();

        session()->flash('success', 'Item daftar belanja berhasil ditambahkan.');
    }

    public function editItem(int $itemId): void
    {
        $item = $this->getUserItemDaftarBelanja($itemId);

        $this->editingItemId = $item->id;
        $this->nama_item = $item->nama_item;
        $this->jumlah = $item->jumlah !== null ? (string) $item->jumlah : null;
        $this->satuan = $item->satuan;
        $this->tanggal_belanja = $item->tanggal_belanja
            ? $item->tanggal_belanja->format('Y-m-d')
            : now()->format('Y-m-d');
    }

    public function updateItemManual(): void
    {
        if (! $this->editingItemId) {
            session()->flash('warning', 'Tidak ada item yang sedang diedit.');

            return;
        }

        $item = $this->getUserItemDaftarBelanja($this->editingItemId);

        $validated = $this->validate([
            'nama_item' => ['required', 'string', 'max:255'],
            'jumlah' => ['nullable', 'numeric', 'min:0'],
            'satuan' => ['nullable', 'string', 'max:50'],
            'tanggal_belanja' => ['required', 'date'],
        ]);

        $item->update([
            'nama_item' => $validated['nama_item'],
            'jumlah' => $validated['jumlah'] ?? null,
            'satuan' => $validated['satuan'] ?? null,
            'tanggal_belanja' => $validated['tanggal_belanja'],
        ]);

        $this->resetFormManual();

        session()->flash('success', 'Item daftar belanja berhasil diperbarui.');
    }

    public function cancelEditItem(): void
    {
        $this->resetFormManual();

        session()->flash('success', 'Mode edit dibatalkan.');
    }

    public function generateDaftarBelanja(): void
    {
        if (! $this->generateMealPlanId) {
            session()->flash('warning', 'Pilih meal plan terlebih dahulu.');

            return;
        }

        $mealPlan = $this->getUserMealPlan($this->generateMealPlanId);

        $jumlahItem = app(GenerateDaftarBelanjaService::class)->generate($mealPlan);

        ItemDaftarBelanja::query()
            ->where('user_id', $this->getUserId())
            ->where('meal_plan_id', $mealPlan->id)
            ->update([
                'tanggal_belanja' => $mealPlan->tanggal_rencana,
            ]);

        if ($jumlahItem <= 0) {
            session()->flash('warning', 'Daftar belanja tidak dibuat. Pastikan meal plan memiliki makanan dan bahan makanan.');

            return;
        }

        $this->selectedTanggalBelanja = $mealPlan->tanggal_rencana->format('Y-m-d');

        session()->flash('success', "Daftar belanja berhasil dibuat. Total {$jumlahItem} item belanja.");
    }

    public function toggleDibeli(int $itemId): void
    {
        $item = $this->getUserItemDaftarBelanja($itemId);

        $item->update([
            'sudah_dibeli' => ! $item->sudah_dibeli,
        ]);

        session()->flash('success', 'Status belanja berhasil diperbarui.');
    }

    public function deleteItem(int $itemId): void
    {
        $item = $this->getUserItemDaftarBelanja($itemId);

        $item->delete();

        if ($this->editingItemId === $itemId) {
            $this->resetFormManual();
        }

        session()->flash('success', 'Item daftar belanja berhasil dihapus.');
    }

    public function clearCheckedItems(): void
    {
        $query = ItemDaftarBelanja::query()
            ->where('user_id', $this->getUserId())
            ->where('sudah_dibeli', true);

        if ($this->selectedTanggalBelanja) {
            $query->whereDate('tanggal_belanja', $this->selectedTanggalBelanja);
        }

        if ($this->search !== '') {
            $query->where('nama_item', 'like', '%' . $this->search . '%');
        }

        $deletedCount = $query->delete();

        if ($deletedCount <= 0) {
            session()->flash('warning', 'Tidak ada item yang sudah dibeli untuk dibersihkan.');

            return;
        }

        $this->resetFormManual();

        session()->flash('success', "Berhasil menghapus {$deletedCount} item yang sudah dibeli.");
    }

    public function resetFilter(): void
    {
        $this->reset([
            'selectedTanggalBelanja',
            'search',
        ]);

        $this->selectedStatus = 'semua';
    }

    private function resetFormManual(): void
    {
        $this->reset([
            'editingItemId',
            'nama_item',
            'jumlah',
            'satuan',
        ]);

        $this->tanggal_belanja = now()->format('Y-m-d');
    }

    private function getUserId(): int
    {
        $userId = Auth::id();

        if (! $userId) {
            abort(403);
        }

        return (int) $userId;
    }

    private function getUserMealPlan(int $mealPlanId): MealPlan
    {
        return MealPlan::query()
            ->where('user_id', $this->getUserId())
            ->where('id', $mealPlanId)
            ->firstOrFail();
    }

    private function getUserItemDaftarBelanja(int $itemId): ItemDaftarBelanja
    {
        return ItemDaftarBelanja::query()
            ->where('user_id', $this->getUserId())
            ->where('id', $itemId)
            ->firstOrFail();
    }

    #[Computed]
    public function mealPlans(): Collection
    {
        return MealPlan::query()
            ->withCount([
                'items',
                'itemDaftarBelanja',
            ])
            ->where('user_id', $this->getUserId())
            ->orderByDesc('tanggal_rencana')
            ->orderByDesc('id')
            ->get();
    }

    #[Computed]
    public function itemDaftarBelanja(): Collection
    {
        return ItemDaftarBelanja::query()
            ->with([
                'mealPlan',
                'bahanMakanan',
            ])
            ->where('user_id', $this->getUserId())
            ->when($this->selectedTanggalBelanja, function ($query) {
                $query->whereDate('tanggal_belanja', $this->selectedTanggalBelanja);
            })
            ->when($this->selectedStatus === 'belum', function ($query) {
                $query->where('sudah_dibeli', false);
            })
            ->when($this->selectedStatus === 'sudah', function ($query) {
                $query->where('sudah_dibeli', true);
            })
            ->when($this->search !== '', function ($query) {
                $query->where('nama_item', 'like', '%' . $this->search . '%');
            })
            ->orderBy('sudah_dibeli')
            ->orderByRaw('COALESCE(tanggal_belanja, created_at) asc')
            ->orderBy('nama_item')
            ->get();
    }

    #[Computed]
    public function totalItem(): int
    {
        return $this->itemDaftarBelanja->count();
    }

    #[Computed]
    public function totalSudahDibeli(): int
    {
        return $this->itemDaftarBelanja
            ->where('sudah_dibeli', true)
            ->count();
    }

    #[Computed]
    public function totalBelumDibeli(): int
    {
        return $this->itemDaftarBelanja
            ->where('sudah_dibeli', false)
            ->count();
    }

    public function render()
    {
        return view('livewire.user.daftar-belanja-saya');
    }
}