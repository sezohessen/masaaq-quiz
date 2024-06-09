<?php

namespace App\Http\Services\Tenant\Dashboard\QuizAttempt;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAttempt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class QuizAttemptService
{
    public function index($request)
    {
        $quizAttempts = QuizAttempt::finished()->get();
        return view('tenant_dashboard.dashboard.quiz_attempt.index',compact('quizAttempts'));
    }
    public function show($request)
    {
        $quizzes = Quiz::all();
        return view('tenant_dashboard.dashboard.quiz.index',compact('quizzes'));
    }
}
