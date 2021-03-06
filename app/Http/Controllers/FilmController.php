<?php

namespace App\Http\Controllers;

use App\Film;
use App\Actions\FilmActions;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function __construct(Film $film)
    {
        $this->film = $film;
    }

    public function index()
    {
        $films = $this->film->all();

        return view('film.pick', compact('films'));
    }

    public function show(string $slug)
    {
        $film = $this->film->where('slug', $slug)->firstOrFail();
        $siblings = (new FilmActions)->siblings($film);

        return view('film.show', compact('film', 'siblings'));
    }
}
