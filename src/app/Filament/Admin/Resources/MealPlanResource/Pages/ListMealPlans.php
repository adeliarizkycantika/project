<?php

namespace App\Filament\Admin\Resources\MealPlanResource\Pages;

use App\Filament\Admin\Resources\MealPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMealPlans extends ListRecords
{
    protected static string $resource = MealPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
