<?php
namespace App\Filament\Admin\Resources\MakananResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\MakananResource;
use App\Filament\Admin\Resources\MakananResource\Api\Requests\CreateMakananRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = MakananResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create Makanan
     *
     * @param CreateMakananRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateMakananRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}