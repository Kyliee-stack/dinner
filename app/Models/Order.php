<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'order_number',
    'customer_name',
    'order_type',
    'payment_method',
    'notes',
    'status',
    'subtotal',
    'biaya_lainnya',
    'discount',
    'total',
    'grand_total'
];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
