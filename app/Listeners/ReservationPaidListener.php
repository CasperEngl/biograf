<?php

namespace App\Listeners;

use App\Events\ReservationPaid;
use App\Mail\ReservationPaidMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservationPaidListener
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
    public function handle(ReservationPaid $event)
    {
        Mail::to($event->reservation->reserver_email)->send(new ReservationPaidMail($event->reservation));
    }
}
