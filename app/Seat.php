<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'cinema_id',
        'row',
        'column',
        'active',
    ];

    public function reservation()
    {
        return $this->hasOne(Reservation::class);
    }
}
