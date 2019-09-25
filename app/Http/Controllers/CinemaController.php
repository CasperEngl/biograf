<?php

namespace App\Http\Controllers;

use App\Seat;
use App\Tmdb;
use Illuminate\Http\Request;
use App\Repositories\CinemaRepository;
use App\Http\Requests\CinemaStoreRequest;

class CinemaController extends Controller
{
    public function __construct(CinemaRepository $cinema, CinemaViewModel $cinemaModel, Seat $seat, Tmdb $tmdb)
    {
        $this->cinema = $cinema;
        $this->cinemaModel = $cinemaModel;
        $this->seat = $seat;
        $this->tmdbRepo = $tmdb->repository();

        $this->middleware('auth');
    }

    public function index()
    {
        return view('cinema.index', [
            'cinemas' => $this->cinema->all(),
        ]);
    }

    public function create()
    {
        return view('cinema.create');
    }

    public function edit()
    {
        return view('cinema.create')->with();
    }

    public function store(CinemaStoreRequest $request)
    {
        $cinema = $this->cinema::create($request);

        foreach ($request->seats as $seat) {
            $cinema->seats()->save(new Seat($seat));
        }

        return redirect()->route('cinema.index');
    }

    public function update(CinemaStoreRequest $request)
    {
        $this->cinema::update($request);
    }
}
