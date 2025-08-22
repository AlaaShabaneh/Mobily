<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceVariantSpecification extends Model
{
    protected $table = 'device_variant_specifications';

    protected $fillable = [
        'variant_id',
        'specification_id',
        'value',
    ];

    public function device()
    {
        return $this->belongsTo(DeviceVariant::class, 'variant_id');
    }

    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }
}
