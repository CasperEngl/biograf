<?php

namespace App;

use App\Genre;
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
            ->height(256)
            ->performOnCollections(['poster', 'backdrop']);
        
        $this
            ->addMediaConversion('small')
            ->width(512)
            ->height(512)
            ->performOnCollections(['poster', 'backdrop']);
        
        $this
            ->addMediaConversion('medium')
            ->width(1024)
            ->height(1024)
            ->performOnCollections(['poster', 'backdrop']);
        
        $this
            ->addMediaConversion('large')
            ->width(2048)
            ->height(2048)
            ->performOnCollections(['poster', 'backdrop']);
    }

    public function genres()
    {
        return $this->morphToMany(Genre::class, 'genreable');
    }

    public function casts()
    {
        return $this->hasMany(FilmCast::class)->orderBy('order', 'asc');
    }
}
