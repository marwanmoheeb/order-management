<?php

namespace App\Services;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Payment\PaymentResult;

class PaymentService
{
    protected $gateway;

    public function __construct(PaymentGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    public function initializePayment(Order $order, string $paymentMethod): PaymentResult
    {
        $amount = (float) $order->total;
        $options = [
            'order_id' => $order->id,
            'payment_method' => $paymentMethod,
        ];

        $initResult = $this->gateway->intializePayment($amount);
        $payment = Payment::create([
            'order_id' => $order->id,
            'gateway_payment_id' => $initResult->transactionId,
            'status' => Payment::STATUS_PENDING,
            'payment_method' => $paymentMethod,
            'amount' => $amount
        ]);

        return $initResult;
    }

    public function process(Order $order): PaymentResult
    {

        $payment = Payment::where('order_id', $order->id)->first();

        $processResult = $this->gateway->ProcessPayment(
            $payment->gateway_payment_id
        );

        if ($processResult->success) {
            $payment->update([
                'status' => Payment::STATUS_SUCCESSFUL,
                'gateway_payment_id' => $processResult->transactionId,
            ]);
            $order->status = Order::STATUS_COMPLETED;
            $order->save();
        } else {
            $payment->update(['status' => Payment::STATUS_FAILED]);
        }

        return $processResult;
    }
}
