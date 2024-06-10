<?php

namespace App\Jobs;

use App\Mail\MemberQuizResult;
use App\Mail\MemberQuizResultForOwner;
use App\Models\Member;
use App\Models\QuizAttempt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
class SendQuizResultForOwner implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $ownerEmail,
        public Member $member,
        public QuizAttempt $quizAttempt,
        public $link
    )
    {
        $this->onQueue('low');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->ownerEmail)->send(new MemberQuizResultForOwner($this->member,$this->quizAttempt,$this->link));
        } catch (\Exception $e) {
            logger($e);
            //Sentry log or inside log system
        }
    }
}
