<?php

namespace App\Models;

use Laravel\Nova\Actions\Actionable;

class Role extends \Spatie\Permission\Models\Role
{
    use Actionable;



    public static function options()
    {
        return self::pluck('name')->mapWithKeys(function ($role) {
            return [$role => $role];
        })->toArray();
    }
}
