<?php

namespace App;

use App\Film;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
        'tmdb_genre_id',
        'name',
    ];

    public function cinemas()
    {
        return $this->morphedByMany(Cinema::class, 'genreable');
    }

    public function films()
    {
        return $this->morphedByMany(Film::class, 'genreable');
    }

    public function genreable()
    {
        return $this->morphTo();
    }
}
