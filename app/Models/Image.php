<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'device_id',
        'url',
        'is_main',
    ];

    public $timestamps = false; // لأنه في الجدول لا يوجد created_at و updated_at

    // العلاقة مع الجهاز Device (كل صورة تنتمي لجهاز واحد)
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
