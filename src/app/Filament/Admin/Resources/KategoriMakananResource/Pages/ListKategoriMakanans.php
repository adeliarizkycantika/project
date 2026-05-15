<?php

namespace App\Filament\Admin\Resources\KategoriMakananResource\Pages;

use App\Filament\Admin\Resources\KategoriMakananResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKategoriMakanans extends ListRecords
{
    protected static string $resource = KategoriMakananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
