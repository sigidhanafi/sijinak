<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Students extends Model
{
    protected $fillable = ['name', 'nisn', 'classId'];

    public function classes(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'classId');
    }

    public function student_activities(): HasMany
    {
        return $this->hasMany(Student_activities::class, 'studentId');
    }
}
