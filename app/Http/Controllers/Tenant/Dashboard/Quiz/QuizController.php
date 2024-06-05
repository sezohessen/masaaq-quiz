<?php

namespace App\Http\Controllers\Tenant\Dashboard\Quiz;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Tenant\Admin\Quiz\CreateQuizFormRequest;
use App\Http\Services\Tenant\Dashboard\Quiz\QuizService;
use Illuminate\Http\Request;


class QuizController extends Controller
{
    public function __construct(private QuizService $quizService){
    }
    public function create(Request $request)
    {
        return $this->quizService->create($request);
    }
    public function store(CreateQuizFormRequest $request)
    {
        return $this->quizService->store($request);
    }
}
