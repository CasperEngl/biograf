<?php

use Illuminate\Database\Seeder;

class CinemasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Cinema::class, 10)->create()->each(function ($cinema) {
            for ($rowIndex = 0; $rowIndex <= $cinema->row_count; $rowIndex++) {
                for ($columnIndex = 0; $columnIndex <= $cinema->row_count; $columnIndex++) {
                    $seat = factory(App\Seat::class)->make([
                        'cinema_id' => $cinema->getKey(),
                        'row' => App\Seat::ROW_IDS[$rowIndex],
                        'column' => $columnIndex,
                    ]);
                    
                    $cinema->seats()->save($seat);

                    if (90 < rand(0, 100)) {
                        $seat->delete();
                    }
                }
            }
        });
    }
}
