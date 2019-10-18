<?php

namespace App\Actions;

use App\Film;
use App\Genre;
use App\Showing;
use App\FilmCast;
use App\FilmCrew;
use App\Contributor;
use App\Actions\FilmActions;
use App\Jobs\ProcessTmdbFilm;
use App\Jobs\ProcessFilmPoster;
use App\Jobs\ProcessContributor;
use League\ColorExtractor\Color;
use Illuminate\Support\Collection;
use League\ColorExtractor\Palette;
use League\ColorExtractor\ColorExtractor;

class FilmActions
{
    public function import($movie, string $category)
    {
        echo $movie->getTitle();
        echo "\n";

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

        echo '  Adding translations ';
        echo $this->addTranslations($film, $movie, collect($this->tmdb($film)->getTranslations())) ? '✅' : '🚫';
        echo "\n";
        
        echo '  Adding genres ';
        echo $this->addGenres($film, collect($this->tmdb($film)->getGenres())) ? '✅' : '🚫';
        echo "\n";
        
        echo '  Adding cast ';
        echo $this->addCast($film, collect($this->tmdb($film)->getCredits()->getCast())) ? '✅' : '🚫';
        echo "\n";
        
        echo '  Adding crew ';
        echo $this->addCrew($film, collect($this->tmdb($film)->getCredits()->getCrew())) ? '✅' : '🚫';
        echo "\n";

        // Save translations
        $film->save();

        // Process images from TMDB which are then added to
        // the film with $this->downloadTmdbImages
        ProcessTmdbFilm::dispatch($film, $movie);
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

        if (collect($trailers)->first()) {
            return collect($trailers)->first()->getKey();
        }

        return null;
    }

    public function addTranslations(Film $film, $movie, Collection $translations)
    {
        try {
            $translations->each(
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

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function addGenres(Film $film, Collection $genres)
    {
        try {
            $genres->each(
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

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function addCast(Film $film, Collection $casts)
    {
        try {
            $casts->each(
                function ($cast) use ($film) {
                    $contributor = Contributor::updateOrCreate(
                        [
                            'tmdb_id' => $cast->getId(),
                        ],
                        [
                            'name' => $cast->getName(),
                        ],
                    );
    
                    $filmcast = FilmCast::updateOrCreate(
                        [
                            'tmdb_credit_id' => $cast->getCreditId(),
                        ],
                        [
                            'film_id' => $film->getKey(),
                            'contributor_id' => $contributor->getKey(),
                            'tmdb_cast_id' => $cast->getCastId(),
                            'character' => $cast->getCharacter(),
                            'order' => $cast->getOrder(),
                        ],
                    );
    
                    $contributor->filmCasts()->save($filmcast);
                    $film->casts()->save($filmcast);
                    
                    ProcessContributor::dispatch($cast, $contributor, $filmcast);
                }
            );

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function addCrew(Film $film, Collection $crews)
    {
        try {
            $crews->each(
                function ($crew) use ($film) {
                    $contributor = Contributor::updateOrCreate(
                        [
                            'tmdb_id' => $crew->getId(),
                        ],
                        [
                            'name' => $crew->getName(),
                        ],
                    );
    
                    $filmcrew = FilmCrew::updateOrCreate(
                        [
                            'tmdb_credit_id' => $crew->getCreditId(),
                        ],
                        [
                            'film_id' => $film->getKey(),
                            'contributor_id' => $contributor->getKey(),
                            'department' => $crew->getDepartment(),
                            'job' => $crew->getJob(),
                            'order' => 0, // Crew doesn't have order
                        ],
                    );
    
                    $contributor->filmCrews()->save($filmcrew);
                    $film->casts()->save($filmcrew);
                    
                    ProcessContributor::dispatch($crew, $contributor, $filmcrew);
                }
            );

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function siblings(Film $film): Collection
    {
        $films = collect();

        if (Film::where('id', '<', $film->getKey())->orderBy('id', 'desc')->first()) {
            $films->put('previous', Film::where('id', '<', $film->getKey())->orderBy('id', 'desc')->first());
        }

        if (Film::where('id', '>', $film->getKey())->orderBy('id')->first()) {
            $films->put('next', Film::where('id', '>', $film->getKey())->orderBy('id')->first());
        }

        return $films;
    }

    public function nextShowing(Film $film)
    {
        $showing = Showing::where('film_id', $film->getKey())->orderBy('start')->first();

        return $showing;
    }
}
