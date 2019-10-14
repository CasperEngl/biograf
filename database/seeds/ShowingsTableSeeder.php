<?php

use Illuminate\Database\Seeder;

class ShowingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        factory(App\Showing::class, 1000)->create();
    }
}
