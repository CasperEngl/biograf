<?php

namespace App;

use App\Cinema;
use App\Reservation;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    const ROW_IDS = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

    protected $fillable = [
        'cinema_id',
        'row',
        'column',
        'active',
    ];

    protected $casts = [
        'row' => 'string',
        'column' => 'integer',
        'active' => 'boolean',
    ];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function reservation()
    {
        return $this->hasOne(Reservation::class);
    }
}
