<?php

namespace App\Actions;

use App\Film as FilmModel;

class Film
{
  public function importMany(array $films, string $category)
  {
    foreach ($films as $film) {
      FilmModel::updateOrCreate(
        [
            'tmdb_id' => $film->getId(),
            'category' => $category,
        ],
        [
            'imdb_id' => $film->getImdbId(),
            'title' => $film->getTitle(),
            'language' => $film->getOriginalLanguage(),
            'overview' => $film->getOverview(),
        ],
      );
    }
  }
}