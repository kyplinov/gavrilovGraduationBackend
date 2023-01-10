<?php

namespace App\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ApplicationHelper
{
    public static function filtered(Builder $query, Request $request): Collection
    {
        if (isset($request->status_id)) {
            $query->whereIn('status_id', $request->status_id);
        }

        if (isset($request->employee_id)) {
            $query->whereIn('employee_id', $request->employee_id);
        }

        if (isset($request->support_id)) {
            $query->whereIn('support_id', $request->support_id);
        }

        if (isset($request->filter)) {
            $query->Where('description', 'LIKE', $request->filter)
                ->orWhere('decide', 'LIKE', $request->filter)
                ->get();
        }

        return $query->get();
    }
}
