<?php

namespace App\Mail;

use App\Models\Member;
use App\Models\Quiz;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberQuizLink extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Member $member, public Quiz $quiz, public $link)
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('Quiz Link'))->view('emails.quiz.link');
    }
}
