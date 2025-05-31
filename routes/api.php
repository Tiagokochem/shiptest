<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
|
*/

Route::apiResource('contacts', ContactController::class);
Route::post('contacts/export', [ContactController::class, 'exportCsv']);
