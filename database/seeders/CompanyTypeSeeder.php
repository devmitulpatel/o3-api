<?php

namespace Database\Seeders;

use App\Models\CompanyType;
use App\Models\User;
use App\Traits\SeederHelper;
use Illuminate\Database\Seeder;

class CompanyTypeSeeder extends Seeder
{
    use SeederHelper;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data=[
            ['name'=>'Pvt Ltd'],
            ['name'=>'Public Ltd'],
            ['name'=>'LLP'],
            ['name'=>'Partnership firm'],
            ['name'=>'Trust'],
            ['name'=>'Solo Proprietor'],
        ];
        $this->ForEach(CompanyType::class,$data,static function ($model){
            return $model;
        });

    }
}
