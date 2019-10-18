<?php

use App\Tmdb;
use App\Actions\FilmActions;
use Illuminate\Foundation\Inspiring;
use Spatie\MediaLibrary\Models\Media;

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

Artisan::command(
    'inspire',
    function () {
        $this->comment(Inspiring::quote());
    }
)->describe('Display an inspiring quote');

Artisan::command(
    'import:movies:popular',
    function (Tmdb $tmdb) {
        $this->comment('Importing movies...');

        $repo = $tmdb->repository();
        $movies = collect($repo->getPopular()->toArray());

        $movies->each(function ($movie) {
            (new FilmActions)->import($movie, 'popular');
        });
        
        $this->comment('Import finished.');
    }
)->describe('Import popular movies from TMDB');

Artisan::command(
    'import:movies:now-playing',
    function (Tmdb $tmdb) {
        $this->comment('Importing movies...');
        
        $repo = $tmdb->repository();
        $movies = collect($repo->getNowPlaying()->toArray());

        $movies->each(function ($movie) {
            (new FilmActions)->import($movie, 'now-playing');
        });

        $this->comment('Import finished.');
    }
)->describe('Import movies playing now from TMDB');

Artisan::command(
    'import:movies:genres',
    function (Tmdb $tmdb) {
        $this->comment('Importing movie genres...');

        $client = $tmdb->client;
        $genres = (object) $client->getGenresApi()->getGenres();
        $genres = collect($genres->genres);

        $genres
            ->map(
                function ($genre) {
                    return (object) $genre;
                }
            )->each(
                function ($genre) {
                    App\Genre::updateOrCreate(
                        ['tmdb_genre_id' => $genre->id],
                        ['name' => $genre->name]
                    );
                }
            );

        $this->comment('Import finished.');
    }
);

Artisan::command(
    'movies:data',
    function (Tmdb $tmdb) {
        $this->comment('Getting movies data...');

        $repo = $tmdb->repository();
        $films = $repo->getPopular()->toArray();

        dd($films);
        
        $this->comment('Finished.');
    }
)->describe('Get movie data from TMDB');

Artisan::command(
    'medialibrary:removeall',
    function (Media $media) {
        try {
            $this->comment('Starting to remove all files');

            $media->all()->each(function ($media) {
                $this->comment(
                    'Deleting '
                    . $media->getKey()
                    . ' '
                    . $media->file_name
                    . ' ('
                    . $media->model_type
                    . '<'
                    . $media->collection_name
                    . '>'
                    . ')'
                );

                $media->forceDelete();
            });

            $this->comment('All files removed successfully');
        } catch (Exception $e) {
            $this->comment('Something went wrong.');
            dd($e);
        }
    }
);
