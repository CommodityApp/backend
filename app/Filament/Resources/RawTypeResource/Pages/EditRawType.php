<?php

namespace App\Filament\Resources\RawTypeResource\Pages;

use App\Filament\Resources\RawTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRawType extends EditRecord
{
    protected static string $resource = RawTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
