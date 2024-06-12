<?php

namespace Database\Factories;

use App\Models\Choice;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Choice>
 */
class QuestionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::factory(),
            'description' => fake()->text,
            'question' => $question = fake()->name,
            'slug' => Str::slug($question),
            'score' => fake()->numberBetween(40,100)
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Question $question) {
            $question->choices()->saveMany(Choice::factory(3)->make());
        });
    }
}
