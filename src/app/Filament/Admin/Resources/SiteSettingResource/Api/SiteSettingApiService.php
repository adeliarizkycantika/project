<?php
namespace App\Filament\Admin\Resources\SiteSettingResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Admin\Resources\SiteSettingResource;
use Illuminate\Routing\Router;


class SiteSettingApiService extends ApiService
{
    protected static string | null $resource = SiteSettingResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
