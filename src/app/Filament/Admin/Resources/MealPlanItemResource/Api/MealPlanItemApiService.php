<?php
namespace App\Filament\Admin\Resources\MealPlanItemResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Admin\Resources\MealPlanItemResource;
use Illuminate\Routing\Router;


class MealPlanItemApiService extends ApiService
{
    protected static string | null $resource = MealPlanItemResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
