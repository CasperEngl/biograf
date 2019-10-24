<?php

namespace App\Http\Controllers;

use App\Showing;
use App\Reservation;
use Illuminate\Http\Request;
use App\Actions\ShowingActions;
use App\Http\Requests\ReserveSeatsRequest;

class ReservationController extends Controller
{
    public function store(Showing $showing, ReserveSeatsRequest $request)
    {
        $data = collect([
            'seats' => collect($request->seats),
            'ticket_count' => collect($request->ticket_count),
            'email' => auth()->user()->email ?? $request->email,
        ]);

        $reservation = (new ShowingActions)->reserveSeats(
            $showing,
            $data,
        );

        event(new \App\Events\ReservationUpdated($reservation));

        return $reservation;
    }

    public function show(Reservation $reservation)
    {
        return view('reservation.overview.show', compact('reservation'));
    }

    public function finalize(Showing $showing)
    {
        $reservation = $showing
            ->reservations
            ->where(
                'reserver_id',
                auth()->id() ?? session()->getId(),
            )
            ->first();

        return redirect()->route('reservation.payment.index', compact('reservation'));
    }
}
