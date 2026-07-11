<?php
namespace App\Filament\Admin\Resources\KategoriMakananResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\KategoriMakananResource;
use App\Filament\Admin\Resources\KategoriMakananResource\Api\Requests\UpdateKategoriMakananRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = KategoriMakananResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update KategoriMakanan
     *
     * @param UpdateKategoriMakananRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateKategoriMakananRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}