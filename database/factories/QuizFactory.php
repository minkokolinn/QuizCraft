<?php

namespace Database\Factories;

use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "body" => $this->faker->sentence(),
            "grade" => $this->faker->numberBetween(10,12),
            "chapter" => $this->faker->numberBetween(1,6),
            "type_id" => Type::factory()
        ];
    }
}
