<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyDetail extends Model
{
    protected $table = 'warranty_details';

    protected $fillable = [
        'device_listing_id',
        'duration_months',
        'coverage',
        'terms',
    ];

    // العلاقة مع DeviceListing (جهاز معروض للبيع)
    public function deviceListing()
    {
        return $this->belongsTo(DeviceListing::class, 'device_listing_id');
    }
}
