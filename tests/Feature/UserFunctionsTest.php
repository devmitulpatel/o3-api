<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserFunctionsTest extends TestCase
{

    use WithoutEvents;
    use WithFaker;
    use WithoutMiddleware;
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register_new_user_with_no_data()
    {
        $response[] = $this->postJson('/api/v1/auth/register/1');
        $response[] = $this->postJson('/api/v1/auth/register/2');
        $response[] = $this->postJson('/api/v1/auth/register/3');
        foreach ($response as $res) {
            $res->assertStatus(422)->assertJson(
                ['message' => 'The given data was invalid.']
            );
        }
    }

    public function test_register_new_user_with_super_admin_role()
    {
        $this->seedFirst();
        $response = $this->postJson('/api/v1/auth/register/1', $this->getTestUser(1));
        $response->assertStatus(200)->assertSeeText('success');
    }

    public function test_register_new_user_with_owner_role()
    {
        $response = $this->postJson('/api/v1/auth/register/2', $this->getTestUser(2));
        $response->assertStatus(200)->assertSeeText('success');
    }

    public function test_register_new_user_with_user_role_with_ref_code()
    {
        $response = $this->postJson('/api/v1/auth/register/3', $this->getTestUser(3));
        $response->assertStatus(200)->assertSeeText('success');
    }

    public function test_register_new_user_with_user_role_wihtout_ref_code()
    {
        $response = $this->postJson('/api/v1/auth/register/3', $this->getTestUser(3, ['ref_code']));
        $response->assertStatus(422);
    }

    public function test_login_with_valid_credential()
    {
        $user = $this->getValidUser();
        $response = $this->postJson('/api/v1/auth/login', $user);
        $response->assertStatus(200)->assertJson(['data' => ['email' => $user['email']]]);
    }

    public function test_login_with_invalid_credential()
    {
        $credential = $this->getValidUser();
        $credential['password'] = 'demo';
        $response = $this->postJson('/api/v1/auth/login', $credential);
        $response->assertStatus(422)->assertJson(
            ['message' => 'The given data was invalid.']
        );
    }

    public function test_login_with_no_credential()
    {
        $response = $this->postJson('/api/v1/auth/login', []);
        $response->assertStatus(422)->assertJson(
            ['message' => 'The given data was invalid.']
        );
    }

    public function test_update_user()
    {
    }

    public function test_delete_user()
    {
    }
}
