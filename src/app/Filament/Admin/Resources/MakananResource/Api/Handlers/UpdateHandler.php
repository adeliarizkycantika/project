<?php
namespace App\Filament\Admin\Resources\MakananResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\MakananResource;
use App\Filament\Admin\Resources\MakananResource\Api\Requests\UpdateMakananRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = MakananResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update Makanan
     *
     * @param UpdateMakananRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateMakananRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}