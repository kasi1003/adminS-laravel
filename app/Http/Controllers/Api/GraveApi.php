<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $cemeteryData = [
            'CemeteryName' => $request->input('grave_name'),
            'Town' => $request->input('town_selected'),
            'NumberOfSections' => $request->input('grave_number'),
            'TotalGraves' => $request->input('total_graves'),
            'AvailableGraves' => $request->input('total_graves'),
        ];
        DB::beginTransaction();
        try {
            
            $cemetery = Cemeteries::create($cemeteryData);

            // Retrieve the ID of the newly created cemetery
            $cemeteryID = $cemetery->getKey();
            // Prepare sections and graves data for bulk insertion
            $sectionsData = [];
            $gravesData = [];
            // Create sections for the cemetery and corresponding graves
            foreach ($request->input('sections') as $index => $section) {
                // Generate a unique section code based on the cemetery ID and index
                $sectionCode = 'Section' . '_' . $cemeteryID . '_' . ($index + 1);

                // Create a new section using the retrieved cemetery ID
                $newSection[] = [
                    'CemeteryID' => $cemeteryID,
                    'SectionCode' => $sectionCode,
                    'TotalGraves' => $section['total_graves'],
                    'AvailableGraves' => $section['available_graves'],
                ];

                // Generate and insert grave records
                // Generate and insert grave records for this section
                for ($i = 1; $i <= $section['available_graves']; $i++) {
                    $graves[] = [
                        'CemeteryID' => $cemeteryID,
                        'SectionCode' => $sectionCode,
                        'GraveNum' => $i,
                        'TotalGraves' => $section['total_graves'],
                        'AvailableGraves' => 1, // Assuming each grave is initially available
                    ];
                }
            }
            Sections::insert($sectionsData);
            Graves::insert($gravesData);
            DB::commit();

            return response()->json(['message' => 'Graveyard and graves added successfully', 'cemetery' => $cemetery, 'sections' => $newSection, 'graves' => $graves], 201);
        } catch (\Exception $e) {
            // Rollback the transaction if any step fails
            DB::rollback();

            return response()->json([
                'error' => 'Failed to add graveyard and graves',
            ], 500);
        }

        // Return a response indicating success
    }
}
