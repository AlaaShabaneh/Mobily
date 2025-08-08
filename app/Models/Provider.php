<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'providers';

    protected $fillable = [
        'name',
        'contact_info',
    ];

    // إذا في علاقات مع جداول أخرى، تضيفها هنا مثل:
    // public function deviceListings()
    // {
    //     return $this->hasMany(DeviceListing::class, 'warranty_company_id');
    // }
}
