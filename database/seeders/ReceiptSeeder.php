<?php

namespace Database\Seeders;

use App\Models\Raw;
use App\Models\Receipt;
use Illuminate\Database\Seeder;

class ReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $receipt = Receipt::create([
            'code' => 'R#1',
            'name' => 'Рецепт №1',
            'rate' => '2',
            'concentration' => '40',
            'unit' => 'кг',
            'producer_name' => 'Узб',
        ]);

        $raws = [
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

        foreach ($raws as $data) {
            $raw = Raw::whereName($data['name'])->firstOrFail();
            $receipt->receiptRaws()->create([
                'ratio' => $data['ratio'] ?? 0,
                'raw_id' => $raw->id,
            ]);
        }
    }
}
