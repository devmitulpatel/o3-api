<?php

namespace App\Base;

use App\Traits\Makeable;

class DatabaseNotification
{
    use Makeable;

    protected $collection;

    public function __construct($title)
    {
        $this->collection = collect(compact('title'));
    }

    public function description($description)
    {
        $this->collection->put('description', $description);

        return $this;
    }

    public function route($name, $parameters = [])
    {
        $this->collection->put('route_name', $name);
        $this->collection->put('route_parameters', $parameters);

        return $this;
    }

    public function toArray()
    {
        return $this->collection->toArray();
    }
}
