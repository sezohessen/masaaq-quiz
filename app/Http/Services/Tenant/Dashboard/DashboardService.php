<?php

namespace App\Http\Services\Tenant\Dashboard;
use App\Models\Quiz;
use App\Models\Member;
use App\Models\QuizAttempt;


class DashboardService
{
    public function index($request)
    {
        $membersCount = Member::count();
        $quizzesCount = Quiz::count();
        $attemptsCount = QuizAttempt::count();

        return view('tenant_dashboard.dashboard.index', compact('membersCount', 'quizzesCount', 'attemptsCount'));
    }
}
