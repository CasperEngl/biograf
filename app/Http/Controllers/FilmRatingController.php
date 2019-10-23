<?php

namespace App\Http\Controllers;

use App\Film;
use Illuminate\Http\Request;
use willvincent\Rateable\Rating;
use App\Actions\ReservationActions;
use App\Http\Requests\FilmRatingStoreRequest;

class FilmRatingController extends Controller
{
    public function index(Film $film)
    {
        $previous_ratings = auth()
            ->user()
            ->ratings()
            ->where('rateable_type', Film::class)
            ->where('rateable_id', $film->getKey())
            ->count();

        if ($previous_ratings) {
            return redirect()->back()->with('status.error', trans('film_rating.status.index.error'));
        }

        return view('film.rating.index', compact('film'));
    }

    public function store(Film $film, FilmRatingStoreRequest $request)
    {
        $rating = new Rating;

        $rating->user_id = auth()->id() ?? 1;
        $rating->rating = $request->rating;
        $rating->title = $request->title;
        $rating->review = $request->review;

        $film->ratings()->save($rating);

        return redirect(
            route('film.show', ['slug' => $film->slug])
        )->with(
            'status.success',
            trans('film_rating.status.store.success')
        );
    }
}
