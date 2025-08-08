<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specification extends Model
{
    protected $fillable = [
        'name', // أو الحقول حسب جدول specifications
    ];

    public function deviceSpecificationValues(): HasMany
    {
        return $this->hasMany(DeviceSpecificationValue::class);
    }
}
