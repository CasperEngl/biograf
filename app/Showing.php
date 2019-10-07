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
        'date' => 'datetime:Y-m-d',
        'start' => 'datetime:Y-m-d',
        'end' => 'datetime:Y-m-d',
    ];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    public function getStartTimeAttribute()
    {
        return \Carbon\Carbon::instance($this->start)->toLocaleString();
    }
}
