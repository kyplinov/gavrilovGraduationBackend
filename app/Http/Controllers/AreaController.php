<?php

namespace App\Http\Controllers;

use App\Helpers\CollectionHelper;
use App\Helpers\FilterHelper;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function registry(Request $request)
    {
        $queryParams = $request->all();
        $collection = FilterHelper::filtered(Area::query(), $request)->get();
        return response()->json(CollectionHelper::paginate($collection, isset($queryParams['pageSize']) ? (int)$queryParams['pageSize'] : 10));
    }

    public function get(Area $area)
    {
        return response()->json($area);
    }

    public function create(Request $request)
    {
        $area = new Area([
            'name' => $request->name,
            'department_id' => $request->department['id'],
        ]);
        if ($area->save()) {
            return response()->json([
                'message' => 'зона сохранен',
                'id' => $area->id,
            ], 201);
        } else {
            return response()->json([
                'error' => 'зона не сохранен',
            ], 422);
        }
    }

    public function update(Request $request, Area $area)
    {
        $area->name = $request->name;
        $area->department_id = $request->department['id'];

        if ($area->update()) {
            return response()->json([
                'message' => 'Зона сохранен',
            ]);
        } else {
            return response()->json([
                'error' => 'Предоставьте правильную информацию',
            ], 422);
        }
    }

    public function destroy(Area $area)
    {
        if ($area->delete()) {
            return response()->json([
                'message' => 'Зона успешно удалён!',
            ]);
        } else {
            return response()->json([
                'error' => 'Ошибка при удалении зоны',
            ], 422);
        }
    }
}
