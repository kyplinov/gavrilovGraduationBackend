<?php

namespace App\Http\Controllers;

use App\Helpers\CollectionHelper;
use App\Helpers\FilterHelper;
use App\Models\Application;
use App\Models\ConfigurationUnitType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigurationUnitTypeController extends Controller
{
    public function registry(Request $request)
    {
        $queryParams = $request->all();
        $collection = FilterHelper::filtered(ConfigurationUnitType::query(), $request)->get();
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

    public function forApp(Request $request)
    {
        $configUnitId = $request->config_unit_id;
        $appIds = [];
        $result = null;

        $applications = DB::table('application_configuration_unit')
            ->select('application_id')
            ->where('configuration_unit_id', '=', $configUnitId)
            ->get()->toArray();

        foreach ($applications as $application) {
            array_push($appIds, $application->application_id);
        }

        if ($appIds) {
            $query = Application::query();
            $result = $query->whereIn('id', $appIds)->get();
        }

        return response()->json($result);
    }
}
