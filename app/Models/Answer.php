<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToPrimaryModel;

class Answer extends Model
{
    use HasFactory,BelongsToPrimaryModel;
    protected $fillable = [
        'choice_id', 'question_id', 'quiz_attempt_id','is_correct'
    ];
    public function getRelationshipToPrimaryModel(): string
    {
        return 'question';
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function quizAttempt()
    {
        return $this->belongsTo(QuizAttempt::class);
    }
    public function choice()
    {
        return $this->belongsTo(Choice::class);
    }
}
