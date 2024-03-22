<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Graves;
use App\Models\Cemeteries;
use App\Models\Sections;
use App\Models\Rows;

use App\Models\Regions;
use App\Models\Towns;
use App\Http\Resources\CemeteriesResource;

class GraveApi extends Controller
{
    public function store(Request $request)
    {
        $cemeteryData = [
            'CemeteryName' => $request->input('grave_name'),
            'Town' => $request->input('town_selected'),
            'NumberOfSections' => $request->input('grave_number')
        ];
        
        DB::beginTransaction();
        try {

            $cemetery = Cemeteries::create($cemeteryData);

            // Retrieve the ID of the newly created cemetery
            $cemeteryID = $cemetery->getKey();


            
            DB::commit();

            return response()->json(['message' => 'Graveyard, sections, and graves added successfully', 'Cemeteries'=>$cemeteryData ], 201);
        } catch (\Exception $e) {
            // Rollback the transaction if any step fails
            DB::rollback();

            return response()->json(['error' => 'Failed to add graveyard and graves'], 500);
        }
    }
}