<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FilterHelper
{
    public static function filtered(Builder $query, Request $request): Builder
    {
        $queryParams = $request->all();
        foreach ($queryParams as $key => $value) {
            if ($key !== 'pageSize' and $key !== 'filter') {
                if (is_array ($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where("$key", 'LIKE', "$value");
                }
            }
        }

        return $query;
    }
}
