<?php

namespace App\Http\Controllers;

use App\Helpers\CollectionHelper;
use App\Models\ConfigurationUnitType;
use Illuminate\Http\Request;

class ConfigurationUnitTypeController extends Controller
{
    public function registry(Request $request)
    {
        $queryParams = $request->all();
        $collection = ConfigurationUnitType::all();
        foreach ($queryParams as $key => $value) {
            if ($key !== 'pageSize') {
                $collection = $collection->where("$key", 'LIKE' ,"$value");
            }
        }
        return response()->json(CollectionHelper::paginate($collection, isset($queryParams['pageSize']) ? (int)$queryParams['pageSize'] : 10));
    }

    public function get(ConfigurationUnitType $employee)
    {
        return response()->json($employee);
    }

    public function create(Request $request)
    {
        $configurationUnitType = new ConfigurationUnitType([
            'type' => $request->type,
        ]);
        if ($configurationUnitType->save()) {
            return response()->json([
                'message' => 'Тип КЕ сохранен',
                'id' => $configurationUnitType->id,
            ], 201);
        } else {
            return response()->json([
                'error' => 'Тип КЕ не сохранен',
            ], 422);
        }
    }

    public function update(Request $request, ConfigurationUnitType $configurationUnitType)
    {
        $configurationUnitType->type = $request->type;

        if ($configurationUnitType->update()) {
            return response()->json([
                'message' => 'Тип КЕ сохранен',
            ]);
        } else {
            return response()->json([
                'error' => 'Предоставьте правильную информацию',
            ], 422);
        }
    }

    public function destroy(ConfigurationUnitType $configurationUnitType)
    {
        if ($configurationUnitType->delete()) {
            return response()->json([
                'message' => 'Тип КЕ успешно удалён!',
            ]);
        } else {
            return response()->json([
                'error' => 'Ошибка при удалении типа КЕ',
            ], 422);
        }
    }
}
