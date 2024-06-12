<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $title = fake()->name,
            'slug' => Str::slug($title),
            'description' => fake()->text,
            'score' => fake()->numberBetween(40, 100),
            'quiz_type' => $type = fake()->boolean,
            'start_time' => $type ? now()->addHour() : null,
            'end_time' => $type ? now()->addHours(3) : null,
            'number_of_questions' => fake()->numberBetween(10, 30)
        ];
    }
}
