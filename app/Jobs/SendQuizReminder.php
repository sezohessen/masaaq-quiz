<?php

namespace App\Jobs;

use App\Mail\QuizReminderMail;
use App\Models\Member;
use App\Models\Quiz;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendQuizReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Member $member,public Quiz $quiz,public $link)
    {
        $this->onQueue('medium');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->member?->email)->send(new QuizReminderMail($this->member, $this->quiz,$this->link));
        } catch (\Exception $e) {
            logger($e);
            // Log or handle the exception
        }
    }
}
