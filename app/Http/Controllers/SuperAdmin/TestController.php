<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function __invoke()
    {
        return view('welcome');
    }

}
