<?php

namespace App\Payment;

interface PayableInterface
{
    /**
     * @return string
     */
    public function getCallbackUrl();

    /**
     * @return string
     */
    public function getContinueUrl();

    /**
     * @return string
     */
    public function getCancelUrl();

    /**
     * @return string
     */
    public function getTransactionId();
    
    /**
     * Should be in danish cents for most payments providers.
     *
     * @return int
     */
    public function getPaymentAmount();

    /**
     * @return string
     */
    public function getPaymentDescription();

    /**
     * @return string
     */
    public function getCustomerEmail();

    /**
     * @return string
     */
    public function getCustomerLanguage();
}
