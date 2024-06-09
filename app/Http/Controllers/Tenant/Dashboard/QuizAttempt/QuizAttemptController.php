<?php

namespace App\Http\Controllers\Tenant\Dashboard\QuizAttempt;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Tenant\Admin\Quiz\CreateQuizFormRequest;
use App\Http\Services\Tenant\Dashboard\QuizAttempt\QuizAttemptService;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;


class QuizAttemptController extends Controller
{
    public function __construct(private QuizAttemptService $quizAttemptService){
    }
    public function index(Request $request)
    {
        return $this->quizAttemptService->index($request);
    }
    public function show(Request $request, QuizAttempt $quizAttempt)
    {
        return $this->quizAttemptService->show($request,$quizAttempt);
    }
}
