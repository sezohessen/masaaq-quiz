<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Choice extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'question_id', 'title', 'is_correct', 'order', 'description'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
