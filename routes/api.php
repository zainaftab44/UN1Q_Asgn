<?php

use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'events'], function () {
    Route::post('/create', [EventController::class, 'create'])->name('create-event');
    Route::put('/update/{event}', [EventController::class, 'update'])->name('update-event');
    Route::delete('/delete/{event}', [EventController::class, 'delete'])->name('delete-event');
    Route::get('/detail/{event}', [EventController::class, 'detail'])->name('detail-event');
    Route::get('', [EventController::class, 'index'])->name('index-events');
});

// Route::api(['prefix' => 'events'], function () {
// })->middleware('auth:sanctum');
