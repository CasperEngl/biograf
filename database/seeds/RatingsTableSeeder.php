<?php

use Illuminate\Database\Seeder;
use willvincent\Rateable\Rating;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Rating::class, 100)->create();
    }
}
