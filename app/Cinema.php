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

    protected $fillable = [
        'name',
        'rows',
        'columns',
    ];

    public function users()
    {
        return $this->hasManyThrough(User::class, Reservation::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function rows()
    {        
        return $this->seats->groupBy('row')->reverse();
    }
}
