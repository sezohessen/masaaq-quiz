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
        $quizAttempts = QuizAttempt::finished()
        ->orderBy('id','desc')
        ->paginate(config('application.perPage',10));
        return view('tenant_dashboard.dashboard.quiz_attempt.index',compact('quizAttempts'));
    }
    public function show($request, QuizAttempt $quizAttempt)
    {
        $quizAttempt->load(['answers','quiz','quiz.questions','quiz.questions.choices']);
        return view('tenant_dashboard.dashboard.quiz_attempt.show',compact('quizAttempt'));
    }
}
