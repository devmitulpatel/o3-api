<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserFunctionsTest extends TestCase
{
    use RefreshDatabase;
    public const ROLE_SUPER_ADMIN=1;
    public const ROLE_ADMIN=2;
    public const ROLE_USER=3;
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function create_super_admin(){
        $body = [
            'email'=>'new2@test.comqq2',
            'first_name'=>'Mitul',
            'last_name'=>'patel',
            'company_name'=>'Million Solutions LLP',
            'gender'=>'male',
        ];
        $route=implode('/',['api','v1','auth','register',self::ROLE_SUPER_ADMIN]);

        $response = $this->postJson($this->url($route), $body);

      //  $response->assertStatus(200)->assertSee('success');
    }
}
