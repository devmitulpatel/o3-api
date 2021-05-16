<?php

namespace Tests\Feature;

use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_save_device()
    {
        $this->signIn();

        $body = Device::factory()->make()->toArray();

        $response = $this->postJson($this->url('devices'), $body);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'token' => $body['token'],
                ],
            ]);
    }
}
