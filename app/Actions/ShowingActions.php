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

    public function reserveSeats(Showing $showing, Collection $seats, Collection $ticket_count)
    {
        $seats = $seats
            ->map(function ($row) {
                return collect($row)->filter(function ($column) {
                    return (int) $column;
                })->all();
            })
            ->filter(function ($row) {
                return collect($row)->count();
            })
            ->each(function ($columns, $row) use ($showing, $ticket_count) {
                collect($columns)->each(function ($_, $column) use ($showing, $row, $ticket_count) {
                    $seat = Seat::where('cinema_id', $showing->cinema()->getKey())
                        ->where('row', $row)
                        ->where('column', $column)
                        ->firstOrFail();

                    $reservation = Reservation::firstOrCreate(
                        [
                            'showing_id' => $showing->getKey(),
                            'user_id' => auth()->id(),
                        ],
                        [
                            'end' => now()->addMinutes(10),
                            'ticket_count' => $ticket_count,
                        ],
                    );

                    $reservation->seats()->save($seat);
                });
            });

        return auth()->user()->reservations->last();
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
