<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToPrimaryModel;

class Choice extends Model
{
    use BelongsToPrimaryModel,HasFactory;

    protected $fillable = [
        'question_id', 'title', 'is_correct', 'order', 'description'
    ];
    public function getRelationshipToPrimaryModel(): string
    {
        return 'question';
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
