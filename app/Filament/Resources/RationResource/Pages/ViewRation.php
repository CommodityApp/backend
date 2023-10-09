<?php

namespace App\Filament\Resources\RationResource\Pages;

use App\Filament\Resources\RationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRation extends ViewRecord
{
    protected static string $resource = RationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
