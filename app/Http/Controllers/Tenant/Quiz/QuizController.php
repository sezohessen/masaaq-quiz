<?php

namespace App\Http\Controllers\Tenant\Quiz;

use App\Http\Controllers\Controller;
use App\Http\Services\Tenant\Quiz\QuizService;
use App\Models\Quiz;
use Illuminate\Http\Request;


class QuizController extends Controller
{
    public function __construct(private QuizService $quizService)
    {
    }
    public function show(Request $request, $id, Quiz $quiz)
    {
        return $this->quizService->show($request, $quiz);
    }
    public function subscribe(Request $request, Quiz $quiz)
    {
        return $this->quizService->subscribe($request, $quiz);
    }
}
