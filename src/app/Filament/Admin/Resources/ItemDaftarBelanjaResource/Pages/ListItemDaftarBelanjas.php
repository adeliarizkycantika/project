<?php

namespace App\Filament\Admin\Resources\ItemDaftarBelanjaResource\Pages;

use App\Filament\Admin\Resources\ItemDaftarBelanjaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItemDaftarBelanjas extends ListRecords
{
    protected static string $resource = ItemDaftarBelanjaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
