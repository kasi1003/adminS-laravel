<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Graves;
use Illuminate\Support\Facades\DB;



class BurialRecordsApi extends Controller
{
    public function update(Request $request, $cemeteryID, $sectionCode, $rowID, $graveNum)
    {
        try {
            // Start a transaction
            DB::beginTransaction();

            $dataToUpdate = $request->only(['BuriedPersonsName', 'DateOfBirth', 'DateOfDeath', 'DeathCode']);
            $dataToUpdate['GraveStatus'] = 1;

            $affectedRows = Graves::where('CemeteryID', $cemeteryID)
                ->where('SectionCode', $sectionCode)
                ->where('RowID', $rowID)
                ->where('GraveNum', $graveNum)
                ->update($dataToUpdate);



            // Fetch the updated Grave record
            $updatedGrave = Graves::where('CemeteryID', $cemeteryID)
                ->where('SectionCode', $sectionCode)
                ->where('RowID', $rowID)
                ->where('GraveNum', $graveNum)

                ->firstOrFail();

            // Commit the transaction
            DB::commit();

            // Optionally, you can include cemetery, section, row along with the updated grave in the response
            return response()->json([
                'message' => 'Cemetery data updated successfully',

                'grave' => $updatedGrave
            ], 200);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            // Return an error response
            return response()->json(['message' => 'Failed to update cemetery data. ' . $e->getMessage()], 500);
        }
    }
    public function delete(Request $request, $cemeteryID, $sectionCode, $rowID, $graveNum)
    {
        try {
            // Start a transaction
            DB::beginTransaction();

            // Delete the specified column values
            $affectedRows = Graves::where('CemeteryID', $cemeteryID)
                ->where('SectionCode', $sectionCode)
                ->where('RowID', $rowID)
                ->where('GraveNum', $graveNum)
                ->update([
                    'GraveStatus' => null,
                    'BuriedPersonsName' => null,
                    'DateOfBirth' => null,
                    'DateOfDeath' => null,
                    'DeathCode' => null,
                ]);

            // Fetch the updated Grave record
            $updatedGrave = Graves::where('CemeteryID', $cemeteryID)
                ->where('SectionCode', $sectionCode)
                ->where('RowID', $rowID)
                ->where('GraveNum', $graveNum)
                ->firstOrFail();

            // Commit the transaction
            DB::commit();

            // Optionally, you can include cemetery, section, row along with the updated grave in the response
            return response()->json([
                'message' => 'Specified column values deleted successfully',
                'grave' => $updatedGrave
            ], 200);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            // Return an error response
            return response()->json(['message' => 'Failed to delete specified column values. ' . $e->getMessage()], 500);
        }
    }
}
