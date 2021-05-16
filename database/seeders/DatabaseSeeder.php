<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolePermissionsSeeder::class);
        $this->call(SuperAdminsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(CompanyTypeSeeder::class);
        $this->call(CompanySeeder::class);

    }
}
