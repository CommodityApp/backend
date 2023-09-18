<?php

namespace App\Filament\Resources\BunkerResource\Pages;

use App\Filament\Resources\BunkerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBunker extends EditRecord
{
    protected static string $resource = BunkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
