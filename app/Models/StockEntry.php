<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{
    protected $table = 'stock_entries';

    protected $fillable = [
        'device_id',
        'warranty_company_id',
        'supplier_id',
        'quantity',
        'purchase_price',
        'purchase_date',
        'notes',
    ];

    // العلاقات (Relations)

    public function device()
    {
        return $this->belongsTo(DeviceVariant::class);
    }

    public function warrantyCompany()
    {
        return $this->belongsTo(WarrantyCompany::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function serials()
    {
        return $this->hasMany(DeviceSerial::class);
    }

}
