<?php

namespace App\Filament\Resources\RawResource\Pages;

use App\Filament\Resources\RawResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRaw extends EditRecord
{
    protected static string $resource = RawResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
