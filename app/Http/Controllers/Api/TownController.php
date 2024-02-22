<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Towns;

class TownController extends Controller
{
    public function index($regionId)
    {
        // Fetch towns based on the provided region ID
        $towns = Towns::where('region_id', $regionId)->select('name')->get();

        return response()->json($towns);
    }
}
