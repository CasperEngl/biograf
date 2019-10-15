<?php

namespace App\Actions;

use App\Reservation;

class ReservationActions
{
    public function price(Reservation $reservation)
    {
        try {
            $this->assertTicketAndSeatCountEqual($reservation);

            $price = $reservation->ticket_count
                ->map(function ($count, $key) use ($reservation) {
                    return $reservation->showing->price * $reservation->showing->multiplier->get($key) * $count;
                })
                ->reduce(function ($acc, $cv) {
                    return $acc + $cv;
                });

            return $price;
        } catch (\Throwable $th) {
            abort(back())->with('status.error', $th->getMessage());
        }
    }

    public function assertTicketAndSeatCountEqual(Reservation $reservation)
    {
        $ticket_count = $reservation->ticket_count->reduce(function ($acc, $cv) {
            return $acc + $cv;
        });

        $seat_count = $reservation->seats->count();

        if ($ticket_count !== $seat_count) {
            throw new \Exception(trans('reservation.error.ticket_seat_count'));
        }
    }
}
