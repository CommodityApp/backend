<?php

namespace App\Filament\Resources\RationResource\Pages;

use App\Filament\Resources\RationResource;
use App\Services\RationService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

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

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $receiptRaws = $data['ration_raws_for_resource'];
        unset($data['ration_raws_for_resource']);

        $rationService = new RationService();

        return $rationService->update($record, $data, $receiptRaws);
    }
}
