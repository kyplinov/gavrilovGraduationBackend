<?php

namespace App\Http\Controllers;

use App\Models\Area;

class AreaController extends Controller
{
    public function getRegistry()
    {
        return response()->json(Area::all());
    }
}
