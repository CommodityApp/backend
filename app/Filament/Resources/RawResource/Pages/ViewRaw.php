<?php

namespace App\Filament\Resources\RawResource\Pages;

use App\Filament\Resources\RawResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRaw extends ViewRecord
{
    protected static string $resource = RawResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
