<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'device_listing_id',
        'quantity',
        'price',
    ];

    // علاقة البند مع الطلب
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // علاقة البند مع قائمة الجهاز device_listing
    public function deviceListing()
    {
        return $this->belongsTo(DeviceListing::class);
    }
}
