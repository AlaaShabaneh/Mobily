<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceListing extends Model
{
    protected $fillable = [
        'device_id',
        'seller_company',
        'price',
        'currency',
        'cost',
        'status',
        'warranty',
        'warranty_company_id',
        'stock',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function warrantyCompany()
    {
        return $this->belongsTo(Provider::class, 'warranty_company_id'); // عدّل اسم الموديل إذا لزم
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
