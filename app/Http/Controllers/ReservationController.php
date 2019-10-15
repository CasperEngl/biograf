<?php

namespace App\Http\Controllers;

use App\Showing;
use App\Reservation;
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
        $reservation = $this->showingActions->reserveSeats(
            $showing,
            collect($request->seats),
            collect($request->ticket_count)
        );

        return redirect()->route('reservation.payment.index', $reservation);
    }

    public function show(Reservation $reservation)
    {
        return view('reservation.overview.show', compact('reservation'));
    }
}
