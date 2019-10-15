<?php

namespace App\Http\Controllers;

use App\Film;
use App\Seat;
use App\Showing;
use Carbon\Carbon;
use App\Reservation;
use Illuminate\Http\Request;
use App\Actions\ShowingActions;

class ShowingController extends Controller
{
    public function __construct(Film $film, Carbon $carbon)
    {
        $this->film = $film;
        $this->carbon = $carbon;
    }

    public function index(string $date)
    {
        $date = $this->carbon->parse($date);

        $films = $this->film->all()->map(function ($film) use ($date) {
            $film->showings = (new ShowingActions)->showingsOnDate($film->showings, $date)->sortBy('start');

            return $film;
        });

        $date = $date->toDateString();

        return view('showing.index', compact('films', 'date'));
    }

    public function show(string $date, Showing $showing)
    {
        $days = floor($showing->film->runtime / 1440) ?? 0;
        $hours = floor(($showing->film->runtime - $days * 1440) / 60) ?? 0;
        $minutes = $showing->film->runtime - ($days * 1440) - ($hours * 60) ?? 0;

        return view('showing.show', compact('showing', 'date', 'hours', 'minutes'));
    }
}
