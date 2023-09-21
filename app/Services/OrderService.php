<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Receipt;

class OrderService
{
    public function create(array $data): Order
    {
        /** @var Receipt $receipt */
        $orderCalculatedRaws = [];

        $receipt = Receipt::findOrFail($data['receipt_id']);
        $totalRatio = $receipt->ratio;
        $receiptRaws = $receipt->receiptRaws;

        foreach ($receiptRaws as $receiptRaw) {
            $orderCalculatedRaws[] = [
                'receipt_raw_id' => $receiptRaw->id,

                'calculated_amount' => $this->calculateAmount(
                    batchInputs: $data['batch_inputs'],
                    ratio: $receiptRaw->ratio,
                    totalRatio: $totalRatio
                ),

                'calculated_amount_with_error' => $this->calculateAmount(
                    batchInputs: $data['batch_inputs'],
                    ratio: $receiptRaw->ratio,
                    totalRatio: $totalRatio,
                    error: $data['error']
                ),
            ];
        }

        $data['calculated_amount'] = $this->sumArray(array_column($orderCalculatedRaws, 'calculated_amount'));
        $data['calculated_amount_with_error'] = $this->sumArray(array_column($orderCalculatedRaws, 'calculated_amount_with_error'));

        /** @var Order $order */
        $order = Order::create($data);

        $order->orderCalculatedRaws()
            ->createMany($orderCalculatedRaws);

        return $order;
    }

    public function calculateAmount(array $batchInputs, float $ratio, float $totalRatio, float $error = null)
    {
        $array = [];

        foreach ($batchInputs as $input) {
            $calculated = $ratio / $totalRatio * floatval($input);

            if (! is_null($error)) {
                $calculated = $calculated * $error;
            }

            $calculated = round(floatval($calculated), 4);

            $array[] = $calculated;
        }

        return $array;
    }

    public function sumArray(array $array)
    {
        $result = [];

        foreach ($array[0] as $key => $v) {
            $result[] = array_sum(array_column($array, $key));
        }

        return $result;
    }
}
