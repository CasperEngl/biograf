<?php

namespace App\Actions;

use App\Cinema;

class CinemaActions
{
    public function rows(Cinema $cinema): object
    {
        return $cinema->seats->groupBy('row')->reverse();
    }
}
