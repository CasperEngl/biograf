<?php

namespace App;

use App\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cinema extends Model
{
    use SoftDeletes;
    
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
}
