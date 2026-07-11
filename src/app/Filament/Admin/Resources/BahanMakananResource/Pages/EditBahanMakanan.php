<?php

namespace App\Filament\Admin\Resources\BahanMakananResource\Pages;

use App\Filament\Admin\Resources\BahanMakananResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBahanMakanan extends EditRecord
{
    protected static string $resource = BahanMakananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Hapus'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}