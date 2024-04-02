<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/addGraveyard', [AdminController::class, 'showRegions']);
    Route::get('/getTowns/{regionId}', [AdminController::class, 'getTowns']);



    //this is the line i was sayoing is wrong
    Route::get('/edit-graveyard', [AdminController::class, 'edit_graveyard'])->name('grave.edit');
    Route::get('/burial-records', [AdminController::class, 'burial_records'])->name('grave.records');
    Route::get('/quotations', [AdminController::class, 'quotationsFun'])->name('grave.quotas');
    Route::get('/service-providers', function () {
        return view('serviceProviders');
    });
    //administration route to add and modify the grave yards
    Route::get('/graveyard-admin', [AdminController::class, 'grave_admin'])->name('grave.admin');
    Auth::routes();



    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

require __DIR__ . '/auth.php';
