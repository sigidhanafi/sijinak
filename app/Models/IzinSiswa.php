<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinSiswa extends Model
{
    protected $table = 'izin_siswas'; // nama tabel sesuai migrasi

    protected $fillable = ['user_id', 'alasan', 'dokumen', 'status', 'qr_code'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
