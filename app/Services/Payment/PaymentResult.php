<?php

namespace App\Services\Payment;

class PaymentResult
{
    public $success;

    public $transactionId;

    public $message;

    public $raw;

    public function __construct(bool $success, ?string $transactionId = null, string $message = '', array $raw = [])
    {
        $this->success = $success;
        $this->transactionId = $transactionId;
        $this->message = $message;
        $this->raw = $raw;
    }

    public static function success(string $transactionId, string $message = 'Payment successful.', array $raw = []): self
    {
        return new self(true, $transactionId, $message, $raw);
    }

    public static function failure(string $message, array $raw = []): self
    {
        return new self(false, null, $message, $raw);
    }
}
