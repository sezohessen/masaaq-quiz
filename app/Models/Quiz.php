<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Quiz extends Model
{
    use BelongsToTenant;
    public const InTimeType = 1;
    public const OutTimeType = 0;

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
