<?php

namespace Database\Seeders;

use App\Models\Raw;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class RawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $raws = [
            ['name' => 'МКФ'],
            ['name' => 'Известняк'],
            ['name' => 'Метионин'],
            ['name' => 'Лизин'],
            ['name' => 'Витам, 82049'],
            ['name' => 'Витам, 82051'],
            ['name' => 'Минер, 82048'],
            ['name' => 'Биотроник PX Top 3'],
            ['name' => 'Микофикс'],
            ['name' => 'Соль'],
            ['name' => 'Сульфат натрия'],
            ['name' => 'WX'],
            ['name' => 'VP'],
            ['name' => 'HiPhos'],
            ['name' => 'Холин 70%'],
        ];

        foreach ($raws as $raw) {
            Raw::create([
                'name' => $raw['name'],
            ]);
        }
    }
}
