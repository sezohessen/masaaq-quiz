<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToPrimaryModel;

class QuizAttempt extends Model
{
    use HasFactory,BelongsToPrimaryModel;
    protected $fillable = [
        'quiz_id', 'member_id', 'score', 'passed', 'link', 'start_time', 'end_time'
    ];
    public function getRelationshipToPrimaryModel(): string
    {
        return 'quiz';
    }
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
}
