<?php
namespace App\Filament\Admin\Resources\KategoriMakananResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\KategoriMakananResource;
use App\Filament\Admin\Resources\KategoriMakananResource\Api\Requests\CreateKategoriMakananRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = KategoriMakananResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create KategoriMakanan
     *
     * @param CreateKategoriMakananRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateKategoriMakananRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}