<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Choice>
 */
class ChoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->name,
            'description' => fake()->text,
            'is_correct' => fake()->boolean,
            //'question_id' => Question::factory(),

        ];
    }
}
