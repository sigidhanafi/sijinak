<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Students extends Model
{
    /** @use HasFactory<\Database\Factories\StudentsFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'nisn', 'classId'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function classes(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'classId');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Parents::class, 'parentId');
    }
}
