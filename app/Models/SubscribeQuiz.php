<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToPrimaryModel;

class SubscribeQuiz extends Model
{
    use HasFactory,BelongsToPrimaryModel;
    protected $fillable = [
        'member_id',
        'link',
        'quiz_id',
    ];

    public function getRelationshipToPrimaryModel(): string
    {
        return 'member';
    }
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

}
