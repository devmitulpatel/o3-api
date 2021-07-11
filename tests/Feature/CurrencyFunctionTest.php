<?php

namespace Tests\Feature;

use App\Models\Currency;
use App\Models\Unit;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CurrencyFunctionTest extends TestCase
{
    use WithoutEvents;
    use WithFaker;
  //  use WithoutMiddleware;
    use DatabaseMigrations;
   // use DatabaseTransactions;


    public function test_index_currency(){

        $this->signIn();
        $response = $this->get($this->getUrl('currency'));
        $response->assertStatus(200);
    }

    public function test_create_currency(){
        $this->signIn();
        $currency= ['name'=>$this->faker->name,'symbol'=>"1",'base_rate'=>1];
        $response = $this->postJson($this->getUrl('currency'),$currency);
        $response->assertStatus(201)->assertJson(['data' => ['name' =>$currency['name']]]);
    }

    public function test_update_currency(){
        $this->seedFirst();
        $this->signIn();
        $currency= Currency::oldest()->first()->id;
        $update_currency=['name'=>$this->faker->name,'symbol'=>'ew','base_rate'=>0.0012];
        $response = $this->patchJson($this->getUrl('currency/'.$currency),$update_currency);
        $response->assertStatus(200)->assertJson(['data' => ['name' =>$update_currency['name'],'symbol'=>'ew']]);
    }

    public function test_delete_currency(){
        $this->seedFirst();
        $this->signIn();
        $currency= Currency::oldest()->first()->id;
        $response = $this->delete($this->getUrl('currency/'.$currency));
        $response->assertStatus(200);
    }
}
