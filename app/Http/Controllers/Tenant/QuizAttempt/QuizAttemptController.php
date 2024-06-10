<?php

namespace App\Http\Controllers\Tenant\QuizAttempt;

use App\Http\Controllers\Controller;
use App\Http\Services\Tenant\QuizAttempt\QuizAttemptService;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;


class QuizAttemptController extends Controller
{
    public function __construct(private QuizAttemptService $quizAttemptService)
    {
    }
    public function index(Request $request)
    {
        return $this->quizAttemptService->index($request);
    }
}
