<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyCompany extends Model
{
    protected $table = 'warranty_companies';

    protected $fillable = [
        'name',
        'contact_info',
    ];

    // علاقة مع stock_entries (مثلاً)
    public function stockEntries()
    {
        return $this->hasMany(StockEntry::class, 'warranty_company_id');
    }

    // علاقة مع device_listings (إذا موجود حقل warranty_company_id)
    public function deviceListings()
    {
        return $this->hasMany(DeviceListing::class, 'warranty_company_id');
    }
}
