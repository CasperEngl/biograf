<?php

namespace App\Payment;

use App\Payment\PayableInterface;

interface PaymentGateway
{
    const PAYMENT_RESULT_OK = 'authorized';
    const PAYMENT_RESULT_DECLINED = 'declined';
    const PAYMENT_RESULT_CANCELLED = 'cancelled';
    const PAYMENT_RESULT_FAILED = 'failed';
    const PAYMENT_TIMED_OUT = 'timeout';

    public function setPayable(PayableInterface $order);

    public function getPaymentLink();

    public function getPayment();

    public function getPaymentResult();
}
