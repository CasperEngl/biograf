<?php

namespace App\Http\Controllers;

use App\Reservation;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateReservationEmailRequest;

class ReservationUpdateController extends Controller
{
    public function index(Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        return view('reservation.update.email', compact('reservation'));
    }

    public function store(Reservation $reservation, UpdateReservationEmailRequest $request)
    {
        $this->authorize('update', $reservation);

        $reservation->update([
            'reserver_email' => $request->email,
            'is_guest' => true,
        ]);

        if ($request->password) {
            $login_attempt = auth()->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if ($login_attempt) {
                $reservation->update([
                    'is_guest' => false,
                ]);
            }
        }

        return redirect()->route('reservation.finalize', [
            'showing' => $reservation->showing,
        ]);
    }
}
