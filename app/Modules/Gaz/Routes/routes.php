<?php

use Illuminate\Support\Facades\Route;
use Modules\Gaz\Controllers\StuffController;

/*
|--------------------------------------------------------------------------
| Gaz Routes
|--------------------------------------------------------------------------
|
| Марштруты, которые относятся к промежуточному модулю Gaz
|
*/

Route::middleware('auth')->group(function () {
    Route::prefix('/gaz')->name('gaz.')->group(function () {
        Route::get('/organizations', [StuffController::class, 'organizations'])->name('organizations');
        Route::get('/stuff', [StuffController::class, 'stuff'])->name('stuff');

    });

});
