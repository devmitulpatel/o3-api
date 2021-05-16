<?php

namespace App\Http\Middleware;

use Closure;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($user = $request->user()) {
            $this->setLocale($user->locale);
        } else if ($locale = session('locale')) {
            $this->setLocale($locale);
        } else if ($locale = $request->header('X-localization')) {
            $this->setLocale($locale);
        }

        return $next($request);
    }

    protected function setLocale($locale)
    {
        app()->setLocale($locale);
    }
}
