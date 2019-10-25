<?php

namespace App\Listeners;

use App\Events\ReservationUpdated;
use App\Events\ReservationCanceled;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationCanceledMail;
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

        $event->reservation->delete();
        
        event(new ReservationUpdated($event->reservation));
    }
}
