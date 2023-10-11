<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Receipt;
use App\Services\OrderService;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function __construct(public OrderService $orderService)
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'client_id' => Client::first()->id,
            'receipt_id' => Receipt::first()->id,
            'batch_quantity' => 2,
            'batch_inputs' => [1000, 1500],
            'date' => now()->format('Y-m-d'),
            'amount' => 2500,
            'error' => 1.005,
        ];

        $this->orderService->create($data);
    }
}
