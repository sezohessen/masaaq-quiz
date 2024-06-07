<?php

namespace App\Http\Services\Tenant\Quiz;
use App\Models\Quiz;


class QuizService
{
    public function show($request,Quiz $quiz)
    {
        $quizzes = Quiz::inRandomOrder()->limit(6)->get();

        return view('tenant.quiz.show',compact('quiz','quizzes'));
    }
}
