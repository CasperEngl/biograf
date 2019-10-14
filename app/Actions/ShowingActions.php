<?php

namespace App\Actions;

use App\Seat;
use App\Showing;
use App\Reservation;
use Illuminate\Support\Collection;

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

    public function calculatePrice(Showing $showing, Collection $ticket_count)
    {
        $price = 0;

        for ($i = 0; $i < (int) $ticket_count->get('regular'); $i++) {
            $price += $showing->price;
        }

        for ($i = 0; $i < (int) $ticket_count->get('senior'); $i++) {
            $price += $showing->price * $showing->senior_discount;
        }

        return price;
    }

    public function reserveSeats(Showing $showing, Collection $seats)
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
            ->each(function ($columns, $row) use ($showing) {
                collect($columns)->each(function ($_, $column) use ($showing, $row) {
                    $seat = Seat::where('row', $row)->where('column', $column)->firstOrFail();
                    $reservation = Reservation::firstOrCreate(
                        [
                            'showing_id' => $showing->id,
                            'seat_id' => $seat->id,
                        ],
                        [
                            'user_id' => auth()->id(),
                            'end' => now()->addMinutes(10),
                        ],
                    );
    
                    $seat->reservation()->save($reservation);
                });
            });
    }
}
