<?php

namespace Database\Seeders;

use App\Models\Producer;
use Illuminate\Database\Seeder;

class ProducerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $producers = [
            ['name' => 'DSM'],
            ['name' => 'Biomin'],
            ['name' => 'Sumitomo'],
        ];

        foreach ($producers as $producer) {
            Producer::create([
                'name' => $producer['name'],
            ]);
        }
    }
}
