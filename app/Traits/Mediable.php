<?php

namespace App\Traits;

use App\Models\Media;

trait Mediable
{
    public static function bootMediable()
    {
        static::deleting(function ($model) {
            $model->removeMedia();
        });
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function attachMedia(array $ids = [])
    {
        return Media::whereIn('id', $ids)->update([
            'mediable_type' => get_class($this),
            'mediable_id'   => $this->id,
        ]);
    }

    public function removeMedia()
    {
        $this->media->each->delete();
    }
}
