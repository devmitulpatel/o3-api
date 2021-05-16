<?php

namespace Database\Seeders;

use App\Models\Company;

use App\Models\User;
use App\Traits\SeederHelper;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public const TYPE_LLP=3;
    use SeederHelper;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data=[
            ['name'=>'Million Solutions LLP','company_type_id'=>self::TYPE_LLP],
            ['name'=>'Vajir Foods LLP','company_type_id'=>self::TYPE_LLP]
        ];
        $this->ForEach(Company::class,$data,function ($model){
            User::findOrFail(1)->company()->save($model);
            return$model;
        });

    }


}
