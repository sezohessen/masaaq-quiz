<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToPrimaryModel;

class QuizAttempt extends Model
{
    use HasFactory, BelongsToPrimaryModel;
    protected $fillable = [
        'quiz_id',
        'member_id',
        'score',
        'passed',
        'link',
        'start_time',
        'end_time',
        'has_finished'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
    public function getRelationshipToPrimaryModel(): string
    {
        return 'quiz';
    }
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    /* Scopes */
    public function scopeFinished($query)
    {
        return $query->where('has_finished', true);
    }
    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search != null, function ($q) use ($search) {
            return $q->where('link', 'LIKE', '%' . $search . '%')
                ->orWhereHas('quiz', function ($subQ) use ($search) {
                    return $subQ->whenSearch($search);
                })
                ->orWhereHas('member', function ($subQ) use ($search) {
                    return $subQ->whenSearch($search);
                });
        });
    }
    public function scopeWhenType($query, $type)
    {
        return $query->when($type != null, function ($q) use ($type) {
            return $q->whereHas('quiz', function ($subQ) use ($type) {
                    return $subQ->where('quiz_type',$type);
                });
        });
    }
    public function scopeWhenResult($query, $result)
    {
        return $query->when($result != null, function ($q) use ($result) {
            return $q->where('passed',$result);
        });
    }
    public function scopeWhenFinished($query, $type)
    {
        return $query->when($type != null, function ($q) use ($type) {
            return $q->where('has_finished', $type);
        });
    }
}
