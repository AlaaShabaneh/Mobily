<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceSpecificationValue extends Model
{
    protected $fillable = [
        'device_id',
        'specification_id',
        'value',
    ];

    // Laravel يدير created_at و updated_at تلقائياً طالما الحقول موجودة باسمائها الافتراضية

    public function device(): BelongsTo
    {
        return $this->belongsTo(DeviceVariant::class);
    }

    public function specification(): BelongsTo
    {
        return $this->belongsTo(Specification::class);
    }
}
