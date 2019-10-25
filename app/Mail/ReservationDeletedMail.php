<?php

namespace App\Mail;

use App\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservationDeletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = \App\User::find($this->reservation->reserver_id);

        return $this
            ->subject(trans('mail.reservation.deleted.subject') . ' - ' . config('app.name'))
            ->markdown(
                'mail.reservation.deleted',
                [
                    'reservation' => $this->reservation,
                    'name' => $user ? $user->firstname : '',
                ]
            );
    }
}
