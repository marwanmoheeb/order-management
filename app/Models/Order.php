<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';

    /** @var array */
    public static $statuses = [
        self::STATUS_PENDING,
        self::STATUS_PROCESSING,
        self::STATUS_CONFIRMED,
        self::STATUS_COMPLETED
    ];

    protected $fillable = ['user_id', 'total', 'status'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
