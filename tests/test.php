<?php

const COMPANY_TYPE = 1;

$data=[
    //region Description
    'type'=>\App\Models\User::class,
    //endregion
    'balance'=>0,
    'owner_id'=>1
];


$transaction=[
    'ledger_id'=>1,
    'payer_id'=>1,
    'payer_type'=>\App\Models\User::class,
    'payee_id'=>2,
    'payee_type'=>\App\Models\User::class,
    'amount'=>10
];

$product=[
    'name'=>'test',
    'description'=>"test",
    'company_id'=>1
];
//resolve(\App\Base\Ledger::class,['ledger'=>$data])->loadTransaction()->getTotalDebit();

//resolve(\App\Base\UserCompanies::getCompanies(\App\Models\User::find(1)));


//$product=resolve(\App\Base\Product::class,['data'=>$product])->getData()->load(['measurements','measurements.rates']);

$product=\App\Models\Product::first()->load('company');
    //->load(['measurements','measurements.rates','measurements.unit','measurements.rates.currency']);


dd($product->toArray());


