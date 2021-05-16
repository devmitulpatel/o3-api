<?php

namespace App\Traits;

trait Searchable
{
    use \Laravel\Scout\Searchable;

    public function toSearchableArray()
    {
        $attributes = property_exists(self::class, 'searchable')
            ? self::$searchable
            : [];

        array_unshift($attributes, 'id');

        return $this->only($attributes);
    }

    public function scopeSearch($query, $keyword)
    {
        $ids = array_get(
            self::search($keyword)->raw(),
            'ids'
        );

        if (count($ids)) {
            return $query->whereIn('id', $ids)
                ->orderByRaw('FIELD(id,' . implode(',', $ids) . ')');
        }

        return $query->whereIn('id', $ids);
    }
}
