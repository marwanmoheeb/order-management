<?php

namespace App\Contracts;

use App\Services\Payment\PaymentResult;

interface PaymentGatewayInterface
{
 
    public function intializePayment(float $amount): PaymentResult;


    public function ProcessPayment(string $transactionId): PaymentResult;



}
