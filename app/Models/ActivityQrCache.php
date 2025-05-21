<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityQrCache extends Model
{
    use HasFactory;

    protected $table = 'activity_qr_cache';

    protected $fillable = [
        'activity_id',
        'qr_code',
    ];

    public function activity()
    {
        return $this->belongsTo(Activities::class, 'activity_id');
    }
}
