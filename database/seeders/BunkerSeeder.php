<?php

namespace Database\Seeders;

use App\Models\Bunker;
use Illuminate\Database\Seeder;

class BunkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bunkers = [
            ['name' => '#1'],
            ['name' => '#2'],
            ['name' => '#3'],
            ['name' => '#4'],
            ['name' => '#5'],
        ];

        foreach ($bunkers as $bunker) {
            Bunker::create([
                'name' => $bunker['name'],
            ]);
        }
    }
}
