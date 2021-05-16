<?php

namespace Tests\Feature;

use Hash;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_login_with_email_and_password()
    {
        $body = [
            'email'    => 'test@example.com',
            'password' => 'password',
        ];

        User::factory()->create([
            'email'    => $body['email'],
            'password' => Hash::make($body['password']),
        ]);

        $response = $this->postJson($this->url('auth/login'), $body);

        $response->assertStatus(200)
            ->assertJson([
                'data' => array_only($body, 'email'),
            ]);
    }

    /** @test */
    public function user_can_not_login_with_invalid_email()
    {
        $body = [
            'email'    => 'invalid email',
            'password' => 'password',
        ];

        $this->postJson($this->url('auth/login'), $body)
            ->assertStatus(422);
    }

    /** @test */
    public function user_can_not_login_if_account_does_not_exists()
    {
        $body = [
            'email'    => 'nonfound@example.com',
            'password' => 'password',
        ];

        $this->postJson($this->url('auth/login'), $body)
            ->assertStatus(422);
    }
}
