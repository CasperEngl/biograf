<?php

namespace App;

use App\Film;
use App\Seat;
use App\Cinema;
use App\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Showing extends Model
{
    use SoftDeletes;

    const VERSIONS = [
        '2D',
        '3D',
        'IMAX 2D',
        'IMAX 3D',
    ];

    protected $casts = [
        'price' => 'integer',
        'multiplier' => 'collection',
    ];

    protected $dates = [
        'start',
        'end',
    ];

    protected $appends = [
        // 'cinemaWithSeats',
    ];

    public function setStartAttribute($value)
    {
        $this->attributes['start'] = getNearestTimeRoundedUpWithMinimum(\Carbon\Carbon::parse($value), 5);
    }
    
    public function getEndAttribute()
    {
        return $this->start->addMinutes($this->film->runtime);
    }

    public function getCinemaWithSeatsAttribute()
    {
        return $this->cinemaWithSeats();
    }

    public function cinemaWithSeats()
    {
        // get() wraps up query builder
        // first() is used because get() returns a collection of one item
        $cinema = $this->cinema->first();

        $cinema->seats->map(function ($seat) {
            // Only attach the current reservation for this showing
            $seat->reservation = $seat->reservations
                ->filter(function ($reservation) {
                    return $reservation->showing_id === $this->getKey();
                })
                ->first();

            // Unset other reservations as they will not be needed
            unset($seat->reservations);

            return $seat;
        });

        return $cinema;
    }

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}
