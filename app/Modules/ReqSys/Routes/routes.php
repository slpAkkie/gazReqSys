<?php

use Illuminate\Support\Facades\Route;
use Modules\ReqSys\Controllers\AuthController;
use Modules\ReqSys\Controllers\ReqController;
use Modules\ReqSys\Controllers\WebController;

/*
|--------------------------------------------------------------------------
| ReqSys Routes
|--------------------------------------------------------------------------
|
| Марштруты, которые относятся к модулю управления заявками
|
*/

Route::middleware('web')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', [WebController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    });
    Route::put('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::middleware('auth')->group(function () {

        Route::get('/', function () { return response()->redirectToRoute('req.index'); })->name('index');

        Route::prefix('/req')->name('req.')->group(function () {
            Route::get('/', [ReqController::class, 'index'])->name('index');
            Route::get('/for-me', [ReqController::class, 'indexForMe'])->name('index-for-me');
            Route::get('/create', [ReqController::class, 'create'])->name('create');
            Route::get('/{req}', [ReqController::class, 'show'])->name('show');
            Route::put('/confirm/{req}', [ReqController::class, 'confirm'])->name('confirm');
            Route::put('/deny/{req}', [ReqController::class, 'deny'])->name('deny');
            Route::put('/resolve/{req}', [ReqController::class, 'resolve'])->name('resolve');
        });

    });

    Route::prefix('/web-api/reqsys')->name('api.reqsys.')->group(function () {

        Route::prefix('/req')->name('req.')->group(function () {
            Route::post('/', [ReqController::class, 'store'])->name('store');
        });

    });

});
