<?php

namespace App\Livewire\User;

use App\Models\Makanan;
use App\Models\MealPlan;
use App\Models\MealPlanItem;
use App\Services\GenerateDaftarBelanjaService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class MealPlanSaya extends Component
{
    public string $judul = '';

    public string $tanggal_rencana = '';

    public ?string $catatan = null;

    public ?int $selectedMealPlanId = null;

    public ?int $makanan_id = null;

    public string $waktu_makan = 'sarapan';

    public int $porsi = 1;

    public ?string $catatan_item = null;

    public string $searchMealPlan = '';

    public ?string $filterTanggalRencana = null;

    public function mount(): void
    {
        $this->tanggal_rencana = now()->format('Y-m-d');
    }

    public function createMealPlan(): void
    {
        $userId = $this->getUserId();

        $validated = $this->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tanggal_rencana' => ['required', 'date'],
            'catatan' => ['nullable', 'string'],
        ]);

        $mealPlan = MealPlan::create([
            'user_id' => $userId,
            'judul' => $validated['judul'],
            'tanggal_rencana' => $validated['tanggal_rencana'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

        $this->selectedMealPlanId = $mealPlan->id;

        $this->reset([
            'judul',
            'catatan',
        ]);

        $this->tanggal_rencana = now()->format('Y-m-d');

        session()->flash('success', 'Meal plan berhasil dibuat.');
    }

    public function addItem(): void
    {
        $validated = $this->validate([
            'selectedMealPlanId' => ['required', 'integer', 'exists:meal_plans,id'],
            'makanan_id' => ['required', 'integer', 'exists:makanan,id'],
            'waktu_makan' => ['required', 'in:sarapan,makan_siang,makan_malam,snack'],
            'porsi' => ['required', 'integer', 'min:1'],
            'catatan_item' => ['nullable', 'string'],
        ]);

        $mealPlan = $this->getUserMealPlan((int) $validated['selectedMealPlanId']);

        $makanan = $this->getAllowedMakanan((int) $validated['makanan_id']);

        MealPlanItem::create([
            'meal_plan_id' => $mealPlan->id,
            'makanan_id' => $makanan->id,
            'waktu_makan' => $validated['waktu_makan'],
            'porsi' => $validated['porsi'],
            'sudah_dikonsumsi' => false,
            'dikonsumsi_pada' => null,
            'catatan' => $validated['catatan_item'] ?? null,
        ]);

        $this->reset([
            'makanan_id',
            'catatan_item',
        ]);

        $this->waktu_makan = 'sarapan';
        $this->porsi = 1;

        session()->flash('success', 'Makanan berhasil ditambahkan ke meal plan.');
    }

    public function selectMealPlan(int $mealPlanId): void
    {
        $mealPlan = $this->getUserMealPlan($mealPlanId);

        $this->selectedMealPlanId = $mealPlan->id;
    }

    public function toggleKonsumsi(int $itemId): void
    {
        $userId = $this->getUserId();

        $item = MealPlanItem::query()
            ->whereHas('mealPlan', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('id', $itemId)
            ->firstOrFail();

        $item->update([
            'sudah_dikonsumsi' => ! $item->sudah_dikonsumsi,
            'dikonsumsi_pada' => ! $item->sudah_dikonsumsi ? now() : null,
        ]);

        session()->flash('success', 'Status konsumsi berhasil diperbarui.');
    }

    public function deleteItem(int $itemId): void
    {
        $userId = $this->getUserId();

        $item = MealPlanItem::query()
            ->whereHas('mealPlan', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('id', $itemId)
            ->firstOrFail();

        $item->delete();

        session()->flash('success', 'Item meal plan berhasil dihapus.');
    }

    public function deleteMealPlan(int $mealPlanId): void
    {
        $mealPlan = $this->getUserMealPlan($mealPlanId);

        $mealPlan->delete();

        if ($this->selectedMealPlanId === $mealPlanId) {
            $this->selectedMealPlanId = null;
        }

        session()->flash('success', 'Meal plan berhasil dihapus.');
    }

    public function generateDaftarBelanja(int $mealPlanId): void
    {
        $mealPlan = $this->getUserMealPlan($mealPlanId);

        $jumlahItem = app(GenerateDaftarBelanjaService::class)->generate($mealPlan);

        if ($jumlahItem <= 0) {
            session()->flash('warning', 'Daftar belanja tidak dibuat. Pastikan meal plan memiliki makanan dan bahan makanan.');

            return;
        }

        session()->flash('success', "Daftar belanja berhasil dibuat. Total {$jumlahItem} item belanja.");
    }

    public function resetFilterMealPlan(): void
    {
        $this->reset([
            'searchMealPlan',
            'filterTanggalRencana',
        ]);
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

    private function getAllowedMakanan(int $makananId): Makanan
    {
        $userId = $this->getUserId();

        return Makanan::query()
            ->where('id', $makananId)
            ->where(function ($query) use ($userId) {
                $query
                    ->whereNull('user_id')
                    ->orWhere('user_id', $userId);
            })
            ->firstOrFail();
    }

    #[Computed]
    public function makananOptions(): Collection
    {
        $userId = $this->getUserId();

        return Makanan::query()
            ->with('kategori')
            ->where(function ($query) use ($userId) {
                $query
                    ->whereNull('user_id')
                    ->orWhere('user_id', $userId);
            })
            ->orderByRaw('CASE WHEN user_id IS NULL THEN 0 ELSE 1 END')
            ->orderBy('nama')
            ->get();
    }

    #[Computed]
    public function mealPlanOptions(): Collection
    {
        return MealPlan::query()
            ->where('user_id', $this->getUserId())
            ->orderByDesc('tanggal_rencana')
            ->orderByDesc('id')
            ->get();
    }

    #[Computed]
    public function mealPlans(): Collection
    {
        return MealPlan::query()
            ->with([
                'items.makanan',
                'itemDaftarBelanja',
            ])
            ->where('user_id', $this->getUserId())
            ->when($this->searchMealPlan !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('judul', 'like', '%' . $this->searchMealPlan . '%')
                        ->orWhere('catatan', 'like', '%' . $this->searchMealPlan . '%');
                });
            })
            ->when($this->filterTanggalRencana, function ($query) {
                $query->whereDate('tanggal_rencana', $this->filterTanggalRencana);
            })
            ->orderByDesc('tanggal_rencana')
            ->orderByDesc('id')
            ->get();
    }

    public function render()
    {
        return view('livewire.user.meal-plan-saya');
    }
}