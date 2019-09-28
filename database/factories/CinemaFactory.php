<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cinema;
use Faker\Generator as Faker;

$factory->define(Cinema::class, function (Faker $faker) {
    return [
        'name' => 'Sal ' . $faker->unique()->numberBetween(1, 30),
        'row_count' => $faker->numberBetween(3, 20),
        'column_count' => $faker->numberBetween(5, 20),
    ];
});
