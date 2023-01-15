<?php

namespace App\Http\Controllers;

use App\Helpers\CollectionHelper;
use App\Helpers\ConfigurationUnitHelper;
use App\Models\ConfigurationUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigurationUnitController extends Controller
{
    public function registry(Request $request)
    {
        return response()->json(
            CollectionHelper::paginate(
                ConfigurationUnitHelper::filtered(ConfigurationUnit::query(), $request),
                isset($queryParams['pageSize']) ? (int)$queryParams['pageSize'] : 10)
        );
    }

    public function get(ConfigurationUnit $configurationUnit)
    {
        return response()->json($configurationUnit);
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
            'extra' => $request->extra,
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
        $configurationUnit->extra = $request->extra;

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

    public function andereyLOx()
    {
        $lastConfigUnit = ConfigurationUnit::query()->orderBy('id', 'desc')->get()->first();
        return ($lastConfigUnit ? $lastConfigUnit->id : 0) + 1;
    }

    public function forArea(Request $request)
    {
        $configUnitIds = [];
        $result = [];

        $configUnits = DB::table('configuration_units')
            ->select('configuration_units.id')
            ->leftJoin('areas', 'areas.id', '=', 'configuration_units.area_id')
            ->leftJoin('departments', 'departments.id', '=', 'areas.department_id')
            ->whereIn('departments.id',
                DB::table('areas')
                    ->select('areas.department_id')
                    ->where('areas.id', '=', $request->AreaId)
            )
            ->whereNotIn('configuration_units.id',
                DB::table('configuration_unit_employee')
                ->select('configuration_unit_employee.configuration_unit_id')
            )
            ->get()->toArray();

        foreach ($configUnits as $configUnit) {
            array_push($configUnitIds, $configUnit->id);
        }

        if ($configUnitIds) {
            $query = ConfigurationUnit::query();
            $query->whereIn('id', $configUnitIds);
            $result = $query->get();
        }

        return response()->json($result);
    }
}
