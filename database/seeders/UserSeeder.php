<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Activitylog\Facades\CauserResolver;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => config('credentials.admin.email'),
            'password' => bcrypt(config('credentials.admin.password')),
        ]);

        $user->assignRole(User::ROLE_SUPERADMIN, User::ROLE_ADMIN);

        CauserResolver::setCauser(User::first());

        User::factory()->count(10)->create();

    }
}
