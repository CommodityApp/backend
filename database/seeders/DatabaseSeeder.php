<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CountrySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(ProducerSeeder::class);
        $this->call(RawTypeSeeder::class);
        $this->call(BunkerSeeder::class);
        $this->call(AnimalSeeder::class);
        $this->call(RawSeeder::class);
        $this->call(ReceiptSeeder::class);
    }
}
