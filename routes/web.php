<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\ShowingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
    Route::get('/{date}', [ShowingController::class, 'index'])->name('showing.index');
    Route::get('/{date}/{showing}', [ShowingController::class, 'show'])->name('showing.show');
});
