<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => User::ROLE_SUPERADMIN,
        ]);

        Role::create([
            'name' => User::ROLE_ADMIN,
        ]);
    }
}
