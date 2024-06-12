<?php

namespace App\Jobs;

use App\Exports\QuizAttemptCSV;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class DownloadQuizAttemptsCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $index;

    public function __construct($data, $index)
    {
        $this->onQueue('low');
        $this->data = $data;
        $this->index = $index;
    }

    public function handle()
    {
        $date = Carbon::now()->format('Y-m-d');
        $filename = "quiz_results_{$date}_chunk{$this->index}.xlsx";
        $filePath = 'exports/' . $filename;

        try {
            Excel::store(new QuizAttemptCSV($this->data), $filePath, 'public');
        } catch (\Exception $e) {
            return false;
        }
    }
}
