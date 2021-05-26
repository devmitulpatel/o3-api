<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Currency::factory()->create(['name'=>'Rupee','symbol'=>'₹']);
        Currency::factory()->create(['name'=>'US Dollar','symbol'=>'$','base_rate'=>0.014]);
    }
}
