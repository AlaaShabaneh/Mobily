<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyClaim extends Model
{
    protected $table = 'warranty_claims';

    protected $fillable = [
        'user_id',
        'device_listing_id',
        'order_id',
        'issue_description',
        'claim_date',
        'status',
        'resolution_notes',
    ];

    // العلاقات:

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deviceListing()
    {
        return $this->belongsTo(DeviceListing::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
