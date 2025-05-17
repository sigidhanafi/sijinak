<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinSiswa extends Model
{
    protected $table = 'izin_siswa'; // ubah ke nama baru

    protected $fillable = [
        'user_id', 'alasan', 'waktu_keluar', 'dokumen', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

