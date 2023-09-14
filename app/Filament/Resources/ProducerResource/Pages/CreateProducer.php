<?php

namespace App\Filament\Resources\ProducerResource\Pages;

use App\Filament\Resources\ProducerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProducer extends CreateRecord
{
    protected static string $resource = ProducerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
