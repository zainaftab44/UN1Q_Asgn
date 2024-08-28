<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'event_home'])->name('event-index');

Route::group(['prefix' => 'events'], function () {
    Route::get('/new', [EventController::class, 'event_new'])->name('event-new');
    // Route::post('/create-new', [EventController::class, 'event_create'])->name('event-create-new');
    Route::get('/detail/{event}', [EventController::class, 'event_detail'])->name('event-detail');
    // Route::get('/update/{event}', [EventController::class, 'event_update'])->name('event-update');
    // Route::get('/delete/{event}', [EventController::class, 'event_delete'])->name('event-delete');
});

