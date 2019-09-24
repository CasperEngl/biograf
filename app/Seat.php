<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    public function reservation()
    {
        return $this->hasOne(Reservation::class);
    }
}
