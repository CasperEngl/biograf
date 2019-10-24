<?php

namespace App\Jobs;

use App\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CleanReservations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Reservation $reservation)
    {
        $reservation
            ->withTrashed()
            ->get()
            ->each(function ($reservation) {
                if (($reservation->trashed() || $reservation->end->isPast()) && !$reservation->isPaid) {
                    event(new \App\Events\ReservationUpdated($reservation));
                    
                    $reservation->forceDelete();
                }
            });
    }
}
