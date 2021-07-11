<?php

namespace Database\Seeders;

use App\Models\Measurement;
use App\Models\Product;
use App\Models\Rate;
use App\Models\Unit;
use App\Traits\SeederHelper;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use SeederHelper;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unitData=[
            ['name'=>'Kilo Gram','symbol'=>'KG'],
            ['name'=>'Gram','symbol'=>'G'],
        ];
       $this->ForEach(Unit::class,$unitData);

       $productData=[
           [
               'name'=>'Test Product',
               'description'=>'Test Product description',
               'company_id'=>1
               ]
       ];
        $load=['measurements'];

       $this->ForEach(Product::class,$productData,function (Product $model){
           $model->addMeasurement(100,1);
           $model->measurements->first()->addRate(100);
           return $model;

       });

    }
}
