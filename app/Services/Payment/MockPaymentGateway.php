<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;

class MockPaymentGateway implements PaymentGatewayInterface
{
    public function intializePayment(float $amount): PaymentResult
    {
        $transactionId = uniqid();

        return PaymentResult::success($transactionId, 'Payment initialized.');
    }

    public function ProcessPayment(string $transactionId): PaymentResult
    {
        return PaymentResult::success($transactionId, 'Payment processed.');
    }

}
