<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS = [
        'new' => ['confirmed','cancelled'],
        'confirmed' => ['processing','cancelled'],
        'processing' => ['shipped'],
        'shipped' => ['completed'],
        'completed' => null,
        'cancelled' => null
    ];

    protected $fillable = [
        'customer_id',
        'status',
        'total_amount',
        'confirmed_at',
        'shipped_at'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getNextStatus() :?array
    {
        return self::STATUS[$this->status];
    }
}
