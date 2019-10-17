<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\ShowingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaymentController\ReservationPaymentController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('cinema')->group(
    function () {
        Route::get('/', [CinemaController::class, 'index'])->name('cinema.index');
        Route::get('/{cinema}', [CinemaController::class, 'edit'])->name('cinema.edit');
    }
);

Route::prefix('film')->group(
    function () {
        Route::get('/', [FilmController::class, 'index'])->name('film.index');
        Route::get('/{slug}', [FilmController::class, 'show'])->name('film.show');
    }
);

Route::prefix('visninger')->group(
    function () {
        Route::get('/{date}', [ShowingController::class, 'index'])
            ->where(['date' => '\d{4}-\d{2}-\d{2}'])
            ->name('showing.index');
        Route::get('/{date}/{showing}', [ShowingController::class, 'show'])
            ->where(['date' => '\d{4}-\d{2}-\d{2}'])
            ->name('showing.show');
        Route::get('/{slug}', [ShowingController::class, 'days'])->name('showing.days');
    }
);

Route::prefix('reservation')->group(
    function () {
        Route::get('/{reservation}', [
            ReservationController::class, 'show'
        ])->name('reservation.overview.show');
        Route::post('/{date}/{showing}', [
            ReservationController::class, 'store'
        ])
            ->where(['date' => '\d{4}-\d{2}-\d{2}'])
            ->name('reservation.store');

        Route::get('/betal/{reservation}', [
            ReservationPaymentController::class, 'index'
        ])->name('reservation.payment.index');
        Route::get('/callback/{reservation}', [
            ReservationPaymentController::class, 'callback'
        ])->name('reservation.payment.callback');
        Route::get('/betalt/{reservation}', [
            ReservationPaymentController::class, 'success'
        ])->name('reservation.payment.success');
        Route::get('/annulleret/{reservation}', [
            ReservationPaymentController::class, 'cancel'
        ])->name('reservation.payment.cancel');
    }
);
