<?php

namespace App;

use App\Genre;
use App\Showing;
use App\FilmCast;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Film extends Model implements HasMedia
{
    use HasMediaTrait, HasSlug, HasTranslations, SoftDeletes;

    public $translatable = ['title', 'overview', 'homepage'];
    
    protected $fillable = [
        'tmdb_id',
        'imdb_id',
        'category',
        'title',
        'language',
        'overview',
    ];

    protected $casts = [
        'tmdb_id' => 'integer',
        'imdb_id' => 'integer',
        'colors' => 'collection',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('poster');
        $this->addMediaCollection('backdrop');
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
        return $this->hasMany(FilmCast::class)->orderBy('order', 'asc');
    }

    public function showings()
    {
        return $this->hasMany(Showing::class);
    }

    public function todaysShowings()
    {
        return collect($this->showings)->filter(function ($showing) {
            return $showing->start->startOfDay()->eq(now()->startOfDay());
        });
    }
}
