<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classes>
 */
class ClassesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'className' => $this->faker->randomElement(['X IPA', 'X IPS', 'XI IPA', 'XI IPS', 'XII IPA', 'XII IPS']),
            'teacherId' => $this->faker->unique()->randomNumber(5, true)
        ];
    }
}
