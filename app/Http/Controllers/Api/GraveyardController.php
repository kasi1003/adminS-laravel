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
            $sectionCode = 'Section' . '_'.$cemeteryID. '_' . ($index + 1);

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


        // Return a response indicating success
        return response()->json(['message' => 'Graveyard and graves added successfully', 'cemetery'=>$cemetery, 'sections'=>$newSection, 'graves'=>$graves], 201);
    }
}
