<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'prices';

    protected $fillable = [
        'device_id',
        'price',
        'valid_from',
        'valid_to',
    ];

    // العلاقة مع الجهاز (Device)
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
