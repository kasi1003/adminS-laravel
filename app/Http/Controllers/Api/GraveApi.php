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
    //Create api
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'graveyardName' => 'required|string',
            'townLocation' => 'required|integer',
            'graveyardNumber' => 'required|integer',
            'numberOfRows.*' => 'required|integer',
            'numberOfGraves.*.*' => 'required|integer',

        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create a new instance of the Cemeteries model and fill it with validated data
            $cemetery = Cemeteries::create([
                'CemeteryName' => $validatedData['graveyardName'],
                'Town' => $validatedData['townLocation'],
                'NumberOfSections' => $validatedData['graveyardNumber'],
                // Add other model attributes here
            ]);
            // Create sections based on the number of sections
            // Get the CemeteryID after creating the cemetery
            $cemeteryID = $cemetery->getKey();
            // Prepare an array to store the data for all sections
            $sectionsData = [];
            // Loop through each section and prepare data for insertion
            for ($i = 0; $i < $validatedData['graveyardNumber']; $i++) {
                $sectionCode = 'S_' . $cemeteryID . '_' . ($i + 1); // Increment $i by 1 to start from 1

                // Add section data to the array
                $sectionsData[] = [
                    'CemeteryID' => $cemeteryID,
                    'SectionCode' => $sectionCode,
                    'Rows' => $validatedData['numberOfRows'][$i], // Store numberOfRows for each section
                    // Add other model attributes here
                ];

                // Add rows data for each section
                $rowsData = [];
                for ($j = 0; $j < $validatedData['numberOfRows'][$i]; $j++) {
                    $rowID = 'R_' . $cemeteryID . '_' . ($i + 1) . '_' . ($j + 1); // Increment $j by 1 to start from 1

                    // Add row data to the array
                    $rowsData[] = [
                        'CemeteryID' => $cemeteryID,
                        'SectionCode' => $sectionCode,
                        'RowID' => $rowID,
                        'AvailableGraves' => $validatedData['numberOfGraves'][$i][$j], // Store numberOfGraves for each row
                        'TotalGraves' => $validatedData['numberOfGraves'][$i][$j], // Store numberOfGraves for each row

                        // Add other model attributes here
                    ];
                    // Create graves based on the available graves in the row
                    for ($k = 0; $k < $validatedData['numberOfGraves'][$i][$j]; $k++) {
                        $graveNum = $k + 1; // Increment $k by 1 to start from 1

                        // Create a new grave and fill it with data
                        $grave = [
                            'CemeteryID' => $cemeteryID,
                            'SectionCode' => $sectionCode,
                            'RowID' => $rowID,
                            'GraveNum' => $graveNum,
                            // Add other model attributes here
                        ];

                        // Insert the grave into the database
                        Graves::create($grave);
                    }
                }
                Rows::insert($rowsData);
            }

            // Bulk insert all sections into the databas
            Sections::insert($sectionsData);

            // Bulk insert all rows into the database
            // Commit the transaction
            DB::commit();
            // Return a success response
            return response()->json(['message' => 'Cemetery data saved successfully', 'cemetery' => $cemetery, 'sections' => $sectionsData, 'rows' => $rowsData, 'graves' => $grave], 201);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            // Return an error response
            return response()->json(['message' => 'Failed to save cemetery data. ' . $e->getMessage()], 500);
        }
    }
    //Update records
    public function update(Request $request, $cemeteryID)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'graveyardName' => 'required|string',
            'townLocation' => 'required|integer',
            'graveyardNumber' => 'required|integer',
            'numberOfRows.*' => 'required|integer',
            'numberOfGraves.*.*' => 'required|integer',
        ]);
        // Delete existing records associated with the given CemeteryID
        Sections::where('CemeteryID', $cemeteryID)->delete();
        Rows::where('CemeteryID', $cemeteryID)->delete();
        Graves::where('CemeteryID', $cemeteryID)->delete();

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Update the Cemeteries record
            $cemetery = Cemeteries::findOrFail($cemeteryID);
            $cemetery->update([
                'CemeteryName' => $validatedData['graveyardName'],
                'Town' => $validatedData['townLocation'],
                'NumberOfSections' => $validatedData['graveyardNumber'],
                // Update other model attributes here
            ]);

            // Update or create sections, rows, and graves based on the updated data
            for ($i = 0; $i < $validatedData['graveyardNumber']; $i++) {
                $sectionCode = 'S_' . $cemeteryID . '_' . ($i + 1);

                // Update or create section
                $section = Sections::updateOrCreate(
                    ['CemeteryID' => $cemeteryID, 'SectionCode' => $sectionCode],
                    ['Rows' => $validatedData['numberOfRows'][$i]]
                    // Add other model attributes here
                );

                // Update or create rows for this section
                for ($j = 0; $j < $validatedData['numberOfRows'][$i]; $j++) {
                    $rowID = 'R_' . $cemeteryID . '_' . ($i + 1) . '_' . ($j + 1);
                    $row = Rows::updateOrCreate(
                        ['CemeteryID' => $cemeteryID, 'SectionCode' => $sectionCode, 'RowID' => $rowID],
                        ['AvailableGraves' => $validatedData['numberOfGraves'][$i][$j], 'TotalGraves' => $validatedData['numberOfGraves'][$i][$j]]
                        // Add other model attributes here
                    );

                    // Update or create graves for this row
                    $numberOfGraves = $validatedData['numberOfGraves'][$i][$j];
                    for ($k = 0; $k < $numberOfGraves; $k++) {
                        $graveNum = $k + 1;
                        $grave = Graves::updateOrCreate(
                            ['CemeteryID' => $cemeteryID, 'SectionCode' => $sectionCode, 'RowID' => $rowID, 'GraveNum' => $graveNum],
                            // Add other model attributes here if needed
                        );
                    }
                }
            }

            // Commit the transaction
            DB::commit();

            // Return a success response
            return response()->json(['message' => 'Cemetery data updated successfully', 'cemetery' => $cemetery, 'section' => $section, 'row' => $row, 'grave' => $grave], 200);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            // Return an error response
            return response()->json(['message' => 'Failed to update cemetery data. ' . $e->getMessage()], 500);
        }
    }
    //delete records
    public function delete(Request $request, $cemeteryID)
    {
        // Delete records associated with the selected cemetery ID from Sections, Rows, and Graves models
        Cemeteries::where('CemeteryID', $cemeteryID)->delete();
        Sections::where('CemeteryID', $cemeteryID)->delete();
        Rows::where('CemeteryID', $cemeteryID)->delete();
        Graves::where('CemeteryID', $cemeteryID)->delete();
    }
}
