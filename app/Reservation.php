<?php

namespace App;

use App\Seat;
use App\User;
use App\Showing;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'showing_id',
        'seat_id',
        'user_id',
        'end',
    ];

    protected $casts = [
        'paid' => 'boolean',
    ];

    protected $dates = [
        'end'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function showing()
    {
        return $this->belongsTo(Showing::class);
    }
}
