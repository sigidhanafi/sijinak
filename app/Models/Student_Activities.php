<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student_activities extends Model
{
    protected $fillable = ['studentId', 'activityId'];

    public function Students(): BelongsTo
    {
        return $this->belongsTo(Students::class, 'id');
    }

    public function Activities(): BelongsTo
    {
        return $this->belongsTo(Activities::class, 'id');
    }
    
}