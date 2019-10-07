<?php

namespace App;

use App\Film;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class FilmCast extends Model implements HasMedia
{
    use HasMediaTrait;

    public function registerMediaCollections()
    {
        $this->addMediaCollection('profile');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this
            ->addMediaConversion('thumb')
            ->crop(Manipulations::CROP_CENTER, 100, 100);
    }
    
    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}
