<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';

    protected $fillable = [
        'name',
    ];

    // إذا يوجد علاقة مع موديلات مثلاً
    public function models()
    {
        return $this->hasMany(DeviceModel::class, 'type_id');
    }
}
