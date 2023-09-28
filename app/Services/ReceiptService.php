<?php

namespace App\Services;

use App\Models\Receipt;

class ReceiptService
{
    public function create(array $data, array $receiptRaws): Receipt
    {
        $receipt = Receipt::create($data);

        $raws = [];

        foreach ($receiptRaws as $key => $receiptRaw) {
            dd($key);
            $raws[$receiptRaw['raw_id']] = ['ratio' => $receiptRaw['ratio'], 'order_column' => $key + 1];
        }

        $receipt->raws()->sync($raws);

        return $receipt;
    }

    public function update(Receipt $receipt, array $data, array $receiptRaws): Receipt
    {
        $receipt->update($data);

        $raws = [];

        foreach ($receiptRaws as $key => $receiptRaw) {
            $raws[$receiptRaw['raw_id']] = ['ratio' => $receiptRaw['ratio'], 'order_column' => $key + 1];
        }

        $receipt->raws()->sync($raws);

        return $receipt;
    }
}
