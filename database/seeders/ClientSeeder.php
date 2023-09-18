<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Country;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = Country::whereCountryCode(860)->first();

        Client::factory()->count(10)->for($country)->create();
    }
}
