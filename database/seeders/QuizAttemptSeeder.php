<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QuizAttemptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $member = Member::first();
        $quizzes = Quiz::all();
        for ($i = 0; $i < config('application.attempts_records',20); $i++) {
            $quiz = $quizzes->random(1)->first();
            $link = Str::random(10);
            $member->subscribed_quizzes()->create([
                'quiz_id' => $quiz->id,
                'has_started' => 1,
                'link' => $link
            ]);
            $quiz->load(['questions', 'questions.choices']);
            $attempt = QuizAttempt::create([
                'member_id' => $member->id,
                'quiz_id' => $quiz->id,
                'has_finished' => 1,
                'link' => $link,
                'start_time' => now(),
                'end_time' => now()->addHours(2),
                'score' => $totalScore = fake()->numberBetween(0, $quiz->score),
                'passed' => $totalScore >= ($quiz->score / 2)
            ]);
            foreach ($quiz->questions as $question) {
                $choice = $question->choices()->inRandomOrder()->first();
                $attempt->answers()->create([
                    'question_id' => $question->id,
                    'choice_id' => $choice->id,
                    'is_correct' => $choice->is_correct
                ]);
            }
        }
    }
}
