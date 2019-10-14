<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\ShowingController;
use App\Http\Controllers\ReservationController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('cinema')->group(function () {
    Route::get('/', [CinemaController::class, 'index'])->name('cinema.index');
    Route::get('/{cinema}', [CinemaController::class, 'edit'])->name('cinema.edit');
});

Route::prefix('film')->group(function () {
    Route::get('/', [FilmController::class, 'index'])->name('film.index');
    Route::get('/{slug}', [FilmController::class, 'show'])->name('film.show');
});

Route::prefix('visninger')->group(function () {
    Route::get('/{date}', [ShowingController::class, 'index'])
        ->where(['date' => '\d{4}-\d{2}-\d{2}'])
        ->name('showing.index');
    Route::get('/{date}/{showing}', [ShowingController::class, 'show'])
        ->where(['date' => '\d{4}-\d{2}-\d{2}'])
        ->name('showing.show');
});

Route::prefix('reservation')->group(function () {
    Route::post('/{date}/{showing}', [ReservationController::class, 'store'])
        ->where(['date' => '\d{4}-\d{2}-\d{2}'])
        ->name('reservation.store');
    Route::get('/betal', [ReservationController::class, 'pay'])->name('reservation.pay');
});
