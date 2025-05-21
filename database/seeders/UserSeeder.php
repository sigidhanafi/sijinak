<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(['name' => 'guru', 'email' => 'guru@gmail.com', 'status' => 'active', 'role' => 'guru', 'password' => 'guru123']);
        User::create(['name' => 'gurupiket', 'email' => 'gurupiket@gmail.com', 'status' => 'active', 'role' => 'gurupiket', 'password' => 'gurupiket135']);
        User::create(['name' => 'siswa', 'email' => 'siswa@gmail.com', 'status' => 'active', 'role' => 'siswa', 'password' => 'siswa456']);
        
    }
}
