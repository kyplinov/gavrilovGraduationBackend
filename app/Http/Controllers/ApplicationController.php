<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function registry(Request $request)
    {
        $queryParams = $request->all();
        $collection = Application::paginate(isset($queryParams['pageSize']) ? (int)$queryParams['pageSize'] : 10);
        foreach ($queryParams as $key => $value) {
            if ($key !== 'pageSize') {
                print_r($key);
                $collection = $collection->where("$key", 'LIKE' ,"$value");
            }
        }
        return response()->json($collection);
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

            if (count($request->configurationUnits) > 0) {
                foreach ($request->configurationUnits as $configurationUnit) {
                    $configurationUnitIds [] = $configurationUnit['id'];
                }
                $application->configurationUnits()->sync($configurationUnitIds);
            }

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

            if (count($request->configurationUnits) > 0) {
                foreach ($request->configurationUnits as $configurationUnit) {
                    $configurationUnitIds [] = $configurationUnit['id'];
                }
                $application->configurationUnits()->sync($configurationUnitIds);
            }

            return response()->json([
                'message' => 'Заявка сохранена',
            ]);
        } else {
            return response()->json([
                'error' => 'Предоставьте правильную информацию',
            ], 422);
        }
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
}
