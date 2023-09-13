<?php

namespace Database\Seeders;

use App\Models\AnimalLevel;
use App\Models\AnimalType;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $root = AnimalLevel::create([
            'name' => 'Вид',
            'depth' => 0,
        ]);

        $type = AnimalLevel::create([
            'name' => 'Тип',
            'depth' => 1,
        ]);

        $types = [
            'КРС' => [
                'Быки',
            ],
            'Птицы' => [
                'Бройлеры',
                'Несушки',
                'Родители',
            ],
        ];

        foreach ($types as $name => $data) {
            $parent = AnimalType::create([
                'name' => $name,
                'animal_level_id' => $root->id,
            ]);

            foreach ($data as $name) {
                AnimalType::create([
                    'name' => $name,
                    'parent_id' => $parent->id,
                    'animal_level_id' => $type->id,
                ]);
            }

        }
    }

    public function createWithRecursive(string $name, int $parent_id, array $children)
    {

    }
}
