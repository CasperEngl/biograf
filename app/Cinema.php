<?php

namespace App;

use App\Reservation;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    protected $casts = [
        'rows' => 'integer',
        'columns' => 'integer',
    ];

    public function users()
    {
        return $this->hasManyThrough(User::class, Reservation::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function getNameAttribute()
    {
        return ucwords($this->name);
    }
}
