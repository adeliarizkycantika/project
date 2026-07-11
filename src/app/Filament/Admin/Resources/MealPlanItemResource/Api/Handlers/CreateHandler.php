<?php
namespace App\Filament\Admin\Resources\MealPlanItemResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\MealPlanItemResource;
use App\Filament\Admin\Resources\MealPlanItemResource\Api\Requests\CreateMealPlanItemRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = MealPlanItemResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create MealPlanItem
     *
     * @param CreateMealPlanItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateMealPlanItemRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}