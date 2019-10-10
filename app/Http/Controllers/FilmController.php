<?php

namespace App\Http\Controllers;

use App\Film;
use App\Actions\FilmActions;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function __construct(Film $film, FilmActions $filmActions)
    {
        $this->film = $film;
        $this->filmActions = $filmActions;
    }

    public function index()
    {
        return $this->film->all();
    }

    public function show(Request $request)
    {
        $film = $this->film->where('slug', $request->slug)->firstOrFail();
        $siblings = $this->filmActions->siblings($film);

        return view('film.show', compact('film', 'siblings'));
    }
}
