<?php

namespace App\Filament\Resources\ReceiptResource\Pages;

use App\Filament\Resources\ReceiptResource;
use App\Services\ReceiptService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateReceipt extends CreateRecord
{
    protected static string $resource = ReceiptResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $receiptRaws = $data['receipt_raws_for_resource'];
        unset($data['receipt_raws_for_resource']);

        $receiptService = new ReceiptService();

        return $receiptService->create($data, $receiptRaws);
    }
}
