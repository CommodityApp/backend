<?php

namespace App\Filament\Resources\RationResource\Pages;

use App\Filament\Resources\RationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRation extends EditRecord
{
    protected static string $resource = RationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
