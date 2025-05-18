<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Adminlogs>
 */
class AdminlogsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'activity_type' => $this->faker->randomElement(['Log In', 'Create QR', 'Accept Student Request', 'Reject Student Request']),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}

