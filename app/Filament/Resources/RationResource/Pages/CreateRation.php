<?php

namespace App\Filament\Resources\RationResource\Pages;

use App\Filament\Resources\RationResource;
use App\Services\RationService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateRation extends CreateRecord
{
    protected static string $resource = RationResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $receiptRaws = $data['ration_raws_for_resource'];
        unset($data['ration_raws_for_resource']);

        $rationService = new RationService();

        return $rationService->create($data, $receiptRaws);
    }
}
