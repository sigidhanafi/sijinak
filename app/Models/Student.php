<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students'; // atau sesuaikan dengan nama tabel kamu

    protected $fillable = ['nisn', 'name', 'user_id']; // sesuaikan dengan kolom tabel
}
