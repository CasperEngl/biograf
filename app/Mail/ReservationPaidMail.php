<?php

namespace App\Mail;

use App\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservationPaidMail extends Mailable
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

        $reservation = $this->reservation;

        $barcodes = $reservation->seats->map(function ($seat) use ($reservation) {
            return \Storage::url('img/barcode/' . $reservation->getTransactionId() . '|' . $seat->label . '.png');
        });

        return $this
            ->subject(trans('mail.reservation.paid.subject') . ' - ' . config('app.name'))
            ->markdown(
                'mail.reservation.paid',
                [
                    'reservation' => $this->reservation,
                    'name' => $user ? $user->firstname : '',
                    'barcodes' => $barcodes,
                ]
            );
    }
}
