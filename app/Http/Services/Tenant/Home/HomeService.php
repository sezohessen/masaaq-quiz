<?php

namespace App\Http\Services\Tenant\Home;
use App\Models\Quiz;


class HomeService
{
    public function home($request)
    {
        $quizzes = $this->getQuizzes($request);
        return view('tenant.home',compact('quizzes'));
    }
    private function getQuizzes($request)
    {
        return Quiz::take(9)->get();
    }
}
