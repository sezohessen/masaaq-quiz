<?php

namespace App\Http\Services\Tenant\Dashboard\QuizAttempt;

use App\Exports\QuizAttemptCSV;
use App\Models\QuizAttempt;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;


class QuizAttemptService
{
    public function index($request)
    {
        $quizAttempts = QuizAttempt::finished()
        ->whenSearch($request['search'] ?? null)
        ->whenType($request['quiz_type'] ?? null)
        ->whenResult($request['result'] ?? null)
        ->orderBy('id','desc');
        if ($quizAttempts->count() && $request->filled('download') && $request->input('download') == 'csv') {
            return $this->handleDownload($request, $quizAttempts);
        }
        $quizAttempts = $quizAttempts->paginate(config('application.perPage',10));
        return view('tenant_dashboard.dashboard.quiz_attempt.index',compact('quizAttempts'));
    }
    public function show($request, QuizAttempt $quizAttempt)
    {
        $quizAttempt->load(['answers','quiz','quiz.questions','quiz.questions.choices']);
        return view('tenant_dashboard.dashboard.quiz_attempt.show',compact('quizAttempt'));
    }
    private function handleDownload($request, $model)
    {
        try {
            $todayDate = Carbon::now()->format('Y-m-d');
            $filename = "quiz_results_$todayDate.csv";
            return Excel::download(new QuizAttemptCSV($model->get()), $filename);

        } catch (\Exception $e) {
            dd($e->getMessage());
            //\Sentry\captureException($e);
            return redirect()->back()->with('error',__('Could not download CSV file.'));
        }
    }
}
