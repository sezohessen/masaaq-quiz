<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Quiz extends Model
{
    use BelongsToTenant;
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

}
