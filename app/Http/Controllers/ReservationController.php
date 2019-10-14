<?php

namespace App\Http\Controllers;

use App\Showing;
use Illuminate\Http\Request;
use App\Actions\ShowingActions;

class ReservationController extends Controller
{
    public function __construct(ShowingActions $showingActions)
    {
        $this->showingActions = $showingActions;
    }

    public function store(string $date, Showing $showing, Request $request)
    {
        $this->showingActions->reserveSeats($showing, collect($request->seats), collect($request->ticket_count));

        return redirect()->route('reservation.pay');
    }

    public function pay()
    {
        $reservations = auth()->user()->reservations->where('paid', false)->groupBy('showing_id');

        return view('reservation.pay', compact('reservations'));
    }
}
