<?php

namespace App\Actions;

use App\Film;
use App\User;
use App\Reservation;
use Illuminate\Support\Collection;
use App\Payment\Models\Transaction;

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

    public function reservations(User $user): Collection
    {
        return Reservation::where('reserver_id', $user->id)->with('transactions')->get();
    }

    public function pastFilmReservations(User $user, Film $film)
    {
        return Reservation::where('reserver_id', $user->id ?? session()->getId())
            ->with([
                'showing.film' => function ($query) use ($film) {
                    return $query->where('id', $film->getKey());
                }
            ])
            ->get()
            ->filter(function ($reservation) {
                return $reservation->showing->end->isPast();
            });
    }

    public function assertTicketAndSeatCountEqual(Reservation $reservation)
    {
        $ticket_count = $reservation->ticket_count->reduce(function ($acc, $cv) {
            return $acc + $cv;
        });

        $seat_count = $reservation->seats->count();

        if ($ticket_count !== $seat_count) {
            throw new \Exception(trans('reservation.status.error.ticket_seat_count'));
        }
    }

    public function you(Reservation $reservation)
    {
        $id = $reservation->reserver_id;

        if ($id == session()->getId()) {
            return true;
        }

        if (auth()->check() && $id == auth()->id()) {
            return true;
        }

        return false;
    }
}
