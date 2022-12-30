<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function registry()
    {
        return response()->json(Area::all());
    }

    public function get()
    {
        return response()->json(Area::all());
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
            if (count($request->tags) > 0) {
                foreach ($request->tags as $tag) {
                    $tagsId [] = $tag['id'];
                }
                $area->tags()->sync($tagsId);
            }
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
