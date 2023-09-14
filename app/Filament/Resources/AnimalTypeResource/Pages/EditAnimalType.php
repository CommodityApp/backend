<?php

namespace App\Filament\Resources\AnimalTypeResource\Pages;

use App\Filament\Resources\AnimalTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnimalType extends EditRecord
{
    protected static string $resource = AnimalTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
