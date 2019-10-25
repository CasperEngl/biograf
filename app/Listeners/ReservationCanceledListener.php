<?php

namespace App\Listeners;

use App\Events\ReservationCanceled;
use App\Mail\ReservationCanceledMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservationCanceledListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ReservationCanceled $event)
    {
        Mail::to($event->reservation->reserver_email)->send(new ReservationCanceledMail($event->reservation));

        $reservation->delete();
    }
}
