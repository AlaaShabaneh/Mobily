<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceRating extends Model
{
    protected $fillable = [
        'user_id',
        'device_id',
        'rating',
        'comment',
    ];

    public $timestamps = false; // لأنه لا يوجد updated_at في الجدول

    protected $casts = [
        'rating' => 'integer',
        'user_id' => 'integer',
        'device_id' => 'integer',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(DeviceVariant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
