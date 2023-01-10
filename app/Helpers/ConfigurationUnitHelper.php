<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ConfigurationUnitHelper
{
    public static function filtered(Builder $query, Request $request): Collection
    {
        $query = FilterHelper::filtered($query, $request);

        if (isset($request->filter)) {
            $query->Where('number', 'LIKE', "%$request->filter%")
                ->orWhere('serial_number', 'LIKE', "%$request->filter%")
                ->orWhere('name', 'LIKE', "%$request->filter%")
                ->orWhere('extra', 'LIKE', "%$request->filter%")
                ->get();
        }

        return $query->get();
    }
}
