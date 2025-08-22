<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public $timestamps = false; // إذا لم يكن هناك created_at و updated_at
    public function devices()
    {
        return $this->belongsToMany(DeviceVariant::class, 'device_categories', 'category_id', 'device_id');
    }

}
