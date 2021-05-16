<?php

namespace App\Models;

use Laravel\Nova\Actions\Actionable;

class Permission extends \Spatie\Permission\Models\Permission
{
    use Actionable;
}
