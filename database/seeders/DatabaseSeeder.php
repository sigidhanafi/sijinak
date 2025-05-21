<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Parents;
use App\Models\Students;
use App\Models\Teachers;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            TeachersSeeder::class,
            ClassesSeeder::class,
            StudentsSeeder::class,
            ParentsSeeder::class,
        ]);
        
        Teachers::all();
        Classes::all();
        Students::all();
        Parents::all();
    }
}
