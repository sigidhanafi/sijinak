<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
   /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'user';
    protected $fillable = [
        'username',
        'password',
        'role'
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(Classes::class, 'teacherId');
    }
    public function student()
    {
        return $this->hasOne(\App\Models\Students::class, 'user_id');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];
}
