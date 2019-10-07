<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Showing;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Showing::class, function (Faker $faker) {
    $date = $faker->dateTimeBetween(now(), now()->addDays(30));

    return [
        'cinema_id' => App\Cinema::all()->random(),
        'film_id' => App\Film::all()->random(),
        'price' => 10000,
        'date' => Carbon::instance($date),
        'start' => Carbon::instance($date)->addHours(4),
        'end' => Carbon::instance($date)->addHours(6),
    ];
});
