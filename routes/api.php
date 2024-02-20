<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\TownController;
use App\Http\Controllers\Api\CemeteriesController;
use App\Http\Controllers\Api\GraveyardController;
use App\Http\Controllers\Api\GraveController;


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
Route::get('/regions', [RegionController::class, 'index']);
Route::get('/towns/{region_id}', [TownController::class, 'index']);
Route::get('/cemeteries/names', [CemeteriesController::class, 'getCemeteryNames']);
Route::post('/cemeteryPost', [GraveyardController::class, 'store']);
Route::put('/gravesUpdate/{CemeteryID}/{SectionCode}/{GraveNum}', [GraveController::class, 'updateGrave']);