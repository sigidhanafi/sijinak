<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parents extends Model
{
    /** @use HasFactory<\Database\Factories\ParentsFactory> */
    use HasFactory;

    protected $fillable = ['name', 'phone', 'parentId'];

    public function students(): HasMany
    {
        return $this->hasMany(Students::class, 'parentId');
    }
}
