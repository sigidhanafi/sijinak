<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IzinSiswa extends Model
{
    protected $table = 'izin_siswa'; // sudah benar pakai nama table baru

    protected $fillable = [
        'user_id',
        'alasan',
        'waktu_keluar',
        'dokumen',
        'status',
        'qr_code' // tambah ini jika nanti mau simpan QR code base64
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
