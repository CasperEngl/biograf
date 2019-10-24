<?php

namespace App\Jobs;

use App\Film;
use Tmdb\Model\Movie;
use App\Actions\FilmActions;
use Illuminate\Bus\Queueable;
use App\Jobs\ProcessFilmPoster;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessTmdbFilm implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $film;

    public $movie;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Film $film, Movie $movie)
    {
        $this->film = $film;
        $this->movie = $movie;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(FilmActions $filmActions)
    {
        $images = $filmActions->tmdb($this->film)->getImages();
        
        $runtime = (integer) $filmActions->tmdb($this->film)->getRuntime();
        $imdb_id = $filmActions->tmdb($this->film)->getImdbId();
        $posters = collect($images->filterPosters()->toArray());
        $backdrops = collect($images->filterBackdrops()->toArray());

        $this->film->runtime = $runtime;
        $this->film->imdb_id = $imdb_id;

        $this->film->posters = $posters->map(function ($poster) {
            return tmdb_image()->getUrl($poster, 'w780');
        })->values();

        $this->film->backdrops = $backdrops->map(function ($backdrop) {
            return tmdb_image()->getUrl($backdrop, 'w1280');
        })->values();

        $this->film->save();

        $filmActions->downloadTmdbImages($this->film, $posters, 'poster');
        $filmActions->downloadTmdbImages($this->film, $backdrops, 'backdrop');

        ProcessFilmPoster::dispatch($film)->delay(
            now()->addMinutes(2)
        );
    }
}
