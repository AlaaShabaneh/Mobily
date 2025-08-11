<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';

    protected $fillable = [
        'name',
    ];

    // إذا يوجد علاقة مع أجهزة مثلاً
    public function devices()
    {
        return $this->hasMany(DeviceVariant::class, 'type_id');
    }
}
