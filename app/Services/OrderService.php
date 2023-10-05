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
            $orderCalculatedRaws[$receiptRaw->id] = [
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

                'ratio' => $receiptRaw->ratio,
                'price' => $receiptRaw->raw->lastRawPrice?->price,
                'raw_price_id' => $receiptRaw->raw->last_raw_price_id,
            ];
        }

        $data['price'] = round(floatval(array_sum(array_filter(array_column($orderCalculatedRaws, 'price')))), 2);
        $data['ratio'] = round(floatval(array_sum(array_filter(array_column($orderCalculatedRaws, 'ratio')))), 4);
        $data['calculated_amount'] = $this->sumArray(array_column($orderCalculatedRaws, 'calculated_amount'), $data['batch_inputs']);
        $data['calculated_amount_with_error'] = $this->sumArray(array_column($orderCalculatedRaws, 'calculated_amount_with_error'), $data['batch_inputs']);

        $orderCalculatedRaws = array_map(fn ($entry): array => [
            ...$entry,
            'calculated_amount' => json_encode($entry['calculated_amount']),
            'calculated_amount_with_error' => json_encode($entry['calculated_amount_with_error']),
        ], $orderCalculatedRaws);

        /** @var Order $order */
        $order = Order::create($data);

        $order->receiptRaws()
            ->sync($orderCalculatedRaws);

        return $order;
    }

    public function update(Order $order, array $data): Order
    {
        /** @var Receipt $receipt */
        $orderCalculatedRaws = [];

        $receipt = Receipt::findOrFail($data['receipt_id']);
        $totalRatio = $receipt->ratio;
        $receiptRaws = $receipt->receiptRaws;

        foreach ($receiptRaws as $receiptRaw) {
            $orderCalculatedRaws[$receiptRaw->id] = [
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

                'ratio' => $receiptRaw->ratio,
                'price' => $receiptRaw->raw->lastRawPrice?->price,
                'raw_price_id' => $receiptRaw->raw->last_raw_price_id,
            ];
        }

        $data['price'] = round(floatval(array_sum(array_filter(array_column($orderCalculatedRaws, 'price')))), 2);
        $data['ratio'] = round(floatval(array_sum(array_filter(array_column($orderCalculatedRaws, 'ratio')))), 4);
        $data['calculated_amount'] = $this->sumArray(array_column($orderCalculatedRaws, 'calculated_amount'), $data['batch_inputs']);
        $data['calculated_amount_with_error'] = $this->sumArray(array_column($orderCalculatedRaws, 'calculated_amount_with_error'), $data['batch_inputs']);

        $orderCalculatedRaws = array_map(fn ($entry): array => [
            ...$entry,
            'calculated_amount' => json_encode($entry['calculated_amount']),
            'calculated_amount_with_error' => json_encode($entry['calculated_amount_with_error']),
        ], $orderCalculatedRaws);

        $order->update($data);

        $order->receiptRaws()
            ->sync($orderCalculatedRaws);

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

    public function sumArray(array $array, array $batch_inputs)
    {
        $result = [];

        foreach ($batch_inputs as $key => $v) {
            $result[] = round(floatval(array_sum(array_column($array, $key))), 4);
        }

        return $result;
    }
}
