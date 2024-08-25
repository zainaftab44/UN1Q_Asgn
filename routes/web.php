<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;


Route::prefix('/events')->group(function () {
    Route::post('/create', [EventController::class, 'create']);
    Route::put('/update', [EventController::class, 'update']);
    Route::delete('/delete/{event}', [EventController::class, 'delete']);
    Route::get('/detail/{event}', [EventController::class, 'detail']);
    Route::get('', [EventController::class, 'index']);
});
