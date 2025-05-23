<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some sample students
        $students = [
            [
                'id' => 1,
                'name' => 'Muhammad Ilham Rajo Sikumbang',
                'nisn' => '12345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'John Doe',
                'nisn' => '23456789',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Jane Smith',
                'nisn' => '34567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
