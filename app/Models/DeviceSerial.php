<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceSerial extends Model
{
    protected $fillable = ['stock_entry_id', 'serial_number', 'status'];

    public function stockEntry()
    {
        return $this->belongsTo(StockEntry::class);
    }
}
