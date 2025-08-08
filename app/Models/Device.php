<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'name',
        'model_id',
        'type_id',
        'specs',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'device_categories', 'device_id', 'category_id');
    }
    public function ratings()
    {
        return $this->hasMany(DeviceRating::class);
    }
    public function specificationValues()
    {
        return $this->hasMany(DeviceSpecificationValue::class);
    }
    public function favoredByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites', 'device_id', 'user_id')->withTimestamps();
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    // علاقة للصورة الرئيسية مثلاً
    public function mainImage()
    {
        return $this->hasOne(Image::class)->where('is_main', 1);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

}
