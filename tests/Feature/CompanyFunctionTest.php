<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use App\Traits\CompanyTestHelper;
use App\Traits\TestHelper;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CompanyFunctionTest extends TestCase
{
//    use TestHelper;
    use WithoutEvents;
    use WithFaker;
 //   use WithoutMiddleware;
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_company_list()
    {
        $this->signIn($this->getUser());
        $response = $this->get('/api/v1/company');
        $response->assertStatus(200);
    }

    public function test_create_new_company(){
        $this->signIn($this->getUser());
        $response=$this->postJson($this->getUrl('company'),$this->getCompany());
        $response->assertStatus(201);
    }

    public function test_check_required_data_to_create_company(){
        $this->signIn($this->getUser());
        $response=$this->postJson($this->getUrl('company'),$this->getCompany([],['name']));
        $response->assertStatus(422);
    }

    public function test_can_not_create_company_with_existing_data(){
        $this->signIn($this->getUser());
        $company=Company::first();
        $response=$this->postJson($this->getUrl('company'),$this->getCompany($company->toArray()));
        $response->assertStatus(422);
    }


    public function test_update_company(){}
    public function test_delete_company(){}

}
