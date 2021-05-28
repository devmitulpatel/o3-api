<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Device;
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
        $this->call(CurrencySeeder::class);
        $this->call(ProductSeeder::class);
        
        Device::query()->where('id','>',0)->update(['token'=>'1|OPOkiwGZlLu3ngJDqukFvfLckSZSud7YdTTbxKLo']);

    }
}
