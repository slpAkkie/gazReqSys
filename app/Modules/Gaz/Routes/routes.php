<?php

use Illuminate\Support\Facades\Route;
use Modules\Gaz\Controllers\DepartmentController;
use Modules\Gaz\Controllers\StuffController;

/*
|--------------------------------------------------------------------------
| Gaz Routes
|--------------------------------------------------------------------------
|
| Марштруты, которые относятся к промежуточному модулю Gaz
|
*/

Route::middleware(['web', 'auth'])->group(function () {
    Route::prefix('/web-api/gaz')->name('api.gaz.')->group(function () {
        Route::get('/departments', [DepartmentController::class, 'index'])->name('department.index');
        Route::get('/stuff', [StuffController::class, 'show'])->name('stuff.show');
    });
});
