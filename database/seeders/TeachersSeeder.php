<?php

namespace Database\Seeders;

use App\Models\Teachers;
use Illuminate\Database\Seeder;

class TeachersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teachers::factory()->count(10)->create();
    }
}
