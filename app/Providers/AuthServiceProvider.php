<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Currency;
use App\Models\Product;
use App\Policies\CompanyPolicy;
use App\Policies\CurrencyPolicy;
use App\Policies\ProductPolicy;
use App\Policies\UnitPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         Company::class=>CompanyPolicy::class,
         Unit::class=>UnitPolicy::class,
         Currency::class=>CurrencyPolicy::class,
         Product::class=>ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
