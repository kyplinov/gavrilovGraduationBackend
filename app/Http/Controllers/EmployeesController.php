<?php

namespace App\Http\Controllers;

use App\Helpers\CollectionHelper;
use App\Helpers\EmployeesHelpers;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function registry(Request $request)
    {
        return response()->json(
            CollectionHelper::paginate(
                EmployeesHelpers::filtered(Employee::query(), $request),
                isset($queryParams['pageSize']) ? (int)$queryParams['pageSize'] : 10)
        );
    }

    public function get(Employee $employee)
    {
        return response()->json($employee);
    }

    public function search(Request $request)
    {
        $collection = Employee::all();
        return $collection->where('second_name', 'LIKE' ,"$request->search");
    }

    public function create(Request $request)
    {
        $employee = new Employee([
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

        if ($employee->save()) {

            if (count($request->configurationUnits) > 0) {
                foreach ($request->configurationUnits as $configurationUnit) {
                    $configurationUnitIds [] = $configurationUnit['id'];
                }
                $employee->configurationUnits()->sync($configurationUnitIds);
            }

            return response()->json([
                'message' => 'Сотрудник сохранен',
                'id' => $employee->id,
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

            if (count($request->configurationUnits) > 0) {
                foreach ($request->configurationUnits as $configurationUnit) {
                    $configurationUnitIds [] = $configurationUnit['id'];
                }
                $employee->configurationUnits()->sync($configurationUnitIds);
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
