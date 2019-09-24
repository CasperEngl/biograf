<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, HasMediaTrait, HasSlug, HasRoles;

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

    public function avatar()
    {
        return asset(
            optional($this->getFirstMedia('avatar'))->getUrl('thumb') ?:
            'images/placeholder.jpg'
        );
    }

    public function getNameAttribute($value)
    {
        return ucwords("{$this->firstname} {$this->lastname}");
    }
}
