<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

class Admin extends User
{
    public static $group = 'Super Admin';

    public static function availableForNavigation(Request $request)
    {
        return $request->user()->hasRole([ROLE_SUPER_ADMIN]);
    }

    public static function authorizedToCreate(Request $request)
    {
        return true;
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->role([ROLE_SUPER_ADMIN, ROLE_ADMIN]);
    }

    public static function label()
    {
        return __('Admin Users');
    }

    public static function singularLabel()
    {
        return __('Admin User');
    }
}
