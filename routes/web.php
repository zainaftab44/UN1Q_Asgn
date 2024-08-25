<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'home'])->name('index');

Route::prefix('/event')->group(function () {
    Route::get('/new', [EventController::class, 'new'])->name('new');
    Route::post('/create-new', [EventController::class, 'createNew'])->name('create-new');
    Route::get('/detail/{event}', [EventController::class, 'event_detail'])->name('event-detail');
});

Route::prefix('/events')->group(function () {
    Route::post('/create', [EventController::class, 'create'])->name('create-event');
    Route::put('/update', [EventController::class, 'update'])->name('update-event');
    Route::delete('/delete/{event}', [EventController::class, 'delete'])->name('delete-event');
    Route::get('/detail/{event}', [EventController::class, 'detail'])->name('detail-event');
    Route::get('', [EventController::class, 'index'])->name('events-index');
});
