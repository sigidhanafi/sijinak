<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Adminlogs;

class AdminlogsSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        Adminlogs::factory()->count(40)->create();
    }
}

