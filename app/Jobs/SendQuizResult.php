<?php

namespace App\Jobs;

use App\Mail\MemberQuizResult;
use App\Models\Member;
use App\Models\QuizAttempt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
class SendQuizResult implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Member $member,
        public QuizAttempt $quizAttempt,
        public $link
    )
    {
        $this->onQueue('high');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->member?->email)->send(new MemberQuizResult($this->member,$this->quizAttempt,$this->link));
        } catch (\Exception $e) {
            logger($e);
            //Sentry log or inside log system
        }
    }
}
