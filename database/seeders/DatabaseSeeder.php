<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Activitylog\Facades\CauserResolver;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // activity()->withoutLogs(function () {
        $this->call(CountrySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);

        CauserResolver::setCauser(User::orderByDesc('id')->first());
        $this->call(ClientSeeder::class);
        $this->call(ProducerSeeder::class);
        $this->call(RawTypeSeeder::class);
        $this->call(BunkerSeeder::class);
        $this->call(AnimalSeeder::class);
        $this->call(RawSeeder::class);
        $this->call(PriceSeeder::class);
        $this->call(ReceiptSeeder::class);
        $this->call(RationSeeder::class);
        $this->call(OrderSeeder::class);
        // });
    }
}
