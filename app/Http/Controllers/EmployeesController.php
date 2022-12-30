<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
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
        var_dump($request->area['id']);
        $employees = new Employee([
            'user_id' => $request->user ? $request->user['id'] : null,
            'first_name' => $request->first_name,
            'second_name' => $request->second_name,
            'patronymic' => $request->patronymic,
            'birthday' => $request->birthday,
            'work_phone_number' => $request->work_phone_number,
            'mobile_phone_number' => $request->mobile_phone_number,
            'email' => $request->email,
            'position' => $request->position,
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

    public function update(Request $request, Employee $employee)
    {
        $employee->user_id = $request->user ? $request->user['id'] : null;
        $employee->first_name = $request->first_name;
        $employee->second_name = $request->second_name;
        $employee->patronymic = $request->patronymic;
        $employee->birthday = $request->birthday;
        $employee->work_phone_number = $request->work_phone_number;
        $employee->mobile_phone_number = $request->mobile_phone_number;
        $employee->email = $request->email;
        $employee->position = $request->position;
        $employee->photo_id = $request->photo ? $request->photo['id'] : null;
        $employee->area_id = $request->area ? $request->area['id'] : null;


        if ($employee->update()) {
            if (count($request->tags) > 0) {
                foreach ($request->tags as $tag) {
                    $tagsId [] = $tag['id'];
                }
                $employee->tags()->sync($tagsId);
            }
            return response()->json([
                'message' => 'Сотрудник сохранен',
            ]);
        } else {
            return response()->json([
                'error' => 'Предоставьте правильную информацию',
            ], 422);
        }
    }

    public function destroy(Employee $employee)
    {
        if ($employee->delete()) {
            return response()->json([
                'message' => 'Сотрудник успешно удалён!',
            ]);
        } else {
            return response()->json([
                'error' => 'Ошибка при удалении департамента',
            ], 422);
        }
    }
}
