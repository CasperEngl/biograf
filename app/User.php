<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\Image\Manipulations;
use willvincent\Rateable\Rating;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, HasMediaTrait, HasSlug, HasRoles, SoftDeletes;

    protected $guard_name = 'web';

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phonenumber',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'preferences' => 'json',
    ];

    protected $appends = [
        'name',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['firstname', 'lastname'])
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('profile')
            ->useFallbackUrl(\Storage::url('/img/placeholder/user.png'))
            ->useFallbackPath(public_path('/img/placeholder/user.png'))
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this
            ->addMediaConversion('tiny-thumb')
            ->crop(Manipulations::CROP_CENTER, 50, 50);
        
        $this
            ->addMediaConversion('thumb')
            ->crop(Manipulations::CROP_CENTER, 100, 100);
    }

    public function setFirstnameAttribute($value)
    {
        $this->attributes['firstname'] = ucwords($value);
    }

    public function setLastnameAttribute($value)
    {
        $this->attributes['lastname'] = ucwords($value);
    }

    public function getNameAttribute()
    {
        return isset($this->lastname) ?  ucwords("{$this->firstname} {$this->lastname}") : ucwords($this->firstname);
    }

    public function avatar()
    {
        return asset(
            optional($this->getFirstMedia('avatar'))->getUrl('thumb') ?:
            '/img/placeholder/user.png'
        );
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
