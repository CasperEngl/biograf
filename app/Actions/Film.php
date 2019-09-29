<?php

namespace App\Actions;

use App\Genre;
use App\Film as FilmModel;
use App\Jobs\ProcessTmdbFilm;

class Film
{
    public function importMany(array $movies, string $category)
    {
        foreach ($movies as $movie) {
            $film = FilmModel::updateOrCreate(
                [
                    'tmdb_id' => $movie->getId(),
                    'category' => $category,
                ],
                [
                    'imdb_id' => $movie->getImdbId(),
                    'title' => $movie->getTitle(),
                    'language' => $movie->getOriginalLanguage(),
                    'overview' => $movie->getOverview(),
                ],
            );

            $film->genres()->detach();

            foreach ($movie->getGenres()->toArray() as $genre) {
                if ($genre->getName()) {
                    $genre = Genre::firstOrCreate(['name' => $genre->getName()]);

                    $film->genres()->attach($genre);
                }
            }

            ProcessTmdbFilm::dispatch($film, $movie);
        }
    }

    public function downloadTmdbImage(FilmModel $film, string $path, string $collection)
    {
        if (! count($film->getMedia($collection))) {
            $poster_url = 'http://image.tmdb.org/t/p/original' . $path;
            
            $file = file_get_contents($poster_url);

            $temp = tempnam(sys_get_temp_dir(), $collection);

            $save = file_put_contents($temp, fopen($poster_url, 'r'));

            if ($save) {
                $film
                    ->addMedia($temp)
                    ->toMediaCollection($collection);
            }
        }
    }
}