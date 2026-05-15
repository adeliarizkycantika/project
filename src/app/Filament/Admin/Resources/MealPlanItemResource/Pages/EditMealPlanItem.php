<?php

namespace App\Filament\Admin\Resources\MealPlanItemResource\Pages;

use App\Filament\Admin\Resources\MealPlanItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMealPlanItem extends EditRecord
{
    protected static string $resource = MealPlanItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
