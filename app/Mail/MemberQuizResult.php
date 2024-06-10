<?php

namespace App\Mail;

use App\Models\Member;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberQuizResult extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Member $member, public QuizAttempt $quizAttempt,public $link)
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('Quiz result - '). $this->quizAttempt?->quiz?->title)->view('emails.quiz.result');
    }
}
