@component('mail::message')

@lang('Hello'), {{ $user->name }},

{!! $body !!}

@lang('Thanks'),<br>
{{ config('app.name') }}
@endcomponent
