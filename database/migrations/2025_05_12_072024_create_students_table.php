<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrainded(
                table: 'users',
                indexName: 'users_user_id'
            );
            $table->string('name');
            $table->string('nisn')->unique();
            $table->foreignId('classId')->nullable()->constrained(
                table: 'classes',
                indexName: 'classes_classId'
            )->onDelete('set null');
            $table->foreignId('parentId')->nullable()->constrained(
                table: 'parents',
                indexName: 'parents_parentId'
            )->onDelete('set null');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
