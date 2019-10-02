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
        return $this->film->all();
    }

    public function show(Request $request)
    {
        $film = $this->film->findOrFail($request->film);

        return view('film.show', compact('film'));
    }
}
