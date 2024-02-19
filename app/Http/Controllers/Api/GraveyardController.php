<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cemeteries;
use App\Models\Sections;
use App\Models\Graves;

class GraveyardController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request if necessary
// Create a new cemetery record
        $cemetery = Cemeteries::create([
            'CemeteryName' => $request->input('graveyard_name'),
            'Town' => $request->input('town_selected'),
            'NumberOfSections' => $request->input('grave_number'),
            'TotalGraves' => $request->input('total_graves'),
            'AvailableGraves' => $request->input('total_graves'),
        ]);

        // Create sections for the cemetery and corresponding graves
        foreach ($request->input('sections') as $index => $section) {
            // Generate a unique section code based on the cemetery ID and index
            $sectionCode = 'S' . $cemetery->id . '_' . ($index + 1);

            // Create a new section
            $newSection = Sections::create([
                'CemeteryID' => $cemetery->id,
                'SectionCode' => $sectionCode,
                'TotalGraves' => $section['total_graves'],
                'AvailableGraves' => $section['available_graves'],
            ]);

            // Generate and insert grave records
            $availableGraves = $newSection->AvailableGraves;
            for ($i = 1; $i <= $availableGraves; $i++) {
                Graves::create([
                    'CemeteryID' => $cemetery->id,
                    'SectionCode' => $newSection->SectionCode,
                    'GraveNum' => $i,
                    'TotalGraves' => $section['total_graves'],
                    'AvailableGraves' => $section['available_graves'],
                ]);
            }
        }

        // Return a response indicating success
        return response()->json(['message' => 'Graveyard and graves added successfully'], 201);
    }
}
