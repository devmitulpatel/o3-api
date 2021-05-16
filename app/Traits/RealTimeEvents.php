<?php

namespace App\Traits;

use App\Events\RealTimeEvent;

trait RealTimeEvents
{
    public static function bootRealTimeEvents()
    {
        $events = property_exists(self::class, 'realtime_events')
            ? self::$realtime_events
            : [];

        foreach ($events as $event) {
            static::$event(function ($model) use ($event) {
                RealTimeEvent::dispatch(
                    strtolower(class_basename($model)) . '.' . $event,  // model.created
                    $model->toArray()
                );
            });
        }
    }
}
