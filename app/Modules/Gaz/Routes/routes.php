<?php

use Illuminate\Support\Facades\Route;
use Modules\Gaz\Controllers\OrganizationController;
use Modules\Gaz\Controllers\StaffController;

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
        Route::get('/organizations', [OrganizationController::class, 'index'])->name('organization.index');
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    });
});
