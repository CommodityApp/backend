<?php

namespace App\Filament\Resources\RawResource\Pages;

use App\Filament\Resources\RawResource;
use App\Services\RawService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateRaw extends CreateRecord
{
    protected static string $resource = RawResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $rawService = new RawService();

        return $rawService->create($data);
    }
}
