<?php

namespace App\Filament\Resources\RawTypeResource\Pages;

use App\Filament\Resources\RawTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRawType extends CreateRecord
{
    protected static string $resource = RawTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
