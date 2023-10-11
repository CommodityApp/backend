<?php

namespace Database\Seeders;

use App\Models\Raw;
use App\Services\PriceService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    public function __construct(public PriceService $priceService)
    {
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'code' => 'P#1',
            'name' => 'Прайкурант №1',
            'unit' => 'сум/кг',

        ];
        $priceRaws = [
            ['name' => 'МКФ', 'price' => 1000],
            ['name' => 'Известняк', 'price' => 2500],
            ['name' => 'Метионин', 'price' => 3000],
            ['name' => 'Лизин', 'price' => 4000],
            ['name' => 'Витам, 82049', 'price' => 5000],
            ['name' => 'Витам, 82051', 'price' => 7000],
            ['name' => 'Минер, 82048', 'price' => 8000],
            ['name' => 'Биотроник PX Top 3', 'price' => 9000],
            ['name' => 'Микофикс', 'price' => 1255.50],
            ['name' => 'Соль', 'price' => 100],
            ['name' => 'Сульфат натрия', 'price' => 4999],
            ['name' => 'WX', 'price' => 3000],
            ['name' => 'VP', 'price' => 5000],
            ['name' => 'HiPhos', 'price' => 3200],
            ['name' => 'Холин 70%', 'price' => 43999],
        ];

        $priceRaws = array_map(fn ($entry): array => [
            'raw_id' => Raw::firstOrCreate(['name' => $entry['name']])->id,
            'price' => $entry['price'] ?? 0,
        ], $priceRaws);

        $this->priceService->create($data, $priceRaws);
    }
}
