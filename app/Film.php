<?php

namespace App;

use App\Genre;
use App\Showing;
use App\FilmCast;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use willvincent\Rateable\Rateable;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Film extends Model implements HasMedia
{
    use HasMediaTrait, HasSlug, HasTranslations, SoftDeletes, Rateable;

    public $translatable = ['title', 'overview', 'homepage'];
    
    protected $fillable = [
        'tmdb_id',
        'imdb_id',
        'categories',
        'title',
        'language',
        'overview',
    ];

    protected $casts = [
        'tmdb_id' => 'integer',
        'imdb_id' => 'integer',
        'runtime' => 'integer',
        'categories' => 'collection',
        'colors' => 'collection',
        'posters' => 'collection',
        'backdrops' => 'collection',
    ];

    protected $dates = [
        'premiere',
    ];

    protected $with = [
        'showings',
        'genres',
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function ($film) {
            $film->delete();
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('poster')
            ->useFallbackUrl(asset('img/placeholder/poster-medium.png'));

        $this
            ->addMediaCollection('backdrop')
            ->useFallbackUrl(asset('img/placeholder/backdrop-medium.png'));
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this
            ->addMediaConversion('thumb')
            ->width(256)
            ->height(256);
        
        $this
            ->addMediaConversion('small')
            ->width(512)
            ->height(512);
        
        $this
            ->addMediaConversion('medium')
            ->width(1024)
            ->height(1024);
        
        $this
            ->addMediaConversion('large')
            ->width(2048)
            ->height(2048);
    }

    public function genres()
    {
        return $this->morphToMany(Genre::class, 'genreable');
    }

    public function casts()
    {
        return $this->hasMany(FilmCast::class)->orderBy('order');
    }

    public function crews()
    {
        return $this->hasMany(FilmCrew::class)->orderBy('order');
    }

    public function showings()
    {
        return $this->hasMany(Showing::class);
    }

    public function ratings()
    {
        return $this->morphMany('willvincent\Rateable\Rating', 'rateable')->latest();
    }
}
