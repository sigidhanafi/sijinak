<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Students extends Model
{
    /** @use HasFactory<\Database\Factories\StudentsFactory> */
    use HasFactory;

    protected $fillable = ['name', 'nisn', 'classId'];

    public function classes(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'classId');
    }

    // public function scopeSearch($query, $search): void
    // {
    //     $query->where('nisn', 'like', "%{$search}%")
    //         ->orWhere('name', 'like', "%{$search}%");
    // }
}
