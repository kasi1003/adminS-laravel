<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\TownController;
use App\Http\Controllers\Api\CemeteriesController;
use App\Http\Controllers\Api\GraveyardController;
use App\Http\Controllers\Api\BurialRecordsApi;

use App\Http\Controllers\Api\GraveApi;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});
Route::get('/regions', [GraveApi::class, 'showRegions'])->name('region');
Route::post('/postCem', [GraveApi::class, 'store']);
Route::delete('/deleteCem/{CemeteryID}',[GraveApi::class, 'delete']);
Route::put('/editCem/{CemeteryID}', [GraveApi::class, 'update']);
Route::put('/addBurialRecord/{CemeteryID}/{SectionCode}/{RowID}/{GraveNum}', [BurialRecordsApi::class, 'update']);
