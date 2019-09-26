<?php

namespace App\Http\Controllers;

use App\Seat;
use App\Tmdb;
use App\Cinema;
use Illuminate\Http\Request;
use App\ViewModels\CinemaViewModel;
use App\Repositories\CinemaRepository;
use App\Http\Requests\CinemaStoreRequest;

class CinemaController extends Controller
{
    public function __construct(CinemaRepository $cinema)
    {
        $this->cinema = $cinema;

        $this->middleware('auth');
    }

    public function index()
    {
        return view('cinema.index', [
            'cinemas' => $this->cinema->all(),
        ]);
    }

    public function edit(Cinema $cinema)
    {
        return dd($cinema);
    }
}
