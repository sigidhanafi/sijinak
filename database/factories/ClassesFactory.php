<?php

namespace Database\Factories;

use App\Models\Teachers;
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

        $teacher = Teachers::inRandomOrder()->first() ?? Teachers::factory()->create();
        
        return [
            'className' => $this->faker->randomElement(['X IPA', 'X IPS', 'XI IPA', 'XI IPS', 'XII IPA', 'XII IPS']),
            'teacherId' => $teacher->id,
        ];
    }
}
