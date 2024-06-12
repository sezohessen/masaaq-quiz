<?php

namespace App\Http\Services\Tenant\Dashboard\QuizAttempt;

use App\Exports\QuizAttemptCSV;
use App\Jobs\DownloadQuizAttemptsCSV;
use App\Models\QuizAttempt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Queue;
use Maatwebsite\Excel\Facades\Excel;


class QuizAttemptService
{
    public function index($request)
    {
        $quizAttempts = QuizAttempt::finished()
            /* ->where('id', '<=',100) */
            ->whenSearch($request['search'] ?? null)
            ->whenType($request['quiz_type'] ?? null)
            ->whenResult($request['result'] ?? null)
            ->orderBy('id', 'desc');
        if ($quizAttempts->count() && $request->filled('download') && $request->input('download') == 'csv') {
            $this->dispatchDownloadJob($request, $quizAttempts);
            return redirect()->back()->with('success', __('CSV download has been queued. download it from csv files page'));
        }
        $quizAttempts = $quizAttempts->paginate(config('application.perPage', 10));
        return view('tenant_dashboard.dashboard.quiz_attempt.index', compact('quizAttempts'));
    }
    private function dispatchDownloadJob($request, $model)
    {
        try {
            $chunkSize = config('application.csv_chunk_size',1000);
            $totalRecords = $model->count();

            $chunks = ceil($totalRecords / $chunkSize);

            for ($i = 0; $i < $chunks; $i++) {
                $offset = $i * $chunkSize;
                $chunkData = $model->skip($offset)->take($chunkSize)->get();
                Queue::push(new DownloadQuizAttemptsCSV($chunkData, $i + 1));
            }
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            return redirect()->back()->with('error', __('Could not queue Excel download.'));
        }
    }
    public function show($request, QuizAttempt $quizAttempt)
    {
        $quizAttempt->load(['answers', 'quiz', 'quiz.questions', 'quiz.questions.choices']);
        return view('tenant_dashboard.dashboard.quiz_attempt.show', compact('quizAttempt'));
    }
}
