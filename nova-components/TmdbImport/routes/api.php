<?php

use App\Tmdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get(
    '/',
    function (Tmdb $tmdb) {
        $client = $tmdb->client;

        return $client->getSearchApi()->searchMovies(
            request('query'),
            [
                'page' => request('page', 1),
                'per_page' => request('per_page', 6),
            ],
        );
    }
);

Route::post(
    '/import',
    function (Tmdb $tmdb, Request $request) {
        $repo = $tmdb->repository();

        $movie = $repo->load(request('id'));

        return $movie->getImdbId();
        
        return (new \App\Actions\FilmActions)->import($movie, 'manual');
    }
);
