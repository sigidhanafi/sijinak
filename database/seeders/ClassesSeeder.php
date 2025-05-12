<?php

namespace Database\Seeders;

use App\Models\Classes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classes::create([
            'className' => 'X IPA',
            'teacherId' => 1,
        ]);

        Classes::create([
            'className' => 'X IPS',
            'teacherId' => 2,
        ]);

        Classes::create([
            'className' => 'XI IPA',
            'teacherId' => 3,
        ]);

        Classes::create([
            'className' => 'XI IPS',
            'teacherId' => 4,
        ]);

        Classes::create([
            'className' => 'XII IPA',
            'teacherId' => 5,
        ]);

        Classes::create([
            'className' => 'XII IPS',
            'teacherId' => 6,
        ]);
    }
}
