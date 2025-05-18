<?php

namespace Database\Factories;

use App\Models\Parents;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Students>
 */
class StudentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $parentId = Parents::factory()->create()->id;

        return [
            'name' => $this->faker->name(),
            'nisn' => $this->faker->unique()->randomNumber(5, true),
            'classId' => $this->faker->numberBetween(1, 6),
            'parentId' => $parentId,
        ];
    }
}
