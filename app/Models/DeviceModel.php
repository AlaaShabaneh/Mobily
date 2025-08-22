<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class DeviceModel extends EloquentModel
{
    protected $table = 'models';

    protected $fillable = [
        'brand_id',
        'name',
        'type_id',
    ];

    // علاقة النموذج بالعلامة التجارية (Brand)
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    // مثال: علاقة مع الأجهزة (devices) إذا أردت لاحقاً
    public function devices()
    {
        return $this->hasMany(DeviceVariant::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'model_id');
    }

}
