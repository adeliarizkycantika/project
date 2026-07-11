<?php

namespace App\Filament\Admin\Resources\MealPlanItemResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Admin\Resources\MealPlanItemResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Admin\Resources\MealPlanItemResource\Api\Transformers\MealPlanItemTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = MealPlanItemResource::class;


    /**
     * Show MealPlanItem
     *
     * @param Request $request
     * @return MealPlanItemTransformer
     */
    public function handler(Request $request)
    {
        $id = $request->route('id');
        
        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where(static::getKeyName(), $id)
        )
            ->first();

        if (!$query) return static::sendNotFoundResponse();

        return new MealPlanItemTransformer($query);
    }
}
