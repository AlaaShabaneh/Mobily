<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Favorite extends Pivot
{
    protected $table = 'favorites';

    protected $fillable = [
        'user_id',
        'device_id',
    ];

    public $timestamps = true;  // لتفعيل التوقيتات created_at و updated_at
}
