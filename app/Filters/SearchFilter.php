<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class SearchFilter implements Filter
{
    public function __construct(public array $fields)
    {

    }

    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function (Builder $query) use ($value) {
            foreach ($this->fields as $field) {
                $query = $query->orWhere($field, 'like', "%{$value}%");
            }
        });
    }
}
