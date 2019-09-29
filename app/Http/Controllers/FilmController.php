<?php

namespace App\Http\Controllers;

use App\Film;
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
        return $this->film->find($request->film);
    }
}
