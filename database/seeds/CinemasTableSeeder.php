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
        factory(App\Cinema::class, 5)->create()->each(function ($cinema) {
            for ($rowIndex = 0; $rowIndex < $cinema->row_count; $rowIndex++) {
                for ($columnIndex = 0; $columnIndex < $cinema->column_count; $columnIndex++) {
                    $seat = factory(App\Seat::class)->make([
                        'cinema_id' => $cinema->getKey(),
                        'row' => App\Seat::ROW_IDS[$rowIndex],
                        'column' => $columnIndex,
                        'disability' => false,
                    ]);
                    
                    $cinema->seats()->save($seat);

                    // if ($rowIndex / 12 > 1) {
                    //     $seats = ceil($columnIndex / ($rowIndex / 12));
                        
                    //     if ($seats % 2 == 1) {
                    //         $seats--;

                    //         $seats = ($cinema->column_count - $seats) / 2;

                    //         $cinema->seats()->withTrashed()->where('row', App\Seat::ROW_IDS[$rowIndex])->take($seats)->delete();
                    //         $cinema->seats()->withTrashed()->latest()->where('row', App\Seat::ROW_IDS[$rowIndex])->take($seats)->delete();
                    //     }
                    // }
                }
            }
        });
    }
}
