<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [HomeController::class, 'index'])->name('dashboard');
Route::prefix('rooms')->group(function () {
    Route::post('/batch_remove', [RoomsController::class, 'batch_remove'])->name('rooms.batch_remove');
    Route::post('/batch_active', [RoomsController::class, 'batch_active'])->name('rooms.batch_active');
    Route::post('/batch_inactive', [RoomsController::class, 'batch_inactive'])->name('rooms.batch_inactive');
    // Route::post('/active');
});
Route::resource('rooms', RoomsController::class);
