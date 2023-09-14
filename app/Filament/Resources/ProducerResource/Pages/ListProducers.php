<?php

namespace App\Filament\Resources\ProducerResource\Pages;

use App\Filament\Resources\ProducerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducers extends ListRecords
{
    protected static string $resource = ProducerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
