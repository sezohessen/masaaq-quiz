<?php

namespace App\Http\Services\Tenant\Dashboard\Quiz;


class QuizService
{
    public function create($request)
    {
        return view('tenant_dashboard.dashboard.quiz.create');
    }
    public function store($request)
    {
        dd($request->all());
    }
}
