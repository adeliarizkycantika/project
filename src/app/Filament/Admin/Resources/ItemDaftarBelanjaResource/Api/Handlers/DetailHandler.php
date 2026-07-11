<?php

namespace App\Filament\Admin\Resources\ItemDaftarBelanjaResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Admin\Resources\ItemDaftarBelanjaResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Admin\Resources\ItemDaftarBelanjaResource\Api\Transformers\ItemDaftarBelanjaTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = ItemDaftarBelanjaResource::class;


    /**
     * Show ItemDaftarBelanja
     *
     * @param Request $request
     * @return ItemDaftarBelanjaTransformer
     */
    public function handler(Request $request)
    {
        $id = $request->route('id');
        
        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where(static::getKeyName(), $id)
        )
            ->first();

        if (!$query) return static::sendNotFoundResponse();

        return new ItemDaftarBelanjaTransformer($query);
    }
}
