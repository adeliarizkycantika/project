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
    public ?int $selectedMealPlanId = null;

    public function generateDaftarBelanja(): void
    {
        if (! $this->selectedMealPlanId) {
            session()->flash('warning', 'Pilih meal plan terlebih dahulu.');

            return;
        }

        $mealPlan = $this->getUserMealPlan($this->selectedMealPlanId);

        $jumlahItem = app(GenerateDaftarBelanjaService::class)->generate($mealPlan);

        if ($jumlahItem <= 0) {
            session()->flash('warning', 'Daftar belanja tidak dibuat. Pastikan meal plan memiliki makanan dan bahan makanan.');

            return;
        }

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

        session()->flash('success', 'Item daftar belanja berhasil dihapus.');
    }

    public function clearCheckedItems(): void
    {
        $userId = Auth::id();

        if (! $userId) {
            abort(403);
        }

        $query = ItemDaftarBelanja::query()
            ->where('user_id', $userId)
            ->where('sudah_dibeli', true);

        if ($this->selectedMealPlanId) {
            $query->where('meal_plan_id', $this->selectedMealPlanId);
        }

        $deletedCount = $query->delete();

        if ($deletedCount <= 0) {
            session()->flash('warning', 'Tidak ada item yang sudah dibeli untuk dibersihkan.');

            return;
        }

        session()->flash('success', "Berhasil menghapus {$deletedCount} item yang sudah dibeli.");
    }

    private function getUserMealPlan(int $mealPlanId): MealPlan
    {
        $userId = Auth::id();

        if (! $userId) {
            abort(403);
        }

        return MealPlan::query()
            ->where('user_id', $userId)
            ->where('id', $mealPlanId)
            ->firstOrFail();
    }

    private function getUserItemDaftarBelanja(int $itemId): ItemDaftarBelanja
    {
        $userId = Auth::id();

        if (! $userId) {
            abort(403);
        }

        return ItemDaftarBelanja::query()
            ->where('user_id', $userId)
            ->where('id', $itemId)
            ->firstOrFail();
    }

    #[Computed]
    public function mealPlans(): Collection
    {
        $userId = Auth::id();

        if (! $userId) {
            return collect();
        }

        return MealPlan::query()
            ->withCount([
                'items',
                'itemDaftarBelanja',
            ])
            ->where('user_id', $userId)
            ->orderByDesc('tanggal_rencana')
            ->orderByDesc('id')
            ->get();
    }

    #[Computed]
    public function itemDaftarBelanja(): Collection
    {
        $userId = Auth::id();

        if (! $userId) {
            return collect();
        }

        return ItemDaftarBelanja::query()
            ->with([
                'mealPlan',
                'bahanMakanan',
            ])
            ->where('user_id', $userId)
            ->when($this->selectedMealPlanId, function ($query) {
                $query->where('meal_plan_id', $this->selectedMealPlanId);
            })
            ->orderBy('sudah_dibeli')
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