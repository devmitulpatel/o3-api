<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Http\Resources\CurrencyResource;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function index(){
        return CurrencyResource::collection(Currency::all());
    }
    public function store(StoreCurrencyRequest $request) {

        return CurrencyResource::make($request->presist());
    }
    public function update(UpdateCurrencyRequest $request,Currency $currency){
        return CurrencyResource::make($request->presist($currency));
    }
    public function show(Currency $currency){
        return CurrencyResource::make($currency);
    }
    public function destroy(Currency $currency){
        $currency->delete();
    }

}

