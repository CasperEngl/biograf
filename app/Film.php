<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
        'tmdb_id',
        'imdb_id',
        'category',
        'title',
        'language',
        'overview',
    ];
}
