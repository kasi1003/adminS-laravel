<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Regions;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Regions::select('name')->get();
        return response()->json($regions);
    }
}
