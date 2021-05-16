<?php

namespace App\Filters;

use Rjchauhan\LaravelFiner\Filter\Filter;

class UserFilters extends Filter
{
    protected $filters = ['search'];

    public function search($keyword)
    {
        $this->builder->search($keyword);
    }
}
