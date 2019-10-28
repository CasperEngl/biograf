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
            'email' => optional(auth()->user())->email,
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
        $this->authorize('view', $reservation);

        $barcodes = $reservation->seats->map(function ($seat) use ($reservation) {
            return $reservation->getTransactionId() . '|' . $seat->label . '.png';
        });
        
        return view('reservation.overview.show', compact('reservation', 'barcodes'));
    }

    public function finalize(Showing $showing)
    {
        $reservation = $showing
            ->reservations
            ->where(
                'reserver_id',
                auth()->id() ?? session()->getId(),
            )
            ->sortByDesc('end')
            ->first();

        if (!$reservation) {
            return redirect()->back()->with('status.error', trans('reservation.status.error.missing'));
        }

        if (!$reservation->reserver_email) {
            return redirect()->route('reservation.update.email.index', compact('reservation'));
        }

        return redirect()->route('reservation.payment.index', compact('reservation'));
    }
}
