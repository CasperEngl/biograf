<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Seat;
use Faker\Generator as Faker;

$factory->define(Seat::class, function (Faker $faker) {
    return [
        'row' => $faker->randomElement(Seat::ROW_IDS),
        'column' => $faker->numberBetween(5, 20),
        'active' => $faker->boolean(90),
    ];
});
