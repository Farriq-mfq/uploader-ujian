<?php

use App\Http\Controllers\AttchController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\UploaderController;
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

Route::prefix('private')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::prefix('rooms')->group(function () {
        Route::post('/batch_remove', [RoomsController::class, 'batch_remove'])->name('rooms.batch_remove');
        Route::post('/batch_active', [RoomsController::class, 'batch_active'])->name('rooms.batch_active');
        Route::post('/batch_inactive', [RoomsController::class, 'batch_inactive'])->name('rooms.batch_inactive');
        Route::post('/active/{room}', [RoomsController::class, 'active'])->name('rooms.active');
        Route::post('/{room}/attch', [RoomsController::class, 'attch'])->name('rooms.attch');
        Route::get("/{room}/ip", [RoomsController::class, 'show_ip'])->name('rooms.show_ip');
        Route::post("/{room}/ip", [RoomsController::class, 'add_ip'])->name('rooms.add_ip');
        Route::delete("/{room}/ip/{ip}", [RoomsController::class, 'delete_ip'])->name('rooms.delete_ip');
    });
    Route::delete('/attch/{attch}', [AttchController::class, 'removeAttch'])->name('attch.delete');
    Route::resource('rooms', RoomsController::class);


    Route::prefix('folder')->group(function () {
        Route::get("/", [FolderController::class, 'index'])->name('folder');
        Route::get("/{room}/download", [FolderController::class, 'download_file'])->name('folder.download');
    });
});

// client
Route::prefix('error')->middleware('ip_allow:error')->group(function () {
    Route::get("/", [ErrorController::class, 'index'])->name('error.index');
    Route::get("/block", [ErrorController::class, 'block'])->name('error.block');
});
//public room route
Route::get('/', [UploaderController::class, 'index'])->name('uploader.index');
Route::get('/{room}', [UploaderController::class, 'show_uploader'])->name('uploader.show')->middleware('ip_allow:check');
Route::post('/{room}', [UploaderController::class, 'upload'])->name('uploader.upload')->middleware('ip_allow:check');
Route::get('/attch/{attch}/download', [UploaderController::class, 'downloadAttch'])->name('uploader.download.attch');
