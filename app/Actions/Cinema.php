<?php

namespace App\Actions;

use App\Cinema as CinemaModel;

class Cinema
{
  public function rows(CinemaModel $cinema): object
  {
    return $cinema->seats->groupBy('row')->reverse();
  }
}