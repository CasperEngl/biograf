<?php

namespace App\ViewModels;

use App\Cinema;
use Spatie\ViewModels\ViewModel;

class CinemaViewModel extends ViewModel
{
    /** @var \App\Cinema */
    public $cinema;

    public function __construct(Cinema $cinema = null)
    {
        $this->cinema = $cinema;
    }

    public function cinema()
    {
        return $this->cinema ?? new Cinema;
    }
}
