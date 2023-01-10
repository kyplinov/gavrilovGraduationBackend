<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ConfigurationUnitHelper
{
    public static function filtered(Builder $query, Request $request): Collection
    {
        if (isset($request->configuration_unit_type_id)) {
            $query->whereIn('configuration_unit_type_id', $request->configuration_unit_type_id);
        }

        if (isset($request->area_id)) {
            $query->whereIn('area_id', $request->area_id);
        }

        if (isset($request->status_id)) {
            $query->whereIn('status_id', $request->status_id);
        }

        if (isset($request->filter)) {
            $query->Where('number', 'LIKE', $request->filter)
                ->orWhere('serial_number', 'LIKE', $request->filter)
                ->orWhere('name', 'LIKE', $request->filter)
                ->orWhere('extra', 'LIKE', $request->filter)
                ->get();
        }

        return $query->get();
    }
}