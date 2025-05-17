<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIzinSiswasTable extends Migration
{
    public function up()
    {
        Schema::create('izin_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('alasan');
            $table->string('dokumen')->nullable();
            $table->string('status')->default('pending');
            $table->string('qr_code')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('izin_siswas');
    }
}
