<?php

namespace App\Http\Controllers;

use App\Film;
use App\Showing;
use Illuminate\Http\Request;
use App\Actions\ShowingActions;

class ShowingController extends Controller
{
    public function __construct(Showing $showing, Film $film)
    {
        $this->showing = $showing;
        $this->film = $film;
    }

    public function index(Request $request)
    {
        // TODO: Find out how to get all films with their showing and view it
        $films = $this->film->all();

        return view('showing.index', [
            'films' => $films,
            'date' => \Carbon\Carbon::parse($request->date),
        ]);
    }

    public function show(Request $request)
    {
        return $this->showing->find($request->showing);
    }
}
