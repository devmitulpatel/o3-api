<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_request_his_information()
    {
        $this->signIn();

        $response = $this->getJson($this->url('user'));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => auth()->id(),
                ],
            ]);
    }
}
