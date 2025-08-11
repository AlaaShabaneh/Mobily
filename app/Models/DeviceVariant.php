<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceVariant extends Model
{
    protected $table = 'device_variants';

    protected $fillable = [
        'model_id',
        'type_id',
    ];

    public function specifications()
    {
        return $this->hasMany(DeviceVariantSpecification::class, 'variant_id');
    }
}
