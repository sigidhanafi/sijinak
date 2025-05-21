<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Teachers;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classNames = ['X IPA', 'X IPS', 'XI IPA', 'XI IPS', 'XII IPA', 'XII IPS'];

        $teachersForClass = Teachers::inRandomOrder()->take(count($classNames))->get();

        foreach ($classNames as $index => $className) {
            Classes::create([
                'className' => $className,
                'teacherId' => $teachersForClass[$index]->id,
            ]);
        }
    }
}
