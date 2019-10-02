<?php

namespace App\Actions;

use App\Film;
use App\Genre;
use App\FilmCast;
use App\Actions\FilmActions;
use App\Jobs\ProcessTmdbFilm;
use App\Jobs\ProcessFilmPoster;
use League\ColorExtractor\Color;
use Illuminate\Support\Collection;
use League\ColorExtractor\Palette;
use League\ColorExtractor\ColorExtractor;

class FilmActions
{
    public function importMany(array $movies, string $category)
    {
        foreach ($movies as $movie) {
            // Only echo the title of the movie if it has not been imported before
            if (! Film::where(
                'title->en',
                $movie->getTitle()
            )->get()->count()) {
                echo $movie->getTitle();
                echo "\n";
            }

            // All TMDB movie data must be accessed with getters
            $film = Film::updateOrCreate(
                [
                    'tmdb_id' => $movie->getId(),
                    'category' => $category,
                ],
                [
                    'imdb_id' => $movie->getImdbId(),
                    'title' => $movie->getTitle(),
                    'language' => $movie->getOriginalLanguage(),
                    'overview' => $movie->getOverview(),
                    'homepage' => $movie->getHomepage() ?? 'https://themoviedb.org',
                ],
            );

            // Make sure the original language title exists
            $film->setTranslation('title', $movie->getOriginalLanguage(), $movie->getTitle());

            // Go over each translation and add them to the film
            collect((new FilmActions)->tmdb($film)->getTranslations())
                ->each(
                    function ($translation) use ($film, $movie) {
                        // Data is array form, so we cast it to object
                        // for readability with our other code
                        $data = (object) $translation->getData();

                        // Set title, overview and homepage according
                        // to translation entries
                        $film->setTranslation(
                            'title',
                            $translation->getIso6391(),
                            empty($data->title)
                                ? $movie->getTitle()
                                : $data->title
                        );
                        $film->setTranslation(
                            'overview',
                            $translation->getIso6391(),
                            empty($data->overview)
                                ? $movie->getOverview()
                                : $data->overview
                        );
                        $film->setTranslation(
                            'homepage',
                            $translation->getIso6391(),
                            empty($data->homepage)
                                ? $movie->getHomepage() ?? 'https://themoviedb.org'
                                : $data->homepage
                        );
                    }
                );

            // Go over each genre and add them to the film
            collect((new FilmActions)->tmdb($film)->getGenres())
                ->each(
                    function ($genre) use ($film) {
                        // Find the genre in database from genre id
                        $genre = Genre::where(
                            'tmdb_genre_id',
                            $genre->getId()
                        )->firstOrFail(); // Get the first match
    
                        // Attach the genre found in database to film genres
                        $film->genres()->attach($genre);
                    }
                );
            
            collect((new FilmActions)->tmdb($film)->getCredits()->getCast())
                ->each(
                    function ($cast) use ($film) {
                        $filmcast = FilmCast::updateOrCreate(
                            [
                                'film_id' => $film->id,
                                'tmdb_credit_id' => $cast->getCreditId(),
                                'tmdb_cast_id' => $cast->getCastId(),
                                'tmdb_id' => $cast->getId(),
                            ],
                            [
                                'character' => $cast->getCharacter(),
                                'name' => $cast->getName(),
                                'order' => $cast->getOrder(),
                            ],
                        );

                        if ($cast->getProfilePath()) {
                            $filmcast
                                ->addMediaFromUrl('http:' . tmdb_image()->getUrl($cast->getProfilePath()))
                                ->toMediaCollection('profile');
                        }

                        $film->casts()->save($filmcast);
                    }
                );

            // Save translations
            $film->save();

            // Process images from TMDB which are then added to
            // the film with $this->downloadTmdbImages
            ProcessTmdbFilm::dispatch($film, $movie);
        }
    }

    public function downloadTmdbImages(
        Film $film,
        Collection $images,
        string $mediaCollection
    ) {
        // Don't add images if images already exist in the collection
        if (! count($film->getMedia($mediaCollection))) {
            foreach ($images as $image) {
                $film
                    ->addMediaFromUrl('http:' . tmdb_image()->getUrl($image)) // Add the image file
                    ->toMediaCollection($mediaCollection); // Add to the passed collection
            }

            ProcessFilmPoster::dispatch($film)->delay(
                now()->addMinutes(2)
            );
        }
    }

    public function tmdb(Film $film)
    {
        return tmdb_repo()->load($film->tmdb_id);
    }

    public function trailerKey(Film $film)
    {
        $trailers = tmdb_repo()->load($film->tmdb_id)->getVideos()->toArray();

        $key = collect($trailers)->first()->getKey();

        return $key;
    }
}
