<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyRating extends Model
{
    protected $table = 'warranty_ratings';

    protected $fillable = [
        'user_id',
        'warranty_claim_id',
        'rating',
        'comment',
    ];

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع مطالبة الضمان
    public function warrantyClaim()
    {
        return $this->belongsTo(WarrantyClaim::class, 'warranty_claim_id');
    }
}
