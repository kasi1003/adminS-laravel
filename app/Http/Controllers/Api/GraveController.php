<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Graves;

class GraveController extends Controller
{
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

}
