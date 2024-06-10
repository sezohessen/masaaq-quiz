<?php

namespace App\Http\Controllers\API\Tenant\Quiz;

use App\Http\Controllers\Controller;
use App\Http\Services\API\Tenant\Quiz\QuizService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function __construct(private QuizService $quizService){
    }
    public function get(Request $request)
    {
        return $this->quizService->get($request);
    }
}
