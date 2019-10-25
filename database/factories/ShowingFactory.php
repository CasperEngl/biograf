<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Showing;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Showing::class, function (Faker $faker) {
    $morning = Carbon::create(now()->year, now()->month, now()->day, 8, 0, 0); //set time to 08:00
    $evening = Carbon::create(now()->year, now()->month, now()->day, 16, 0, 0); //set time to 16:00

    if (now()->between($morning, $evening, true)) {
        $date = $faker->dateTimeBetween(now(), now()->addDays(30));
    } else {
        $date = $faker->dateTimeBetween($morning, now()->addDays(30));
    }

    return [
        'cinema_id' => App\Cinema::all()->random(),
        'film_id' => App\Film::all()->random(),
        'version' => $faker->randomElement(Showing::VERSIONS),
        'price' => 10000,
        'multiplier' => collect([
            'regular' => 1,
            'senior' => 0.9,
        ]),
        'start' => Carbon::instance($date),
    ];
});
