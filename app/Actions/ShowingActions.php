<?php

namespace App\Actions;

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
}
