<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Rows;


class GetRows extends Controller
{
    public function getRows(Request $request, $sectionCode)
    {
         // Start a transaction
         DB::beginTransaction();

         try {
             // Fetch the RowIDs for the given Section code
             $rowIDs = Rows::where('SectionCode', $sectionCode)->pluck('RowID');
 
             // Commit the transaction
             DB::commit();
 
             // Return the RowIDs as a JSON response
             return response()->json(['rowIDs' => $rowIDs]);
         } catch (\Exception $e) {
             // Rollback the transaction in case of any exception
             DB::rollBack();
 
             // Return an error response
             return response()->json(['error' => 'Failed to fetch RowIDs.'], 500);
         }
    }
}
