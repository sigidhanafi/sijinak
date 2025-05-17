<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classes extends Model
{

    protected $fillable = ['className', 'teacherId'];

    public function students(): HasMany
    {
        return $this->hasMany(Students::class, 'classId');
    }

    public function users():BelongsTo
    {
        return $this->belongsTo(Users::class, 'id');
    }

    public function totalStudents($classId): int
    {
        return Students::where('classId', $classId)->count();
    }
}