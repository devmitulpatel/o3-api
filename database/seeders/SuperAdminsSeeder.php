<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'first_name'  => 'User',
            'last_name'  => 'Super Admin',
            'email' => 'sadmin@test.com',
        ])->assignRole(ROLE_SUPER_ADMIN);


        User::factory()->create([
                                    'first_name'  => 'User',
                                    'last_name'  => 'Admin',
                                    'email' => 'admin@test.com',
                                ])->assignRole(ROLE_ADMIN);

    }
}
