<?php

use App\Tmdb;
use App\Actions\Film;
use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('import:movies:popular', function (Tmdb $tmdb) {
    $this->comment('Importing movies...');

    $repo = $tmdb->repository();
    $films = $repo->getPopular()->toArray();

    (new Film)->importMany($films, 'popular');

    $this->comment('Import finished.');

})->describe('Import popular movies from TMDB');

Artisan::command('import:movies:now-playing', function (Tmdb $tmdb) {
    $this->comment('Importing movies...');

    $repo = $tmdb->repository();
    $films = $repo->getNowPlaying()->toArray();

    (new Film)->importMany($films, 'now-playing');

    $this->comment('Import finished.');

})->describe('Import popular movies from TMDB');