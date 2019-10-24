<?php

namespace App;

use App\Cinema;
use App\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model
{
    use SoftDeletes;
    
    const ROW_IDS = [
        'a',
        'b',
        'c',
        'd',
        'e',
        'f',
        'g',
        'h',
        'i',
        'j',
        'k',
        'l',
        'm',
        'n',
        'o',
        'p',
        'q',
        'r',
        's',
        't',
        'u',
        'v',
        'w',
        'x',
        'y',
        'z',
    ];

    protected $fillable = [
        'cinema_id',
        'row',
        'column',
        'disability',
    ];

    protected $casts = [
        'row' => 'string',
        'column' => 'integer',
    ];

    protected $appends = [
        'selected',
        'label',
    ];

    public function getLabelAttribute()
    {
        return "{$this->row}-{$this->column}";
    }

    public function getSelectedAttribute()
    {
        return $this->trashed() ? 1 : 0;
    }

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_to_seat');
    }
}
