<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Showing;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Showing::class, function (Faker $faker) {
    $morning = Carbon::create(now()->year, now()->month, now()->day, 8, 0, 0); //set time to 08:00
    $evening = Carbon::create(now()->year, now()->month, now()->day, 16, 0, 0); //set time to 16:00

    if(now()->between($morning, $evening, true)) {
        $date = $faker->dateTimeBetween(now(), now()->addDays(30));
    } else {
        $date = $faker->dateTimeBetween($morning, now()->addDays(30));
    }

    $versions = [
        '2D',
        '3D',
        'IMAX 2D',
        'IMAX 3D',
    ];

    return [
        'cinema_id' => App\Cinema::all()->random(),
        'film_id' => App\Film::all()->random(),
        'version' => $faker->randomElement($versions),
        'price' => 10000,
        'date' => Carbon::instance($date),
        'start' => Carbon::instance($date)->addHours(4),
        'end' => Carbon::instance($date)->addHours(6),
    ];
});
