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
        // Validate the incoming request data
        $validatedData = $request->validate([
            'graveyardName' => 'required|string',
            'townLocation' => 'required|integer',
            'graveyardNumber' => 'required|integer',
            'numberOfRows.*' => 'required|integer',

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

               
            }
            // Bulk insert all sections into the database
            Sections::insert($sectionsData);
            // Bulk insert all rows into the database
            // Commit the transaction
            DB::commit();
            // Return a success response
            return response()->json(['message' => 'Cemetery data saved successfully', 'cemetery' => $cemetery, 'sections' => $sectionsData], 201);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            // Return an error response
            return response()->json(['message' => 'Failed to save cemetery data. ' . $e->getMessage()], 500);
        }
    }
}