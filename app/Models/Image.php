<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'model_id',
        'url',
        'is_main',
    ];

    public $timestamps = false;

    // العلاقة مع الموديل DeviceModel (كل صورة تنتمي لموديل واحد)
    public function model()
    {
        return $this->belongsTo(DeviceModel::class, 'model_id');
    }
}
