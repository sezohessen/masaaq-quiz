<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Quiz extends Model
{
    use BelongsToTenant,HasFactory;
    protected $fillable = [
        'title', 'slug', 'description', 'quiz_type', 'start_time', 'end_time', 'score', 'number_of_questions'
    ];
    public const InTimeType = 1;
    public const OutTimeType = 0;
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
    /* getters  */
    public function getTypeAttribute()
    {
        return $this->quiz_type == self::InTimeType ? __('In time') : __('Out time');
    }
    public function isAvailableToStartNow()
    {
        if ($this->quiz_type == 1 && $this->start_time && $this->end_time) {
            $now = Carbon::now();
            return $now->gte($this->start_time) && $now->lte($this->end_time);
        }

        return true;
    }
    public function isInTime()
    {
        return $this->quiz_type == self::InTimeType;
    }
    public function isEnded()
    {
        if ($this->quiz_type == 1 && $this->start_time && $this->end_time) {
            $now = Carbon::now();
            return $now->gte($this->end_time);
        }

        return false;
    }
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }
    public function getAttemptsCountAttribute()
    {
        return $this->attempts()->count();
    }

    public function getPassRateAttribute()
    {
        $attempts = $this->attempts()->count();
        if ($attempts === 0) {
            return 0;
        }
        $passed = $this->attempts()->where('passed', true)->count();
        return ($passed / $attempts) * 100;
    }

    public function getFailRateAttribute()
    {
        $attempts = $this->attempts()->count();
        if ($attempts === 0) {
            return 0;
        }
        $failed = $this->attempts()->where('passed', false)->count();
        return ($failed / $attempts) * 100;
    }

    public function getAverageScoreAttribute()
    {
        return $this->attempts()->avg('score');
    }

    public function getAverageTimeAttribute()
    {
        if(!$this->isInTime())return null;
        $attempts = $this->attempts()->whereNotNull('end_time')->get();
        if ($attempts->isEmpty()) {
            return null;
        }
        $totalTime = $attempts->reduce(function ($carry, $attempt) {
            return $carry + $attempt->end_time->diffInSeconds($attempt->start_time);
        }, 0);
        $averageTimeInSeconds = $totalTime / $attempts->count();

        return gmdate('H:i:s', $averageTimeInSeconds);
    }
    /* Scopes */
    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search != null, function ($q) use ($search) {
            return $q->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'LIKE', '%' . $search . '%');
        });
    }
    public function scopeWhenType($query, $type)
    {
        return $query->when($type != null, function ($q) use ($type) {
            return $q->where('quiz_type',$type);
        });
    }

}
