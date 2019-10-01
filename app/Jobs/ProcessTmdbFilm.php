<?php

namespace App\Jobs;

use App\Film;
use Tmdb\Model\Movie;
use Illuminate\Bus\Queueable;
use App\Actions\FilmActions;
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

        $posters = collect($images->filterPosters()->toArray());
        $backdrops = collect($images->filterBackdrops()->toArray());

        $filmActions->downloadTmdbImages($this->film, $posters, 'poster');
        $filmActions->downloadTmdbImages($this->film, $backdrops, 'backdrop');
    }
}
