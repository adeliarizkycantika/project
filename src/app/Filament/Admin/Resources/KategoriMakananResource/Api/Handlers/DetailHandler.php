<?php

namespace App\Filament\Admin\Resources\KategoriMakananResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Admin\Resources\KategoriMakananResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Admin\Resources\KategoriMakananResource\Api\Transformers\KategoriMakananTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = KategoriMakananResource::class;


    /**
     * Show KategoriMakanan
     *
     * @param Request $request
     * @return KategoriMakananTransformer
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

        return new KategoriMakananTransformer($query);
    }
}
