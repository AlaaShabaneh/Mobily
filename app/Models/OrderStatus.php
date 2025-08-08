<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    public $timestamps = false; // لأنه لا يوجد created_at و updated_at في الجدول

    protected $fillable = ['name'];

    // العلاقات المحتملة
    public function orders()
    {
        return $this->hasMany(Order::class, 'status_id');
    }
}
