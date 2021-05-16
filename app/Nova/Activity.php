<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\MorphToActionTarget;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Activity extends Resource
{
    public static $model = \App\Models\Activity::class;

    public static $globallySearchable = false;

    public static $group = 'Super Admin';

    public static $title = 'description';

    public static $search = [
        'description',
    ];

    public static $with = [
        'causer', 'subject',
    ];

    public static function label()
    {
        return __('Activities');
    }

    public static function singularLabel()
    {
        return __('Activity');
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
            Text::make(__('Causer Name'), 'causer_name'),

            Text::make(__('Description'), 'description'),

            MorphToActionTarget::make(__('Subject'), 'subject'),

            DateTime::make(__('Happened At'), 'created_at')->exceptOnForms(),

            new Panel(__('Properties'), [
                KeyValue::make(__('Properties'), 'properties'),
            ]),
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
