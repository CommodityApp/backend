<?php

namespace Database\Seeders;

use App\Models\AnimalType;
use App\Models\Raw;
use App\Services\RationService;
use Illuminate\Database\Seeder;

class RationSeeder extends Seeder
{
    public function __construct(public RationService $rationService)
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'code' => 'R#1',
            'name' => 'Рацион №1',
            'rate' => '2',
            'concentration' => '20',
            'unit' => 'кг',
            'producer_name' => 'Узб',
            'animal_type_id' => AnimalType::whereNotNull('parent_id')->get()->random()?->id,
        ];

        $rationRaws = [
            ['name' => 'Кукуруза', 'ratio' => 53.70],
            ['name' => 'Отруби пшеничные', 'ratio' => 5.00],
            ['name' => 'Шрот соевый 43%', 'ratio' => 11.00],
            ['name' => 'Шрот подсолнечника 34%', 'ratio' => 15.60],
            ['name' => 'Масло подсол (соевое)', 'ratio' => 2.50],
            ['name' => 'Известняк', 'ratio' => 8.33],
            ['name' => 'Мука ракушечная', 'ratio' => 2.00],
        ];

        $rationRaws = array_map(fn ($entry): array => [
            'raw_id' => Raw::firstOrCreate(['name' => $entry['name']])->id,
            'ratio' => $entry['ratio'] ?? 0,
        ], $rationRaws);

        $this->rationService->create($data, $rationRaws);
    }
}
