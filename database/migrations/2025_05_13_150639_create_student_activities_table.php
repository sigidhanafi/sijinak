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
        Schema::create('student_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studentId')->nullable()->constrained(
                table: 'students',
                indexName: 'students_activities_studentId'
            )->nullOnDelete();
            $table->foreignId('activityId')->nullable()->constrained(
                table: 'activities',
                indexName: 'student_activities_activityId'
            )->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studen_activities');
    }
};
