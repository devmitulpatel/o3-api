<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Permission extends Resource
{
    public static $model = \App\Models\Permission::class;

    public static $globallySearchable = false;

    public static $group = 'Super Admin';

    public static $displayInNavigation = false;

    public static $title = 'name';

    public static $search = [
        'name',
    ];

    public static function label()
    {
        return __('Permissions');
    }

    public static function singularLabel()
    {
        return __('Permission');
    }

    public static function availableForNavigation(Request $request)
    {
        return $request->user()->hasRole([ROLE_SUPER_ADMIN]);
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Name'), 'name')
                ->sortable()
                ->rules('required', 'max:255', 'alpha_dash')
                ->creationRules('unique:permissions,name')
                ->updateRules('unique:permissions,name,{{resourceId}}'),

            BelongsToMany::make(__('Roles'), 'roles', Role::class),
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
