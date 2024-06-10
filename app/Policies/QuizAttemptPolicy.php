<?php

namespace App\Policies;

use App\Models\QuizAttempt;
use App\Models\Member;

class QuizAttemptPolicy
{
    public function finish(Member $member, QuizAttempt $quizAttempt)
    {
        return $quizAttempt->member_id === $member->id;
    }

    public function result(Member $member, QuizAttempt $quizAttempt)
    {
        return $quizAttempt->member_id === $member->id;
    }
}
