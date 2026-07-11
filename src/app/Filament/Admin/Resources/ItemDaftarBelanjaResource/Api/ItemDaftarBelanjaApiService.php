<?php
namespace App\Filament\Admin\Resources\ItemDaftarBelanjaResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Admin\Resources\ItemDaftarBelanjaResource;
use Illuminate\Routing\Router;


class ItemDaftarBelanjaApiService extends ApiService
{
    protected static string | null $resource = ItemDaftarBelanjaResource::class;

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
