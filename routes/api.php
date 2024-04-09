<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\TownController;
use App\Http\Controllers\Api\CemeteriesController;
use App\Http\Controllers\Api\GraveyardController;
use App\Http\Controllers\Api\BurialRecordsApi;
use App\Http\Controllers\Api\GetRows;
use App\Http\Controllers\Api\GraveApi;
use App\Http\Controllers\Api\ServiceProviderApi;

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
Route::post('/postProvider', [ServiceProviderApi::class, 'store']);
Route::put('/editProvider/{id}', [ServiceProviderApi::class, 'update']);
Route::delete('/deleteProvider/{id}',[ServiceProviderApi::class, 'delete']);


Route::delete('/deleteCem/{CemeteryID}',[GraveApi::class, 'delete']);
Route::put('/editCem/{CemeteryID}', [GraveApi::class, 'update']);
Route::put('/addBurialRecord/{CemeteryID}/{SectionCode}/{RowID}/{GraveNum}', [BurialRecordsApi::class, 'update']);
Route::put('/deleteBurialRecord/{CemeteryID}/{SectionCode}/{RowID}/{GraveNum}', [BurialRecordsApi::class, 'delete']);
Route::get('/getRows/{SectionCode}', [GetRows::class, 'getRows']);
