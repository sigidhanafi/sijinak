<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activities extends Model
{
    protected $fillable = ['activityName', 'qrcode', 'createdBy'];

    public function users(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'id');
    }

    public function student_activities(): HasMany
    {
        return $this->hasMany(Student_activities::class, 'activityId');
    }
}
