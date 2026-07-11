<?php
namespace App\Filament\Admin\Resources\BahanMakananResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Admin\Resources\BahanMakananResource;
use Illuminate\Routing\Router;


class BahanMakananApiService extends ApiService
{
    protected static string | null $resource = BahanMakananResource::class;

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
