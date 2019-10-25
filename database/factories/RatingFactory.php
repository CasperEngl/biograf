<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use willvincent\Rateable\Rating;

$factory->define(Rating::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'rateable_type' => \App\Film::class,
        'rateable_id' => \App\Film::all()->random(),
        'rating' => $faker->numberBetween(1, 6),
        'title' => $faker->realText(50),
        'review' => $faker->realText($faker->numberBetween(150, 600)),
    ];
});
