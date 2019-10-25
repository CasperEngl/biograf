<?php

namespace App\Payment\Gateways\Quickpay;

use QuickPay\QuickPay;
use QuickPay\API\Exception;
use App\Payment\PayableInterface;
use App\Payment\Models\Transaction;
use Illuminate\Support\Facades\Log;
use App\Payment\PaymentGateway as PaymentGatewayInterface;

class PaymentGateway implements PaymentGatewayInterface
{
    protected $payableItem;

    protected $client;

    public function __construct()
    {
        try {
            $this->client = new QuickPay(':' . env('QUICKPAY_API_KEY'));
        } catch (Exception $e) {
            Log::emergency($e);
        }
    }


    public function setPayable(PayableInterface $payableItem)
    {
        $this->payableItem = $payableItem;

        return $this;
    }


    public function getPaymentLink()
    {
        if (!$payment = $this->getPayment()) {
            $payment = $this->createPayment();
        }

        $payment_status =
            $this->getPaymentResult() === self::PAYMENT_RESULT_OK &&
            optional($this->payableItem->fresh()->transactions->last())->status === 'approved';

        if ($payment_status) {
            return $this->payableItem->getContinueUrl();
        }

        $response = $this->client->request->put(
            sprintf('/payments/%s/link', $payment['id']),
            [
                'amount' => $this->payableItem->getPaymentAmount(),
                'continue_url' => $this->payableItem->getContinueUrl(),
                'cancel_url' => $this->payableItem->getCancelUrl(),
                'callback_url' => $this->payableItem->getCallbackUrl(),
            ]
        )->asArray();

        optional($this->payableItem->fresh()->transactions->last())->update(
            [
                'payment_link' => $response['url'],
            ]
        );

        return $response['url'];
    }


    public function handeCallback()
    {
        $callback_body = file_get_contents("php://input");
        $transaction   = json_decode($callback_body);

        return $this->validateCallback($callback_body);
    }

    public function validateCallback($response_body)
    {
        if (!isset($_SERVER["HTTP_QUICKPAY_CHECKSUM_SHA256"])) {
            return false;
        }

        return hash_hmac(
            'sha256',
            $response_body,
            env('QUICKPAY_PRIVATE_KEY')
        ) == $_SERVER["HTTP_QUICKPAY_CHECKSUM_SHA256"];
    }


    public function getPayment()
    {
        $payment = $this->getPayments(
            [
                'order_id' => $this->payableItem->getTransactionId()
            ]
        );

        return (!empty($payment) && isset($payment[0])) ? $payment[0] : false;
    }


    public function getPayments($query = [])
    {
        return $this->client->request->get('/payments', $query)->asArray();
    }


    public function getPaymentResult()
    {
        $payment = $this->getPayment() ?? [];

        if (!isset($payment['operations'])) {
            return self::PAYMENT_RESULT_FAILED;
        }

        $operation = end($payment['operations']);

        switch ($operation['qp_status_code']) {
            case '20000':
                $paymentResult = self::PAYMENT_RESULT_OK;
                break;
            case '40000':
                $paymentResult = self::PAYMENT_RESULT_CANCELED;
                break;
                
            default:
                $paymentResult = self::PAYMENT_RESULT_FAILED;
        }

        return $paymentResult;
    }

    public function createPayment()
    {
        $response = $this->client->request->post('/payments', $this->preparePayment());

        if (201 === $response->httpStatus()) {
            $payment = $response->asArray();

            if ($this->payableItem->transactions->isNotEmpty()) {
                $transaction = $this->payableItem->transactions->last();
            } else {
                $transaction = $this->payableItem->transactions()->save(new Transaction);
            }
        } else {
            list( $status, $headers, $response ) = $response->asRaw();
            throw new Exception($response);
        }

        return $payment;
    }

    public function preparePayment()
    {
        return array(
            'order_id' => $this->payableItem->getTransactionId(),
            'currency' => "DKK",
            //'text_on_statement' => $this->payableItem->getStatement(),
            'invoice_address' => [
                'email' => $this->payableItem->getCustomerEmail()
            ],
        );
    }
}
