<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class SocialAccount extends Resource
{
    public static $model = \App\Models\SocialAccount::class;

    public static $displayInNavigation = false;

    public static $globallySearchable = false;

    public static $title = 'provider_name';

    public static $search = [

    ];

    public static function label()
    {
        return __('Social Accounts');
    }

    public static function singularLabel()
    {
        return __('Social Account');
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public function fields(Request $request)
    {
        return [
            Text::make(__('Provider Name'), 'provider_name')
                ->sortable(),

            Text::make(__('Provider Id'). 'provider_id'),

            DateTime::make(__('Created'), 'created_at')
                ->exceptOnForms(),

            DateTime::make(__('Updated'), 'updated_at')
                ->exceptOnForms(),
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
