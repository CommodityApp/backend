<?php

namespace Database\Seeders;

use App\Models\RawType;
use Illuminate\Database\Seeder;

class RawTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rawTypes = [
            ['name' => 'Витаминная смесь'],
            ['name' => 'Минеральная смесь'],
            ['name' => 'Аминокислоты'],
            ['name' => 'Ферменты'],
            ['name' => 'Витамины'],
            ['name' => 'Пробиотики'],
            ['name' => 'Карофиллы'],
            ['name' => 'Биотроник'],
            ['name' => 'Микофикс'],
            ['name' => 'Бетаин'],
            ['name' => 'Пропиленгликоль'],
            ['name' => 'Мешки'],
            ['name' => 'Этикетки'],
            ['name' => 'Инструкции'],
            ['name' => 'Гофроящики'],
            ['name' => 'Упаковочная пленка'],
        ];

        foreach ($rawTypes as $type) {
            RawType::create([
                'name' => $type['name'],
            ]);
        }
    }
}
