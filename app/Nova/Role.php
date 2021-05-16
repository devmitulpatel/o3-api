<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class Role extends Resource
{
    public static $model = \App\Models\Role::class;

    public static $globallySearchable = false;

    public static $group = 'Super Admin';

    public static $title = 'name';

    public static $search = [
        'name',
    ];

    public static function label()
    {
        return __('Roles');
    }

    public static function singularLabel()
    {
        return __('Role');
    }

    public static function availableForNavigation(Request $request)
    {
        return $request->user()->hasRole([ROLE_SUPER_ADMIN]);
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Name'))
                ->sortable()
                ->rules('required', 'max:255', 'alpha_dash')
                ->creationRules('unique:roles,name')
                ->updateRules('unique:roles,name,{{resourceId}}'),

            BelongsToMany::make(__('Permissions'), 'permissions', Permission::class),
        ];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [];
    }
}
