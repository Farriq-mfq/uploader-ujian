<?php

use App\Http\Controllers\AttchController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\operatorController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\SetupController;
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

Route::prefix('setup')->middleware('protect.setup')->group(function () {
    Route::get("/", [SetupController::class, 'index'])->name('setup.index');
    Route::post("/", [SetupController::class, 'run'])->name('setup.run');
    Route::post("/create-db", [SetupController::class, 'CreateDb'])->name('setup.createdb');
    Route::post("/create-admin", [SetupController::class, 'setupAdmin'])->name('setup.admin');
});

Route::middleware('setup')->group(function () {
    Route::prefix('private')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('dashboard')->middleware('role_login:auth,master,operator');
        Route::prefix('rooms')->middleware('role_login:auth,master,operator')->group(function () {
            Route::post('/batch_remove', [RoomsController::class, 'batch_remove'])->name('rooms.batch_remove');
            Route::post('/batch_active', [RoomsController::class, 'batch_active'])->name('rooms.batch_active');
            Route::post('/batch_inactive', [RoomsController::class, 'batch_inactive'])->name('rooms.batch_inactive');
            Route::post('/active/{room}', [RoomsController::class, 'active'])->name('rooms.active');
            Route::post('/{room}/attch', [RoomsController::class, 'attch'])->name('rooms.attch');
            Route::get("/{room}/ip", [RoomsController::class, 'show_ip'])->name('rooms.show_ip');
            Route::post("/{room}/ip", [RoomsController::class, 'add_ip'])->name('rooms.add_ip');
            Route::delete("/{room}/ip/{ip}", [RoomsController::class, 'delete_ip'])->name('rooms.delete_ip');
        });
        Route::delete('/attch/{attch}', [AttchController::class, 'removeAttch'])->name('attch.delete')->middleware('role_login:auth,master,operator');
        Route::resource('rooms', RoomsController::class)->middleware('role_login:auth,master,operator');


        Route::prefix('folder')->middleware('role_login:auth,master,operator')->group(function () {
            Route::get("/", [FolderController::class, 'index'])->name('folder.index');
            Route::get("/{room}/download", [FolderController::class, 'download_file'])->name('folder.download');
            Route::get("/{room}/detail", [FolderController::class, 'detail'])->name('folder.detail');
            Route::delete("/detail/{uploader}/delete", [FolderController::class, 'remove_upload'])->name('folder.delete');
            Route::delete("/detail/{room}/delete/all", [FolderController::class, 'remove_all'])->name('folder.remove_all');
        });

        Route::resource('operator', operatorController::class)->middleware('role_login:auth,master');
        // authentication
        Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('role_login:guest');
        Route::post('/login', [AuthController::class, 'login'])->name('login.action')->middleware('role_login:guest');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('role_login:auth');
    });

    // client
    Route::prefix('error')->middleware('ip_allow:error')->group(function () {
        Route::get("/", [ErrorController::class, 'index'])->name('error.index');
        Route::get("/block", [ErrorController::class, 'block'])->name('error.block');
    });
    // halaman tidak di temukan
    Route::get("/404", [ErrorController::class, 'not_found'])->name('error.not_found');
    //public room route
    Route::get('/', [UploaderController::class, 'index'])->name('uploader.index');
    Route::get('/{room}', [UploaderController::class, 'show_uploader'])->name('uploader.show')->middleware('ip_allow:check');
    Route::post('/{room}', [UploaderController::class, 'upload'])->name('uploader.upload')->middleware('ip_allow:check');
    Route::get('/attch/{attch}/download', [UploaderController::class, 'downloadAttch'])->name('uploader.download.attch');
});
