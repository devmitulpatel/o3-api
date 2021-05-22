<?php

namespace Tests;

use App\Models\User;
use App\Traits\TestHelper;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use TestHelper;
}
