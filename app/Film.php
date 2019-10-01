<?php

namespace App;

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
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->withResponsiveImages()
            ->width(150)
            ->height(150);
        
        $this->addMediaConversion('small')
            ->withResponsiveImages()
            ->width(450)
            ->height(450);
        
        $this->addMediaConversion('medium')
            ->withResponsiveImages()
            ->width(1024)
            ->height(1024);
        
        $this->addMediaConversion('large')
            ->withResponsiveImages()
            ->width(2048)
            ->height(2048);
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('poster');
        $this->addMediaCollection('backdrop');
    }

    public function genres()
    {
        return $this->morphToMany(Genre::class, 'genreable');
    }
}
