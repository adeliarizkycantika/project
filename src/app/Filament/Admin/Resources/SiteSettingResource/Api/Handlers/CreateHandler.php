<?php
namespace App\Filament\Admin\Resources\SiteSettingResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\SiteSettingResource;
use App\Filament\Admin\Resources\SiteSettingResource\Api\Requests\CreateSiteSettingRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = SiteSettingResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create SiteSetting
     *
     * @param CreateSiteSettingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateSiteSettingRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}