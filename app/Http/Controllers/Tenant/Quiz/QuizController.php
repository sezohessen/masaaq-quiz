<?php

namespace App\Http\Controllers\Tenant\Quiz;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Quiz\FinishQuizRequest;
use App\Http\Services\Tenant\Quiz\QuizService;
use App\Models\Quiz;
use App\Models\QuizAttempt;
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
    public function begin(Request $request, $link)
    {
        return $this->quizService->begin($request, $link);
    }
    public function finish(FinishQuizRequest $request, QuizAttempt $quizAttempt)
    {
        $this->authorize('finish',$quizAttempt);
        return $this->quizService->finish($request, $quizAttempt);
    }
    public function result(Request $request, QuizAttempt $quizAttempt)
    {
        $this->authorize('result',$quizAttempt);
        return $this->quizService->result($request, $quizAttempt);
    }
}
