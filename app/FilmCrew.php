<?php

namespace App;

use App\Film;
use App\Contributor;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class FilmCrew extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = [
        'film_id',
        'contributor_id',
        'tmdb_credit_id',
        'department',
        'job',
        'order',
    ];

    protected $casts = [
        'film_id' => 'integer',
        'contributor_id' => 'integer',
        'tmdb_credit_id' => 'integer',
        'order' => 'integer',
    ];

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('profile')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this
            ->addMediaConversion('thumb')
            ->crop(Manipulations::CROP_CENTER, 100, 100);
    }

    public function contributor()
    {
        return $this->belongsTo(Contributor::class);
    }
    
    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}
