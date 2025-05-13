<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Students;
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
            ClassesSeeder::class,
            StudentsSeeder::class,
        ]);

        Classes::all();
        Students::all();
    }
}
