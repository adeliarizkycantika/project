<?php
namespace App\Filament\Admin\Resources\MealPlanResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\MealPlanResource;
use App\Filament\Admin\Resources\MealPlanResource\Api\Requests\UpdateMealPlanRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = MealPlanResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update MealPlan
     *
     * @param UpdateMealPlanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateMealPlanRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}