<?php

namespace App\Http\Services\API\Tenant\Quiz;
use App\Http\Resources\Collection\QuizCollection;
use App\Http\Resources\QuizResource;
use App\Models\Quiz;
use App\Traits\ApiHelpersTrait;

class QuizService
{
    use ApiHelpersTrait;
    public function get($request)
    {
        $quizzes = $this->getQuizzes($request);
        return $this->success('Quizzes',new QuizCollection($quizzes));
    }
    public function show($request,$quiz)
    {
        return $this->success('Quiz',new QuizResource($quiz));
    }
    public function getQuizzes($request)
    {
        return Quiz::whenSearch($request['search'])
        ->whenType($request['type'])
        ->paginate($request['perPage'] ?? config('application.perPage',10));
    }

}
