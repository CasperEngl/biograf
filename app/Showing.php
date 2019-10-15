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
        'date',
        'start',
        'end',
    ];

    public function setStartAttribute($value)
    {
        $this->attributes['start'] = getNearestTimeRoundedUpWithMinimum($value, 5);
    }

    public function getStartTimeAttribute()
    {
        return $this->start->toLocaleString();
    }
    
    public function getEndTimeAttribute()
    {
        return $this->start->addMinutes($this->film->runtime);
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
