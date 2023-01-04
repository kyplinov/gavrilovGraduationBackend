<?php

namespace App\Http\Controllers;

use App\Models\ConfigurationUnit;
use Illuminate\Http\Request;

class ConfigurationUnitController extends Controller
{
    public function registry(Request $request)
    {
        $queryParams = $request->all();
        $collection = ConfigurationUnit::paginate(isset($queryParams['pageSize']) ? (int)$queryParams['pageSize'] : 10);
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
        return response()->json(ConfigurationUnit::all());
    }

    public function create(Request $request)
    {
        $area = new ConfigurationUnit([
            'number' => $request->number,
            'serial_number' => $request->serial_number,
            'name' => $request->name,
            'configuration_unit_type_id' => $request->configurationUnitType['id'],
            'area_id' => $request->area['id'],
            'status_id' => $request->status['id'],
        ]);
        if ($area->save()) {
            return response()->json([
                'message' => 'КЕ сохранен',
                'id' => $area->id,
            ], 201);
        } else {
            return response()->json([
                'error' => 'КЕ не сохранен',
            ], 422);
        }
    }

    public function update(Request $request, ConfigurationUnit $configurationUnit)
    {
        $configurationUnit->number = $request->number;
        $configurationUnit->serial_number = $request->serial_number;
        $configurationUnit->name = $request->name;
        $configurationUnit->configuration_unit_type_id = $request->configurationUnitType['id'];
        $configurationUnit->area_id = $request->area['id'];
        $configurationUnit->status_id = $request->status['id'];

        if ($configurationUnit->update()) {
            return response()->json([
                'message' => 'КЕ сохранен',
            ]);
        } else {
            return response()->json([
                'error' => 'Предоставьте правильную информацию',
            ], 422);
        }
    }

    public function destroy(ConfigurationUnit $configurationUnit)
    {
        if ($configurationUnit->delete()) {
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
