<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function create(Request $request)
    {
        $path = $request->file('file')->store('files', 'public');
        $file = new File([
            'file_path' => '/storage/' . $path
        ]);
        if ($file->save()) {
            return response()->json([
                'message' => 'Файл сохранен',
                'id' => $file->id,
            ], 201);
        } else {
            return response()->json([
                'error' => 'Файл не сохранен',
            ], 422);
        }
    }
}
