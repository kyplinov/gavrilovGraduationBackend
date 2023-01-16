<?php

namespace App\Http\Controllers;

use App\Helpers\ApplicationHelper;
use App\Helpers\CollectionHelper;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    public function registry(Request $request)
    {
        return response()->json(
            CollectionHelper::paginate(
                ApplicationHelper::filtered(Application::query(), $request),
                isset($queryParams['pageSize']) ? (int)$queryParams['pageSize'] : 10)
        );
    }

    public function get(Application $application)
    {
        return response()->json($application);
    }

    public function create(Request $request)
    {
        $application = new Application([
            'date_completed' => $request->date_completed,
            'employee_id' => $request->employee['id'],
            'support_id' => $request->support['id'],
            'description' => $request->description,
            'decide' => $request->decide,
            'status_id' => $request->status['id'],
        ]);
        if ($application->save()) {
            $this->saveIntermediateTableData($request, $application);
            return response()->json([
                'message' => 'Заявка сохранена',
                'id' => $application->id,
            ], 201);
        } else {
            return response()->json([
                'error' => 'Заявка не сохранена',
            ], 422);
        }
    }

    public function update(Request $request, Application $application)
    {
        $application->date_completed = $request->date_completed;
        $application->employee_id = $request->employee['id'];
        $application->support_id = $request->support['id'];
        $application->description = $request->description;
        $application->decide = $request->decide;
        $application->status_id = $request->status['id'];

        if ($application->update()) {
            $this->saveIntermediateTableData($request, $application);
            return response()->json([
                'message' => 'Заявка сохранена',
            ]);
        } else {
            return response()->json([
                'error' => 'Предоставьте правильную информацию',
            ], 422);
        }
    }

    private function saveIntermediateTableData(Request $request, Application $application)
    {
        $configurationUnitIds = [];
        $fileIds = [];

        foreach ($request->configurationUnits as $configurationUnit) {
            $configurationUnitIds [] = $configurationUnit['id'];
        }

        foreach ($request->appFiles as $file) {
            $fileIds [] = $file['id'];
        }

        $application->appFiles()->sync($fileIds);
        $application->configurationUnits()->sync($configurationUnitIds);
    }

    public function destroy(Application $application)
    {
        if ($application->delete()) {
            return response()->json([
                'message' => 'Заявка успешно удалена!',
            ]);
        } else {
            return response()->json([
                'error' => 'Ошибка при удалении заявки',
            ], 422);
        }
    }

    public function forConfigUnit(Request $request)
    {
        $appIds = [];
        $result = [];

        $applications = DB::table('application_configuration_unit')
            ->select('application_id')
            ->where('configuration_unit_id', '=', $request->configurationUnit)
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
