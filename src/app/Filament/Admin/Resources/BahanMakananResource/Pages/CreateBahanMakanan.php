<?php

namespace App\Filament\Admin\Resources\BahanMakananResource\Pages;

use App\Filament\Admin\Resources\BahanMakananResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBahanMakanan extends CreateRecord
{
    protected static string $resource = BahanMakananResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}