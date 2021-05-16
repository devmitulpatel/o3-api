<?php

namespace App\Nova;

use App\Nova\Actions\ActivateUser;
use App\Nova\Actions\DeactivateUser;
use App\Nova\Actions\SendEmail;
use App\Nova\Filters\Active;
use App\Nova\Filters\CreatedFrom;
use App\Nova\Filters\CreatedTill;
use App\Nova\Filters\UserRole;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource
{
    public static $model = \App\Models\User::class;

    public static $group = 'Admin';

    public static $title = 'name';

    public static $search = [
        'id', 'name', 'email',
    ];

    public static function label()
    {
        return __('Users');
    }

    public static function singularLabel()
    {
        return __('User');
    }

    public static function availableForNavigation(Request $request)
    {
        return $request->user()->hasRole([ROLE_SUPER_ADMIN, ROLE_ADMIN]);
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->role([ROLE_USER]);
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Avatar::make(__('Avatar'), 'avatar')
                ->disk(config('filesystems.default'))
                ->path('avatars')
                ->maxWidth(25)
                ->rounded()
                ->disableDownload(),

            Text::make(__('Name'), 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make(__('Email'), 'email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Boolean::make(__('Active'), 'active'),

            Password::make(__('Password'), 'password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            DateTime::make(__('Created'), 'created_at')
                ->exceptOnForms(),

            HasMany::make(__('Social Accounts'), 'social_accounts')->canSee(function ($request) {
                return config('application.social_auth.enabled');
            }),

            MorphToMany::make(__('Roles'), 'roles', Role::class),
        ];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [
            new Active,
            new UserRole,
            new CreatedFrom,
            new CreatedTill,
        ];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [
            new ActivateUser,
            new DeactivateUser,
            new SendEmail,
        ];
    }
}
