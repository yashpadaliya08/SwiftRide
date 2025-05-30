<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Revenue extends Model
{
    protected $fillable = ['booking_id', 'amount', 'type', 'status'];

    const TYPE_PAYMENT = 'payment';
    const TYPE_REFUND = 'refund';

    const STATUS_RECEIVED = 'received';
    const STATUS_REFUNDED = 'refunded';
}
