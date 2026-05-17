<?php

namespace App\Filament\Admin\Widgets;

use App\Models\BahanMakanan;
use App\Models\ItemDaftarBelanja;
use App\Models\KategoriMakanan;
use App\Models\Makanan;
use App\Models\MealPlan;
use App\Models\MealPlanItem;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MealPlannerStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total User', User::query()->count())
                ->description('Jumlah akun pengguna')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Kategori Makanan', KategoriMakanan::query()->count())
                ->description('Total kategori makanan')
                ->descriptionIcon('heroicon-m-tag')
                ->color('info'),

            Stat::make('Makanan', Makanan::query()->count())
                ->description('Total data makanan')
                ->descriptionIcon('heroicon-m-cake')
                ->color('success'),

            Stat::make('Bahan Makanan', BahanMakanan::query()->count())
                ->description('Total bahan makanan')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning'),

            Stat::make('Meal Plan', MealPlan::query()->count())
                ->description('Total rencana makan')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),

            Stat::make('Detail Meal Plan', MealPlanItem::query()->count())
                ->description('Total item jadwal makan')
                ->descriptionIcon('heroicon-m-list-bullet')
                ->color('success'),

            Stat::make('Daftar Belanja', ItemDaftarBelanja::query()->count())
                ->description('Total item belanja')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('danger'),
        ];
    }
}