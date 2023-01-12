<?php

namespace App\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ApplicationHelper
{
    public static function filtered(Builder $query, Request $request): Collection
    {
        $query = static::filteredByDepartment($query);
        $query = FilterHelper::filtered($query, $request);

        if (isset($request->filter)) {
            $query->Where('description', 'LIKE', "%$request->filter%")
                ->orWhere('decide', 'LIKE', "%$request->filter%")
                ->get();
        }

        return $query->get();
    }

    private static function filteredByDepartment(Builder $query): Builder
    {
        $employeeIds = [];
        $employees = DB::table('employees')
            ->select('employees.id')
            ->leftJoin('areas', 'areas.id', '=', 'employees.area_id')
            ->leftJoin('departments', 'departments.id', '=', 'areas.department_id')
            ->whereIn('departments.id',
                DB::table('users')
                ->select('departments.id')
                ->leftJoin('employees', 'users.id', '=', 'employees.user_id')
                ->leftJoin('areas', 'areas.id', '=', 'employees.area_id')
                ->leftJoin('departments', 'departments.id', '=', 'areas.department_id')
                ->where('users.id', '=', auth()->user()->getAuthIdentifier())
            )
            ->where('employees.type', '=', 'sup')
            ->get()->toArray();

        foreach ($employees as $employee) {
            array_push($employeeIds, $employee->id);
        }

        if ($employeeIds) {
            $query->whereIn('id', $employeeIds);
        }

        return $query;
    }
}
