<?php
namespace App\Filament\Admin\Resources\MakananResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Admin\Resources\MakananResource;
use Illuminate\Routing\Router;


class MakananApiService extends ApiService
{
    protected static string | null $resource = MakananResource::class;

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
