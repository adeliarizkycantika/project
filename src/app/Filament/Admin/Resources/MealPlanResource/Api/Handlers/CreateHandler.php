<?php
namespace App\Filament\Admin\Resources\MealPlanResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\MealPlanResource;
use App\Filament\Admin\Resources\MealPlanResource\Api\Requests\CreateMealPlanRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = MealPlanResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create MealPlan
     *
     * @param CreateMealPlanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateMealPlanRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}