<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function getRegistry(Request $request)
    {
        return response()->json(Area::all());
    }
}
