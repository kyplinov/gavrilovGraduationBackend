<?php

namespace App\Http\Controllers;

use App\Helpers\CollectionHelper;
use App\Models\Status;
use App\Models\StatusType;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function registry(Request $request)
    {
        $queryParams = $request->all();
        $collection = Status::all();
        foreach ($queryParams as $key => $value) {
            if ($key !== 'pageSize') {
                $collection = $collection->where("$key", 'LIKE' ,"$value");
            }
        }
        return response()->json(CollectionHelper::paginate($collection, isset($queryParams['pageSize']) ? (int)$queryParams['pageSize'] : 10));
    }

    public function get(Status $status)
    {
        return response()->json($status);
    }

    public function create(Request $request)
    {
        $area = new Status([
            'name' => $request->name,
            'status_type' => $request->status_type,
        ]);
        if ($area->save()) {
            return response()->json([
                'message' => 'Статус сохранен',
                'id' => $area->id
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
        $status->status_type = $request->status_type;

        if ($status->update()) {
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
