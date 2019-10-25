<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShowingController;
use App\Http\Controllers\FilmRatingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReservationUpdateController;
use App\Http\Controllers\PaymentController\ReservationPaymentController;

Auth::routes();
Broadcast::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('profile')->group(
    function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/', [ProfileController::class, 'store'])->name('profile.store');
        Route::post('/password', [ProfileController::class, 'password'])->name('profile.password');
    }
);

Route::prefix('film')->group(
    function () {
        Route::get('/', [FilmController::class, 'index'])->name('film.index');
        Route::get('/{slug}', [FilmController::class, 'show'])->name('film.show');
        Route::get('/vælg', [FilmController::class, 'pick'])->name('film.pick');

        Route::prefix('anmeldelse')->group(
            function () {
                Route::get('/{film}', [FilmRatingController::class, 'index'])
                    ->name('film.rating.index');

                Route::post('/{film}', [FilmRatingController::class, 'store'])
                    ->name('film.rating.store');
            }
        );
    }
);

Route::prefix('visninger')->group(
    function () {
        Route::get('/', [ShowingController::class, 'pick'])->name('showing.pick');

        Route::get('/{date}', [ShowingController::class, 'index'])
            ->where(['date' => '\d{4}-\d{2}-\d{2}'])
            ->name('showing.index');
            
        Route::get('/{date}/{showing}', [ShowingController::class, 'show'])
            ->where(['date' => '\d{4}-\d{2}-\d{2}'])
            ->name('showing.show');

        Route::get('/{slug}', [ShowingController::class, 'days'])
            ->name('showing.days');
    }
);

Route::prefix('reservation')->group(
    function () {
        Route::get('/complete/{showing}', [
            ReservationController::class,
            'finalize',
        ])->name('reservation.finalize');

        Route::get('/{reservation}', [
            ReservationController::class,
            'show',
        ])->name('reservation.overview.show');

        Route::post('/{showing}', [
            ReservationController::class,
            'store',
        ])->name('reservation.store');

        Route::get('/betal/{reservation}', [
            ReservationPaymentController::class,
            'index',
        ])->name('reservation.payment.index');

        Route::get('/callback/{reservation}', [
            ReservationPaymentController::class,
            'callback',
        ])->name('reservation.payment.callback');

        Route::get('/betalt/{reservation}', [
            ReservationPaymentController::class,
            'success',
        ])->name('reservation.payment.success');

        Route::get('/annulleret/{reservation}', [
            ReservationPaymentController::class,
            'cancel',
        ])->name('reservation.payment.cancel');

        Route::get('/{reservation}/update/email', [
            ReservationUpdateController::class,
            'index'
        ])->name('reservation.update.email.index');

        Route::post('/{reservation}/update/email', [
            ReservationUpdateController::class,
            'store'
        ])->name('reservation.update.email.store');
    }
);

Route::get('/js/lang.js', function () {
    $strings = cache()->remember('lang.js', now()->add(1, 'day'), function () {
        $lang = config('app.locale');

        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');
