<?php

namespace Tests\Feature;

use App\Models\Unit;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UnitFunctionTest extends TestCase
{
    use WithoutEvents;
    use WithFaker;
//    use WithoutMiddleware;
    use DatabaseMigrations;
//    use DatabaseTransactions;

    public function test_index_unit(){

        $this->signIn();
        $response = $this->get($this->getUrl('unit'));
        $response->assertStatus(200);
    }

    public function test_create_unit(){
        $this->signIn();
        $unit= ['name'=>$this->faker->name,'symbol'=> '1w23'];
        $response = $this->postJson($this->getUrl('unit'),$unit);
        $response->assertStatus(201)->assertJson(['data' => ['name' =>$unit['name']]]);
    }

    public function test_update_unit(){
        $this->seedFirst();
        $this->signIn();
        $unit= Unit::oldest()->first()->id;

        $update_unit=['name'=>$this->faker->name,'symbol'=>'ew'];
        $response = $this->patchJson($this->getUrl('unit/'.$unit),$update_unit);
        $response->assertStatus(200);
        //->assertJson(['data' => ['name' =>$update_unit['name'],'symbol'=>$update_unit['symbol']]]);
    }

    public function test_delete_unit(){
        $this->seedFirst();
        $this->signIn();

        $unit= Unit::oldest()->first()->id;
        $update_unit=['name'=>$this->faker->name,'symbol'=>'ew'];
        $response = $this->delete($this->getUrl('unit/'.$unit));
        $response->assertStatus(200);
    }
}
