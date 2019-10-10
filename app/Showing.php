<?php

namespace App;

use App\Film;
use App\Cinema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Showing extends Model
{
    use SoftDeletes;

    protected $casts = [
        'price' => 'integer',
    ];

    protected $dates = [
        'date',
        'start',
        'end',
    ];

    public function getStartTimeAttribute()
    {
        return $this->start->toLocaleString();
    }
    
    public function getEndTimeAttribute()
    {
        return $this->end->toLocaleString();
    }

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}
