<?php

namespace App\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ApplicationHelper
{
    public static function filtered(Builder $query, Request $request): Collection
    {
        FilterHelper::filtered($query, $request);

        if (isset($request->filter)) {
            $query->Where('description', 'LIKE', $request->filter)
                ->orWhere('decide', 'LIKE', $request->filter)
                ->get();
        }

        return $query->get();
    }
}
