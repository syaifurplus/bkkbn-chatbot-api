<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StuntingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('stunting')->group(function () {
    Route::get('/national-overview', [StuntingController::class, 'nationalOverview']);
    Route::get('/region', [StuntingController::class, 'byRegion']);
    Route::get('/trend', [StuntingController::class, 'trend']);
    Route::get('/realtime', [StuntingController::class, 'realtime']);
    Route::get('/target', [StuntingController::class, 'target']);
});