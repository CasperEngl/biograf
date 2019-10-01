<?php

namespace App\Http\Controllers;

use App\Film;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(Film $film)
    {
        $this->film = $film;
    }

    public function index()
    {
        $featured = $this->film->latest()->first();

        return view('home', compact('featured'));
    }
}
