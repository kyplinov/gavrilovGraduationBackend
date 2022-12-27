<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Photo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function getPhoto(int $id): string
    {
        $fileName =  DB::table('files')
            ->select(
                'files.file_name'
            )
            ->join('photos', 'files.id', '=', 'photos.file_id')
            ->where('photos.id','=', $id)
            ->first()->file_name;
        return $this->getTmpPath() . $fileName;
    }

    public function create(Request $request)
    {
        $path = $request->file('photo')->store('photos', 'public');
        $file = new File([
            'file_path' => $path
        ]);

        if ($file->save()) {
            $photo = new Photo([
                'file_id' => $file->id
            ]);
            if ($photo->save()) {
                return response()->json([
                    'message' => 'Фото сохранено',
                    'photo_id' => $photo->id,
                ], 201);
            } else {
                return response()->json([
                    'error' => 'Фото не сохранено',
                ], 422);
            }
        } else {
            return response()->json([
                'error' => 'Файл не сохранен',
            ], 422);
        }
    }

    private function getTmpPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . '/tmp/photo';
    }
}
