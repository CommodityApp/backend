<?php

namespace App\Filament\Resources\BunkerResource\Pages;

use App\Filament\Resources\BunkerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBunkers extends ListRecords
{
    protected static string $resource = BunkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
