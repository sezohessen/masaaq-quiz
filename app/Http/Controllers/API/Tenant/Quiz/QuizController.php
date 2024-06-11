<?php

namespace App\Http\Controllers\API\Tenant\Quiz;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Quiz\FinishQuizRequest;
use App\Http\Services\API\Tenant\Quiz\QuizService;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function __construct(private QuizService $quizService){
    }
    public function get(Request $request)
    {
        return $this->quizService->get($request);
    }
    public function show(Request $request, Quiz $quiz)
    {
        return $this->quizService->show($request,$quiz);
    }
    public function subscribe(Request $request, Quiz $quiz)
    {
        return $this->quizService->subscribe($request,$quiz);
    }
    public function begin(Request $request, $link)
    {
        return $this->quizService->begin($request,$link);
    }
    public function finish(FinishQuizRequest $request, QuizAttempt $quizAttempt)
    {
        return $this->quizService->finish($request,$quizAttempt);
    }
}
