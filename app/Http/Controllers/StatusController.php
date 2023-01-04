<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\StatusType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function registry(Request $request)
    {
        $queryParams = $request->all();
        $collection = Status::paginate(isset($queryParams['pageSize']) ? (int)$queryParams['pageSize'] : 10);
        foreach ($queryParams as $key => $value) {
            if ($key !== 'pageSize') {
                print_r($key);
                $collection = $collection->where("$key", 'LIKE' ,"$value");
            }
        }
        return response()->json($collection);
    }

    public function get()
    {
        return response()->json(Status::all());
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
