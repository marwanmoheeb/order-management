<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESSFUL = 'successful';
    const STATUS_FAILED = 'failed';

    const METHOD_CREDIT_CARD = 'credit_card';
    const METHOD_PAYPAL = 'paypal';

    public static $statuses = [
        self::STATUS_PENDING,
        self::STATUS_SUCCESSFUL,
        self::STATUS_FAILED,
    ];

    public static $methods = [
        self::METHOD_CREDIT_CARD,
        self::METHOD_PAYPAL
    ];

    protected $fillable = [
        'order_id',
        'gateway_payment_id',
        'status',
        'payment_method',
        'amount',
        'currency',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
