<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classes extends Model
{
    /** @use HasFactory<\Database\Factories\ClassesFactory> */
    use HasFactory;

    protected $fillable = ['className', 'teacherId'];

    public function students(): HasMany
    {
        return $this->hasMany(Students::class, 'classId');
    }

    public function totalStudents($classId): int
    {
        return Students::where('classId', $classId)->count();
    }
}
