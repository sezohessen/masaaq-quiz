<?php

namespace App\Jobs;

use App\Mail\MemberQuizLink;
use App\Models\Member;
use App\Models\Quiz;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
class SendQuizLink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Member $member,
        public Quiz $quiz,
        public string $link,
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->member?->email)->send(new MemberQuizLink($this->member,$this->quiz,$this->link));
        } catch (\Exception $e) {
            logger($e);
            //Sentry log or inside log system
        }
    }
}
