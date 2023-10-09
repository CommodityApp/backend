<?php

namespace App\Filament\Resources\RationResource\Pages;

use App\Filament\Resources\RationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRations extends ListRecords
{
    protected static string $resource = RationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
