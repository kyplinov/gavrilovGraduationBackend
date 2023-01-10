<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class EmployeesHelpers
{
    public static function filtered(Builder $query, Request $request): Collection
    {
        FilterHelper::filtered($query, $request);

        if (isset($request->filter)) {
            $query->Where('first_name', 'LIKE', $request->filter)
                ->orWhere('second_name', 'LIKE', $request->filter)
                ->orWhere('patronymic', 'LIKE', $request->filter)
                ->orWhere('work_phone_number', 'LIKE', $request->filter)
                ->orWhere('mobile_phone_number', 'LIKE', $request->filter)
                ->orWhere('email', 'LIKE', $request->filter)
                ->orWhere('position', 'LIKE', $request->filter)
                ->get();
        }

        return $query->get();
    }
}
