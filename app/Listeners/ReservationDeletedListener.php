<?php

namespace App\Listeners;

use App\Events\ReservationDeleted;
use App\Mail\ReservationDeletedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservationDeletedListener
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
    public function handle(ReservationDeleted $event)
    {
        Mail::to($event->reservation->reserver_email)->send(new ReservationDeletedMail($event->reservation));
    }
}
