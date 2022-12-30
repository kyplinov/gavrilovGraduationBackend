<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function registry()
    {
        return response()->json(Employee::all());
    }

    public function get(Employee $employee)
    {
        return response()->json($employee);
    }

    public function create(Request $request)
    {
        $employees = new Employee([
            'user_id' => $request->user ? $request->user['id'] : null,
            'first_name' => $request->first_name,
            'second_name' => $request->second_name,
            'patronymic' => $request->patronymic,
            'birthday' => $request->birthday,
            'work_phone_number' => $request->work_phone_number,
            'mobile_phone_number' => $request->mobile_phone_number,
            'email' => $request->email,
            'photo_id' => $request->photo ? $request->photo['id'] : null,
            'area_id' => $request->area ? $request->area['id'] : null,
        ]);

        if ($employees->save()) {
            return response()->json([
                'message' => 'Сотрудник сохранен',
                'id' => $employees->id,
            ], 201);
        } else {
            return response()->json([
                'error' => 'Сотрудник не сохранен',
            ], 422);
        }
    }
}
