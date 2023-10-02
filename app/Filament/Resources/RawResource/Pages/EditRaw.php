<?php

namespace App\Filament\Resources\RawResource\Pages;

use App\Filament\Resources\RawResource;
use App\Services\RawService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditRaw extends EditRecord
{
    protected static string $resource = RawResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $rawService = new RawService();

        return $rawService->update($record, $data);
    }
}
