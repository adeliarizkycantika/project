<?php

namespace App\Livewire\User;

use App\Models\MealPlan;
use App\Models\MealPlanItem;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class BerandaDiet extends Component
{
    public int $targetKalori = 0;

    public int $targetKaloriInput = 2000;

    public int $kaloriMasuk = 0;

    public int $sisaKalori = 0;

    public float $proteinMasuk = 0;

    public float $karbohidratMasuk = 0;

    public float $lemakMasuk = 0;

    public string $statusDiet = '';

    public string $tanggalHariIni = '';

    public $mealPlans;

    public function mount(): void
    {
        $this->tanggalHariIni = now()->translatedFormat('l, d F Y');

        $this->loadData();
    }

    public function loadData(): void
    {
        $userId = Auth::id();

        if (! $userId) {
            return;
        }

        $user = User::query()->findOrFail($userId);

        $this->targetKalori = (int) ($user->daily_calorie_target ?? 2000);

        $this->targetKaloriInput = $this->targetKalori;

        $this->mealPlans = MealPlan::query()
            ->with(['items.makanan'])
            ->where('user_id', $user->id)
            ->whereDate('tanggal_rencana', Carbon::today())
            ->orderBy('tanggal_rencana')
            ->get();

        $consumedItems = $this->mealPlans
            ->flatMap(fn (MealPlan $mealPlan) => $mealPlan->items)
            ->filter(fn (MealPlanItem $item): bool => (bool) $item->sudah_dikonsumsi);

        $this->kaloriMasuk = (int) $consumedItems
            ->sum(function (MealPlanItem $item): int {
                if (! $item->makanan) {
                    return 0;
                }

                return (int) $item->makanan->kalori * (int) $item->porsi;
            });

        $this->proteinMasuk = (float) $consumedItems
            ->sum(function (MealPlanItem $item): float {
                if (! $item->makanan) {
                    return 0;
                }

                return (float) $item->makanan->protein * (int) $item->porsi;
            });

        $this->karbohidratMasuk = (float) $consumedItems
            ->sum(function (MealPlanItem $item): float {
                if (! $item->makanan) {
                    return 0;
                }

                return (float) $item->makanan->karbohidrat * (int) $item->porsi;
            });

        $this->lemakMasuk = (float) $consumedItems
            ->sum(function (MealPlanItem $item): float {
                if (! $item->makanan) {
                    return 0;
                }

                return (float) $item->makanan->lemak * (int) $item->porsi;
            });

        $this->sisaKalori = $this->targetKalori - $this->kaloriMasuk;

        $this->statusDiet = match (true) {
            $this->sisaKalori > 0 => 'Masih Dalam Target',
            $this->sisaKalori === 0 => 'Target Kalori Terpenuhi',
            default => 'Melebihi Target Kalori',
        };
    }

    public function updateTargetKalori(): void
    {
        $userId = Auth::id();

        if (! $userId) {
            abort(403);
        }

        $validated = $this->validate([
            'targetKaloriInput' => ['required', 'integer', 'min:1', 'max:10000'],
        ]);

        $user = User::query()->findOrFail($userId);

        $user->update([
            'daily_calorie_target' => $validated['targetKaloriInput'],
        ]);

        $this->loadData();

        session()->flash('success', 'Target kalori harian berhasil diperbarui.');
    }

    public function toggleKonsumsi(int $mealPlanItemId): void
    {
        $userId = Auth::id();

        if (! $userId) {
            abort(403);
        }

        $item = MealPlanItem::query()
            ->whereHas('mealPlan', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('id', $mealPlanItemId)
            ->firstOrFail();

        $item->update([
            'sudah_dikonsumsi' => ! $item->sudah_dikonsumsi,
            'dikonsumsi_pada' => ! $item->sudah_dikonsumsi ? now() : null,
        ]);

        $this->loadData();
    }

    #[Computed]
    public function statusColor(): string
    {
        return match (true) {
            $this->sisaKalori > 0 => 'text-green-700 bg-green-100 border-green-200',
            $this->sisaKalori === 0 => 'text-blue-700 bg-blue-100 border-blue-200',
            default => 'text-red-700 bg-red-100 border-red-200',
        };
    }

    #[Computed]
    public function sisaKaloriLabel(): string
    {
        if ($this->sisaKalori < 0) {
            return 'Kelebihan ' . abs($this->sisaKalori) . ' kkal';
        }

        return 'Sisa ' . $this->sisaKalori . ' kkal';
    }

    public function render()
    {
        return view('livewire.user.beranda-diet');
    }
}