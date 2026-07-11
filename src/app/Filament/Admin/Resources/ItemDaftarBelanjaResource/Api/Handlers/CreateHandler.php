<?php
namespace App\Filament\Admin\Resources\ItemDaftarBelanjaResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\ItemDaftarBelanjaResource;
use App\Filament\Admin\Resources\ItemDaftarBelanjaResource\Api\Requests\CreateItemDaftarBelanjaRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = ItemDaftarBelanjaResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create ItemDaftarBelanja
     *
     * @param CreateItemDaftarBelanjaRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateItemDaftarBelanjaRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}