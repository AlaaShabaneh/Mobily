<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'source_order_id',
    ];

    // لعلاقات المفتاح الخارجي (اختياري لكنها مفيدة)

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sourceOrder()
    {
        return $this->belongsTo(Order::class, 'source_order_id');
    }
}
