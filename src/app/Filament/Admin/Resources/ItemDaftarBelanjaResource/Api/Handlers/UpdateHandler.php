<?php
namespace App\Filament\Admin\Resources\ItemDaftarBelanjaResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\ItemDaftarBelanjaResource;
use App\Filament\Admin\Resources\ItemDaftarBelanjaResource\Api\Requests\UpdateItemDaftarBelanjaRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = ItemDaftarBelanjaResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update ItemDaftarBelanja
     *
     * @param UpdateItemDaftarBelanjaRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateItemDaftarBelanjaRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}