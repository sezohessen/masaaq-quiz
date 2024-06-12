<?php

namespace App\Http\Services\Tenant\QuizAttempt;
use App\Models\QuizAttempt;


class QuizAttemptService
{
    public function index($request)
    {
        $attempts = QuizAttempt::orderBy('id','desc')
        ->paginate(config('application.perPage',10));
        return view('tenant.quiz_attempt.index',compact('attempts'));
    }
}
