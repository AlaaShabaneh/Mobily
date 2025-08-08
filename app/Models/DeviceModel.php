<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class DeviceModel extends EloquentModel
{
    protected $table = 'models';

    protected $fillable = [
        'brand_id',
        'name',
    ];

    // علاقة النموذج بالعلامة التجارية (Brand)
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // مثال: علاقة مع الأجهزة (devices) إذا أردت لاحقاً
    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
