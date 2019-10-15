<?php

namespace App\Http\Controllers\PaymentController;

use App\Reservation;
use Illuminate\Http\Request;
use App\Payment\PaymentGateway;
use App\Http\Controllers\Controller;
use App\Events\ReservationPaid;
use App\Events\ReservationCancelled;

class ReservationPaymentController extends Controller
{
    protected $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function index(Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        $paymentLink = $this->paymentGateway
            ->setPayable($reservation)
            ->getPaymentLink();

        return redirect($paymentLink);
    }

    public function success(Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        if ($reservation->paymentAuthorized()) {
            $reservation->setStatus(Reservation::PAID);

            $reservation->transactions->last()->update(
                [
                    'status' => 'approved',
                ]
            );

            event(new ReservationPaid($reservation));

            return redirect()
                ->route(
                    'reservation.overview.show',
                    $reservation
                )
                ->with(
                    'status.success',
                    'Betaling Gennemført!'
                );
        }
    }

    public function cancel(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);

        $reservation->setStatus(Reservation::CANCELLED);

        $reservation->transactions->last()->update(
            [
                'status' => 'failed',
            ]
        );

        event(new ReservationCancelled($reservation));

        return redirect()
            ->route(
                'reservation.overview.show',
                $reservation
            )
            ->with(
                'status.info',
                'Betaling annulleret!'
            );
    }

    public function callback(Reservation $reservation)
    {
        // Callback from QuickPay
        $callback_body = file_get_contents("php://input");
        $transaction   = json_decode($callback_body);

        // TODO: Handle transaction JSON data
    }
}
