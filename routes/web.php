<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PDFController;
use App\Http\Livewire\Quotations;
use App\Http\Controllers\DarkModeController;
use App\Models\Graves;


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

Route::post('/toggle-dark-mode', [DarkModeController::class, 'toggle']);

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
    
    Route::get('/serviceProviders', function () {
        return view('serviceProviders');
    })->name('serviceProviders');

    Route::get('/addGraveyards', function () {
        return view('addGraveyards');
    })->name('addGraveyards');
    
    Route::get('/burialRecords', function () {
        return view('burial-records-view');
    })->name('burialRecords');

    Route::get('/quotations', function () {
        return view('quotation-view');
    })->name('quotations');

    Route::post('/approve-order/{userId}', [Quotations::class, 'approveOrder'])->name('approve-order');


    // New route for generating PDFs
    Route::post('/generate-pdf/{userId}', [PDFController::class, 'generatePDF'])->name('generate-pdf');

    // Auth routes moved outside the middleware group
    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
});

require __DIR__ . '/auth.php';
