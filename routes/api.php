<?php

use App\Http\Controllers\EventsAPIController;
use Illuminate\Support\Facades\Route;

Route::prefix('')->group(function () {
    Route::post('/create-event', [EventsAPIController::class, 'create_event'])->name('create-event');
    Route::post('/update/{event}', [EventsAPIController::class, 'update_event'])->name('update-event');
    Route::delete('/delete/{event}', [EventsAPIController::class, 'delete_event'])->name('delete-event');
    Route::get('/detail/{event}', [EventsAPIController::class, 'detail_event'])->name('detail-event');
    Route::get('/search', [EventsAPIController::class, 'search_event'])->name('search-event');
    Route::get('', [EventsAPIController::class, 'index'])->name('index-events');
});
