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
            'firstname' => 'Anonymous',
            'email' => 'anonymous@' . parse_url(env('APP_URL'))['host'],
            'phonenumber' => '00000000',
            'password' => bcrypt(env('ANONYMOUS_PASS')),
        ]);
        
        factory(App\User::class)->create([
            'firstname' => 'Casper',
            'lastname' => 'Engelmann',
            'email' => 'me@casperengelmann.com',
            'phonenumber' => '40413916',
            'password' => bcrypt('1234'),
        ]);

        factory(App\User::class)->create([
            'email' => 'test1@biograf.test',
            'password' => bcrypt('kodeord123'),
        ]);

        factory(App\User::class)->create([
            'email' => 'test2@biograf.test',
            'password' => bcrypt('kodeord123'),
        ]);
        
        factory(App\User::class, 10)->create();
    }
}
