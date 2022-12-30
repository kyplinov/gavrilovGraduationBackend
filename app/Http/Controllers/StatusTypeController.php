<?php

namespace App\Http\Controllers;

use App\Models\StatusType;
use Illuminate\Http\Request;

class StatusTypeController extends Controller
{
    public function registry()
    {
        return response()->json(StatusType::all());
    }

    public function get()
    {
        return response()->json(StatusType::all());
    }

    public function create(Request $request)
    {
        $statusType = new StatusType([
            'type' => $request->type,
        ]);
        if ($statusType->save()) {
            return response()->json([
                'message' => 'Тип статуса сохранен',
                'id' => $statusType->id
            ], 201);
        } else {
            return response()->json([
                'error' => 'Тип статуса не сохранен',
            ], 422);
        }
    }

    public function update(Request $request, StatusType $statusType)
    {
        $statusType->type = $request->type;

        if ($statusType->update()) {
            if (count($request->tags) > 0) {
                foreach ($request->tags as $tag) {
                    $tagsId [] = $tag['id'];
                }
                $statusType->tags()->sync($tagsId);
            }
            return response()->json([
                'message' => 'Тип статуса сохранен',
            ]);
        } else {
            return response()->json([
                'error' => 'Предоставьте правильную информацию',
            ], 422);
        }
    }

    public function destroy(StatusType $statusType)
    {
        if ($statusType->delete()) {
            return response()->json([
                'message' => 'Тип статуса успешно удалён!',
            ]);
        } else {
            return response()->json([
                'error' => 'Ошибка при удалении типа статуса',
            ], 422);
        }
    }
}
