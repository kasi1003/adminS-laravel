<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Graves;
use App\Models\Cemeteries;
use App\Models\Sections;
use App\Models\Regions;
use App\Models\Towns;
use App\Http\Resources\CemeteriesResource;

class GraveApi extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request if necessary
        // Create a new cemetery record

        $cemetery = Cemeteries::create([
            'CemeteryName' => $request->input('grave_name'),
            'Town' => $request->input('town_selected'),
            'NumberOfSections' => $request->input('grave_number'),
            'TotalGraves' => $request->input('total_graves'),
            'AvailableGraves' => $request->input('total_graves'),
        ]);
        // Retrieve the ID of the newly created cemetery
        $cemeteryID = $cemetery->getKey();

        // Create sections for the cemetery and corresponding graves
        foreach ($request->input('sections') as $index => $section) {
            // Generate a unique section code based on the cemetery ID and index
            $sectionCode = 'Section' . '_' . $cemeteryID . '_' . ($index + 1);

            // Create a new section using the retrieved cemetery ID
            $newSection = Sections::create([
                'CemeteryID' => $cemeteryID,
                'SectionCode' => $sectionCode,
                'TotalGraves' => $section['total_graves'],
                'AvailableGraves' => $section['available_graves'],
            ]);

            // Generate and insert grave records
            $availableGraves = $newSection->AvailableGraves;
            for ($i = 1; $i <= $availableGraves; $i++) {
                $graves = Graves::create([
                    'CemeteryID' => $cemeteryID,
                    'SectionCode' => $newSection->SectionCode,
                    'GraveNum' => $i,
                    'TotalGraves' => $section['total_graves'],
                    'AvailableGraves' => $section['available_graves'],
                ]);

            }

        }
        return response()->json(['message' => 'Graveyard and graves added successfully', 'cemetery' => $cemetery, 'sections' => $newSection, 'graves' => $graves], 201);


        // Return a response indicating success
    }
    public function updateGrave(Request $request, $CemeteryID, $SectionCode, $GraveNum)
    {
        // Validate request data
        $request->validate([
            'BuriedPersonsName' => 'required',
            'DateOfBirth' => 'required|date',
            'DateOfDeath' => 'required|date',
        ]);

        // Update grave record
        $grave = Graves::where([
            'CemeteryID' => $CemeteryID,
            'SectionCode' => $SectionCode,
            'GraveNum' => $GraveNum,
        ])->first();

        if ($grave) {
            $grave->BuriedPersonsName = $request->input('BuriedPersonsName');
            $grave->DateOfBirth = $request->input('DateOfBirth');
            $grave->DateOfDeath = $request->input('DateOfDeath');
            $grave->GraveStatus = 1;
            $grave->save();

            return response()->json(['message' => 'Grave updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Grave not found'], 404);
        }
    }
    public function getCemeteryNames()
    {
        $cemeteries = Cemeteries::all();
        $cemeteryNames = $cemeteries->pluck('CemeteryName')->all();

        return new CemeteriesResource(response()->json($cemeteryNames));
    }
    public function showRegions()
    {
        $regions = Regions::select('name')->get();
        return response()->json($regions);
    }
    public function showTowns($regionId)
    {
        // Fetch towns based on the provided region ID
        $towns = Towns::where('region_id', $regionId)->select('name')->get();

        return response()->json($towns);
    }
    public function deleteGraveyard($cemeteryID)
    {
        // Find the cemetery record based on the provided CemeteryID
        $cemetery = Cemeteries::find($cemeteryID);
    
        if (!$cemetery) {
            return response()->json(["message" => "Cemetery not found"], 404);
        }
    
        // Delete the cemetery record
        $cemetery->delete();
    
        // Delete associated sections using cascading delete
        $cemetery->sections()->delete();
    
        return response()->json(["message" => "Cemetery and associated sections deleted successfully"]);
    }
    
}
