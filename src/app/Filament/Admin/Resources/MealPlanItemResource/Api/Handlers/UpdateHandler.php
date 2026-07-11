<?php
namespace App\Filament\Admin\Resources\MealPlanItemResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\MealPlanItemResource;
use App\Filament\Admin\Resources\MealPlanItemResource\Api\Requests\UpdateMealPlanItemRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = MealPlanItemResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update MealPlanItem
     *
     * @param UpdateMealPlanItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateMealPlanItemRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}