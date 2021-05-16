<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => ROLE_SUPER_ADMIN]);
        Role::create(['name' => ROLE_ADMIN]);
        Role::create(['name' => ROLE_USER]);
    }
}
