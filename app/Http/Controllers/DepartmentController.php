<?php

namespace App\Http\Controllers;

use App\Helpers\CollectionHelper;
use App\Helpers\FilterHelper;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function registry(Request $request)
    {
        $queryParams = $request->all();
        $collection = FilterHelper::filtered(Department::query(), $request)->get();
        return response()->json(CollectionHelper::paginate($collection, isset($queryParams['pageSize']) ? (int)$queryParams['pageSize'] : 10));
    }

    public function get(Department $employee)
    {
        return response()->json($employee);
    }

    public function create(Request $request)
    {
        $departament = new Department([
            'name' => $request->name,
        ]);
        if ($departament->save()) {
            return response()->json([
                'message' => 'Департамент сохранен',
                'id' => $departament->id,
            ], 201);
        } else {
            return response()->json([
                'error' => 'Департамент не сохранен',
            ], 422);
        }
    }

    public function update(Request $request, Department $department)
    {
        $department->name = $request->name;

        if ($department->update()) {
            return response()->json([
                'message' => 'Департамент сохранен',
            ]);
        } else {
            return response()->json([
                'error' => 'Предоставьте правильную информацию',
            ], 422);
        }
    }

    public function destroy(Department $department)
    {
        if ($department->delete()) {
            return response()->json([
                'message' => 'Департамент успешно удалён!',
            ]);
        } else {
            return response()->json([
                'error' => 'Ошибка при удалении департамента',
            ], 422);
        }
    }
}
