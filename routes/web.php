<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'event_home'])->name('event-index');

Route::group(['prefix' => 'events'], function () {
    Route::get('/new', [EventController::class, 'event_new'])->name('event-new');
    Route::get('/detail/{event}', [EventController::class, 'event_detail'])->name('event-detail');
});

