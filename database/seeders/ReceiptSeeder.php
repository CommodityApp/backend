<?php

namespace Database\Seeders;

use App\Models\AnimalType;
use App\Models\Raw;
use App\Services\ReceiptService;
use Illuminate\Database\Seeder;

class ReceiptSeeder extends Seeder
{
    public function __construct(public ReceiptService $receiptService)
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'code' => 'R#1',
            'name' => 'Рецепт №1',
            'rate' => '2',
            'concentration' => '20',
            'unit' => 'кг',
            'producer_name' => 'Узб',
            'animal_type_id' => AnimalType::whereNotNull('parent_id')->get()->random()?->id,
        ];

        $receiptRaws = [
            ['name' => 'МКФ', 'ratio' => 4.0],
            ['name' => 'Известняк', 'ratio' => 5.655],
            ['name' => 'Метионин', 'ratio' => 1.5],
            ['name' => 'Лизин', 'ratio' => 1.5],
            ['name' => 'Витам, 82049', 'ratio' => 0.3],
            ['name' => 'Витам, 82051', 'ratio' => 0.2],
            ['name' => 'Минер, 82048', 'ratio' => 1.0],
            ['name' => 'Биотроник PX Top 3', 'ratio' => 0.5],
            ['name' => 'Микофикс', 'ratio' => 0.7],
            ['name' => 'Соль', 'ratio' => 2.0],
            ['name' => 'Сульфат натрия', 'ratio' => 2.1],
            ['name' => 'WX', 'ratio' => null],
            ['name' => 'VP', 'ratio' => 0.120],
            ['name' => 'HiPhos', 'ratio' => 0.025],
            ['name' => 'Холин 70%', 'ratio' => 0.400],
        ];

        $receiptRaws = array_map(fn ($entry): array => [
            'raw_id' => Raw::firstOrCreate(['name' => $entry['name']])->id,
            'ratio' => $entry['ratio'] ?? 0,
        ], $receiptRaws);

        $this->receiptService->create($data, $receiptRaws);
    }
}
