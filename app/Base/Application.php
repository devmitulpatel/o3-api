<?php

namespace App\Base;

use Route;

class Application
{
    /**
     * Get social login routes if enabled from config.
     */
    public static function socialAuthRoutes()
    {
        if (config('application.social_auth.enabled')) {
            $providers = config('application.social_auth.providers');

            Route::get('login/{provider}', 'Auth\SocialLoginController@redirect')
                ->middleware('guest')
                ->where('provider', $providers)
                ->name('login.social');

            Route::get('login/{provider}/callback', 'Auth\SocialLoginController@callback')
                ->middleware('guest')
                ->where('provider', $providers);
        }
    }
}
