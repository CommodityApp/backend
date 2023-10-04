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

    public function replicate(Receipt $receipt)
    {
        $data = $receipt->attributesToArray();

        unset($data['code']);
        unset($data['id']);

        $receiptRaws = [];

        foreach ($receipt->receiptRaws as $receiptRaw) {
            $receiptRaws[] = ['raw_id' => $receiptRaw->raw_id, 'ratio' => $receiptRaw->ratio];
        }

        return $this->create($data, $receiptRaws);
    }

    public function delete(Receipt $receipt): Receipt
    {
        //soft delete
        $receipt->update(['code' => null]);
        $receipt->delete();

        return $receipt;
    }
}
