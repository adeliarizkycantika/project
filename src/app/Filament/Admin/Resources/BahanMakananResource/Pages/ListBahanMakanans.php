<?php

namespace App\Filament\Admin\Resources\BahanMakananResource\Pages;

use App\Filament\Admin\Resources\BahanMakananResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBahanMakanans extends ListRecords
{
    protected static string $resource = BahanMakananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Bahan Makanan'),
        ];
    }
}