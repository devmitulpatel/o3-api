<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function signIn($user = null)
    {
        $user = $user ?: User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        return $this;
    }

    protected function url($path)
    {
        return sprintf('/%s', $path);
    }
}
