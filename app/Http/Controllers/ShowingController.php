<?php

namespace App\Http\Controllers;

use App\Film;
use App\Seat;
use App\Showing;
use Carbon\Carbon;
use App\Reservation;
use App\Actions\FilmActions;
use Illuminate\Http\Request;
use App\Actions\ShowingActions;
use App\Http\Requests\ShowingDatePickRequest;

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

    public function days(string $slug)
    {
        $film = $this->film->where('slug', $slug)->firstOrFail();
        $showing = (new FilmActions)->nextShowing($film);
        $showingDays = (new ShowingActions)->nextShowings($showing, 999)->groupBy(function ($showing) {
            return $showing->start->format('Y-m-d');
        });

        return view('showing.days', compact('film', 'showingDays'));
    }

    public function pick(ShowingDatePickRequest $request)
    {
        $days = generateSubsequentDates(now()->add(request('page', 1) * 12 - 12, 'days'), 12);
        $page = request('page', 1);
        $next = request('page', 1) + 1;
        $previous = request('page', 1) - 1;

        return view('showing.pick', compact('days', 'page', 'next', 'previous'));
    }
}
