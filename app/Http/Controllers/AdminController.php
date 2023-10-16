<?php

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminS;

class AdminController extends Controller
{
    public function showRegions()
    {
        $regions = AdminS::all();
        return view('addGraveyards', ['regions' => $regions]);
    }
    public function getTowns($regionId)
    {
        $towns = AdminS::where('region_id', $regionId)->get(); // Use the adminS model

        return view('towns', ['towns' => $towns]);
    }
}
