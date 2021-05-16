<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class LoginAsController extends Controller
{
    public function __construct()
    {
        $this->middleware('env:local');
    }

    public function index($userId)
    {
        auth()->loginUsingId($userId);

        return back();
    }
}
