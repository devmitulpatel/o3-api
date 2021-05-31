<?php

namespace Tests\Feature;

use App\Models\Measurement;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ProductNServiceFunctionTest extends TestCase
{
 //   use WithoutEvents;
    use WithFaker;
 //   use WithoutMiddleware;
    use DatabaseMigrations;
//    use DatabaseTransactions;


    public function test_index_product(){

        $this->signIn();
        $response = $this->get($this->getUrl('product'));
        $response->assertStatus(200);
    }

    public function test_create_product(){
        $this->seedFirst();
        $this->signIn();
        $measurement=Unit::all();
        $measurementData=[];
        foreach ($measurement as $m){
            $measurementData[]=[
                'key'=>$m->id,
                'value'=>random_int(10,100),
            ];
        }
        $rate=[];
        $rateMeaseurment=array_random($measurementData);

        $rate=[
            'key'=>$rateMeaseurment['key'],
            'rate'=>120
        ];


        $product= ['name'=>$this->faker->name,'description'=> '1w23','rates'=>$rate,'measurements'=>$measurementData,'color'=>'red'];
        $response = $this->postJson($this->getUrl('product'),$product);
        $response->assertStatus(201)->assertJson(['data' => ['name' =>$product['name']]]);
    }

    public function test_update_product(){
        $this->seedFirst();
        $this->signIn();

        $measurement=Unit::all();
        $measurementData=[];
        foreach ($measurement as $m){
            $measurementData[]=[
                'key'=>$m->id,
                'value'=>random_int(10,100),
            ];
        }
        $rate=[];
        $rateMeaseurment=array_random($measurementData);

        $rate=[
            'key'=>$rateMeaseurment['key'],
            'rate'=>200
        ];

        $product= Product::oldest()->first()->id;
        $update_product=['name'=>$this->faker->name,'description'=>'ew','rates'=>$rate,'measurements'=>$measurementData,'color'=>'red'];

        $response = $this->patchJson($this->getUrl('product/'.$product),$update_product);
        $response->assertStatus(200);

    }

    public function test_delete_product(){
        $this->seedFirst();
        $this->signIn();
        $product= Product::oldest()->first()->id;
        $response = $this->delete($this->getUrl('product/'.$product));
        $response->assertStatus(200);
    }


}
