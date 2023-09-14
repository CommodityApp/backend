<?php

namespace App\Filament\Resources\RawTypeResource\Pages;

use App\Filament\Resources\RawTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRawTypes extends ListRecords
{
    protected static string $resource = RawTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
