<?php

namespace App;

use App\Payment\PaymentGateway;
use App\Payment\PayableInterface;
use App\Payment\Traits\HasPayable;
use App\Actions\ReservationActions;
use Spatie\ModelStatus\HasStatuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model implements PayableInterface
{
    use HasPayable, HasStatuses, SoftDeletes;

    const CANCELED = 'canceled';
    const PENDING = 'pending';
    const DENIED = 'denied';
    const PAID = 'paid';

    protected $fillable = [
        'showing_id',
        'cinema_id',
        'film_id',
        'reserver_id',
        'reserver_email',
        'payment_key',
        'ticket_count',
        'end',
        'is_guest',
    ];

    protected $casts = [
        'paid' => 'boolean',
        'ticket_count' => 'collection',
    ];

    protected $dates = [
        'end'
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function ($reservation) {
            $reservation->setStatus(self::PENDING);

            $reservation->update([
                'payment_key' => bin2hex(random_bytes(2))
            ]);
        });

        self::deleting(function ($reservation) {
            $reservation->setStatus(self::CANCELED);
        });

        self::restored(function ($reservation) {
            $reservation->setStatus(self::PENDING);
        });
    }

    public function showing()
    {
        return $this->belongsTo(Showing::class);
    }

    public function seats()
    {
        return $this->belongsToMany(Seat::class, 'reservation_to_seat');
    }

    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    public function getTransaction()
    {
        return $this->transactions->last();
    }

    public function getIsPaidAttribute()
    {
        return count($this->transactions)
            && $this->transactions->last()->status === 'approved'
            && $this->paymentAuthorized();
    }

    public function paymentAuthorized()
    {
        return resolve(PaymentGateway::class)->setPayable($this)->getPaymentResult() === 'authorized';
    }

    public function getCallbackUrl()
    {
        if (\App::environment('local')) {
            return '';
        }

        return route('reservation.payment.callback', $this);
    }

    public function getContinueUrl()
    {
        return route('reservation.payment.success', $this);
    }

    public function getCancelUrl()
    {
        return route('reservation.payment.cancel', $this);
    }

    public function getTransactionId()
    {
        if (! app()->environment('production')) {
            return $this->getTransactionIdSuffix();
        }

        return 'reservation-' . str_pad($this->getKey(), 8, 0, STR_PAD_LEFT);
    }

    public function getTransactionIdSuffix()
    {
        return sprintf('%s-%s', config('payment.suffix', 'unknown'), $this->payment_key);
    }

    public function getPaymentAmount()
    {
        return (new ReservationActions)->price($this);
    }

    public function getPaymentDescription()
    {
        return $this->service->serviceType->name;
    }

    public function getCustomerEmail()
    {
        return $this->reserver_email;
    }

    public function getCustomerLanguage()
    {
        return config('app.locale');
    }
}
