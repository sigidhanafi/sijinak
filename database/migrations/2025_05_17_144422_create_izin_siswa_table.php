<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('izin_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('alasan');
            $table->dateTime('waktu_keluar');
            $table->string('dokumen');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->longText('qr_code')->nullable(); // optional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('izin_siswa');
    }
};
