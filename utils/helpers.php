<?php

use App\Models\User;

function kbFromBytes($bytes)
{
    return round($bytes / 1024);
}

function company(){
    return (!auth()->check())? (auth()->loginUsingId(1))?auth()->user()->currentCompany:\App\Models\Company::first() :auth()->user()->currentCompany;
}

function user(){
    return (!auth()->check())? User::latest()->first() :auth()->user();
}