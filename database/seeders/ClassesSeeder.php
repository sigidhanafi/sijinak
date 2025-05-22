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

        $teachersForClass = Teachers::where('is_on_duty', false)
            ->whereDoesntHave('class')
            ->inRandomOrder()
            ->take(count($classNames))
            ->get();

        if ($teachersForClass->count() < count($classNames)) {
            throw new \Exception('Jumlah guru yang tersedia untuk menjadi wali kelas tidak mencukupi.');
        }

        foreach ($classNames as $index => $className) {
            Classes::create([
                'className' => $className,
                'teacherId' => $teachersForClass[$index]->id,
            ]);
        }
    }
}
