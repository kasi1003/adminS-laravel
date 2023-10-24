<?php

use App\Http\Livewire\EditGraveyard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/addGraveyard', [AdminController::class, 'showRegions']);
Route::get('/getTowns/{regionId}', [AdminController::class, 'getTowns']);
Route::get('/edit-graveyard', AdminController::class);
//administration route to add and modify the grave yards
Route::get('/graveyard-admin', [AdminController::class, 'grave_admin'])->name('grave.admin');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
