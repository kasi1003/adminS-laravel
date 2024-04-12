<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cemeteries;
class CemeteriesController extends Controller
{
    public function getCemeteryNames()
    {
        $cemeteries = Cemeteries::all();
        $cemeteryNames = $cemeteries->pluck('CemeteryName')->all();

        return response()->json($cemeteryNames);
    }
}
