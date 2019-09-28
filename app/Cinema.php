<?php

namespace App;

use App\Reservation;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    protected $fillable = [
        'name',
        'row_count',
        'column_count',
    ];

    protected $casts = [
        'row_count' => 'integer',
        'column_count' => 'integer',
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
