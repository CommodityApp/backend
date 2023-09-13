<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //Empty the countries table
        DB::table('countries')->delete();

        foreach ($this->getCountries() as $countryId => $country) {
            DB::table('countries')->insert([
                'id' => $countryId,
                'country_code' => $country['country-code'],
                'iso_3166_2' => $country['iso_3166_2'],
                'iso_3166_3' => $country['iso_3166_3'],
                'name' => $country['name'],
            ]);
        }
    }

    /**
     * Get the countries from the JSON file, if it hasn't already been loaded.
     *
     * @return array
     */
    protected function getCountries()
    {
        return json_decode(file_get_contents(database_path('countries.json')), true);
    }
}
