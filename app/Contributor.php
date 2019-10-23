<?php

namespace App;

use App\FilmCast;
use App\FilmCrew;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Contributor extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = [
        'tmdb_id',
        'name',
    ];

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('profile')
            ->useFallbackUrl('/img/placeholder/user.png')
            ->useFallbackPath(public_path('/img/placeholder/user.png'))
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this
            ->addMediaConversion('thumb')
            ->crop(Manipulations::CROP_CENTER, 100, 100);
    }

    public function getTmdbLinkAttribute()
    {
        return sprintf('https://www.themoviedb.org/person/%s', $this->tmdb_id);
    }

    public function filmCrews()
    {
        return $this->hasMany(FilmCrew::class);
    }

    public function filmCasts()
    {
        return $this->hasMany(FilmCast::class);
    }
}
