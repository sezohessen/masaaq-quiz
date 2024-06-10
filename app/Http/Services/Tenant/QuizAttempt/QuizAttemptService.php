<?php

namespace App\Http\Services\Tenant\QuizAttempt;
use App\Models\QuizAttempt;


class QuizAttemptService
{
    public function index($request)
    {
        $attempts = QuizAttempt::all();
        return view('tenant.quiz_attempt.index',compact('attempts'));
    }
}
