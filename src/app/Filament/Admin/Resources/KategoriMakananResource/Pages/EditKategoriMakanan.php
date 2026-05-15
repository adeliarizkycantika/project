<?php

namespace App\Filament\Admin\Resources\KategoriMakananResource\Pages;

use App\Filament\Admin\Resources\KategoriMakananResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriMakanan extends EditRecord
{
    protected static string $resource = KategoriMakananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
