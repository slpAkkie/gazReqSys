<?php

use App\Modules\GReqSys\Controllers\WebController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| GReqSys Routes
|--------------------------------------------------------------------------
|
| Марштруты, которые относятся к модулю управления заявками
|
*/

Route::get('/', [WebController::class, 'index']);
