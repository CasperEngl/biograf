<?php

namespace App\Actions;

use App\Seat;
use App\Showing;
use App\Reservation;
use Illuminate\Support\Collection;
use App\Actions\ReservationActions;

class ShowingActions
{
    public function screenSizes(Collection $films, Collection $sizes)
    {
        return $sizes->map(function ($size) use ($films) {
            $collection = collect([]);

            for ($i = 1; $i <= $size; $i++) {
                $collection->push($films->nth($i));
            }

            return $collection;
        });
    }

    public function showingsOnDate(Collection $showings, \Carbon\Carbon $date): Collection
    {
        return collect($showings)->filter(function ($showing) use ($date) {
            return $showing->start->startOfDay()->eq($date->startOfDay());
        });
    }

    public function reserveSeats(Showing $showing, Collection $data)
    {
        Reservation::where('reserver_id', auth()->id() ?? session()->getId())
            ->get()
            ->filter(function ($reservation) {
                return $reservation->status === Reservation::PENDING;
            })
            ->each
            ->delete();

        $reservation = Reservation::create(
            [
                'showing_id' => $showing->getKey(),
                'reserver_id' => auth()->id() ?? session()->getId(),
                'reserver_email' => $data->get('email'),
                'ticket_count' => $data->get('ticket_count'),
                'end' => now()->addMinutes(10),
                'is_guest' => auth()->check() ? false : true,
            ],
        );

        $data->get('seats')
            ->each(function ($seat, $row) use ($showing, $reservation) {
                $seat = (object) $seat;

                $seat = Seat::where('cinema_id', $showing->cinema()->getKey())
                    ->where('row', $seat->row)
                    ->where('column', $seat->column)
                    ->firstOrFail();

                $reservation->seats()->save($seat);
            });

        return Reservation::where('reserver_id', auth()->id() ?? session()->getId())->latest()->first();
    }

    public function nextShowings(Showing $showing, $count = 1)
    {
        return Showing::where('film_id', $showing->film->getKey())
            ->where('start', '>', $showing->start)
            ->orderBy('start')
            ->take($count)
            ->get();
    }
}
