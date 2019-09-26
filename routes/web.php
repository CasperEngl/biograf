<?php

use App\Http\Controllers\CinemaController;

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

Route::get('/', function () {
  return redirect()->route('cinema.index');
});

Route::prefix('cinema')->group(function () {
  Route::get('/', [CinemaController::class, 'index'])->name('cinema.index');
  Route::get('/{cinema}', [CinemaController::class, 'edit'])->name('cinema.edit');
});
