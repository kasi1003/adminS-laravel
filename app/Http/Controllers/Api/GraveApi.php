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
            // Prepare rows and graves data for bulk insertion
            $rowsData = [];
            $gravesData = [];
            foreach ($request->input('sections') as $index => $section) {
                // Generate a unique section code based on the cemetery ID and index
                $sectionCode = 'Section' . '_' . $cemeteryID . '_' . ($index + 1);
                // Get the "Rows" value from the current section
                $rows = $section['rows'];
                // Create a new section using the retrieved cemetery ID
                $newSection = [
                    'CemeteryID' => $cemeteryID,
                    'SectionCode' => $sectionCode,
                    'Rows' => $section['rows'], // Include the "Rows" value from the request
                    //'TotalGraves' => $section['total_graves'],
                    //'AvailableGraves' => $section['available_graves'],
                ];
                $sectionsData[] = $newSection;


                for ($rowNum = 1; $rowNum <= $section['rows']; $rowNum++) {
                    // Iterate through each row in the section
                    $rowsData[] = [
                        'RowID' => $rowNum,
                        'CemeteryID' => $cemeteryID,
                        'SectionCode' => $sectionCode,
                        'AvailableGraves' => $section['available_graves'],
                        'TotalGraves' => $section['total_graves'],
                    ];


                    // Create individual grave records for each grave in the row
                    for ($graveNum = 1; $graveNum <= $section['graves'][$index][$rowNum]; $graveNum++) {
                        // Create a new grave record for each grave in the row
                        $gravesData[] = [
                            'CemeteryID' => $cemeteryID,
                            'SectionCode' => $sectionCode,
                            'RowID' => $rowNum,
                            'GraveNum' => $graveNum,
                            'GraveStatus' => null, // Assuming each grave is initially available

                            // Assuming each grave is initially available
                        ];
                    }
                }
            }


            Sections::insert($sectionsData);
            Graves::insert($gravesData);
            DB::commit();

            return response()->json(['message' => 'Graveyard and graves added successfully', 'cemetery' => $cemetery, 'sections' => $newSection, 'graves' => $gravesData], 201);
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
