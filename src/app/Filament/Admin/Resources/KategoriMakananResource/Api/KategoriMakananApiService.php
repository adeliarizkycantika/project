<?php
namespace App\Filament\Admin\Resources\KategoriMakananResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Admin\Resources\KategoriMakananResource;
use Illuminate\Routing\Router;


class KategoriMakananApiService extends ApiService
{
    protected static string | null $resource = KategoriMakananResource::class;

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
