<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'firstname' => 'Casper',
            'lastname' => 'Engelmann',
            'email' => 'me@casperengelmann.com',
            'phonenumber' => '40413916',
            'password' => bcrypt('1234'),
        ]);
        
        factory(App\User::class, 10)->create();
    }
}
