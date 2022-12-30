<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\StatusType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function registry()
    {
        return response()->json(Status::all());
    }

    public function get()
    {
        return response()->json(Status::all());
    }

    public function statusFromType(StatusType $statusType)
    {
        return response()->json(Status::with('status_types')->find($statusType->id)->all());
    }

    public function create(Request $request)
    {
        $area = new Status([
            'name' => $request->name,
            'status_type_id' => $request->status_type['id'],
        ]);
        if ($area->save()) {
            return response()->json([
                'message' => 'Статус сохранен',
            ], 201);
        } else {
            return response()->json([
                'error' => 'Статус не сохранен',
            ], 422);
        }
    }

    public function update(Request $request, Status $status)
    {
        $status->name = $request->name;
        $status->status_type_id = $request->status_type['id'];

        if ($status->update()) {
            if (count($request->tags) > 0) {
                foreach ($request->tags as $tag) {
                    $tagsId [] = $tag['id'];
                }
                $status->tags()->sync($tagsId);
            }
            return response()->json([
                'message' => 'Статус сохранен',
            ]);
        } else {
            return response()->json([
                'error' => 'Предоставьте правильную информацию',
            ], 422);
        }
    }

    public function destroy(Status $status)
    {
        if ($status->delete()) {
            return response()->json([
                'message' => 'Статус успешно удалён!',
            ]);
        } else {
            return response()->json([
                'error' => 'Ошибка при удалении статуса',
            ], 422);
        }
    }
}
