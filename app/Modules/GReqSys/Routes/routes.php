<?php

use Modules\GReqSys\Controllers\WebController;
use Illuminate\Support\Facades\Route;
use Modules\GReqSys\Controllers\AuthController;
use Modules\GReqSys\Controllers\ReqController;

/*
|--------------------------------------------------------------------------
| GReqSys Routes
|--------------------------------------------------------------------------
|
| Марштруты, которые относятся к модулю управления заявками
|
*/

Route::middleware('web')->group(function () {

    Route::get('/login', [WebController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::middleware('auth')->group(function () {

        Route::get('/', [ReqController::class, 'index'])->name('index');

        Route::prefix('/req')->name('req.')->group(function () {
            Route::get('/', [ReqController::class, 'index'])->name('index');
            Route::get('/create', [ReqController::class, 'create'])->name('create');
            Route::post('/', [ReqController::class, 'store'])->name('store');
        });

    });

});
