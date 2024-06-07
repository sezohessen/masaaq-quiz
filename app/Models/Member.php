<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Member extends Authenticatable
{
    use HasFactory,HasApiTokens, BelongsToTenant;
    protected $fillable = [
        'name', 'email', 'tenant_id','password','google_access_token'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'google_access_token' => 'json',
    ];
    public function subscribed_quizzes()
    {
        return $this->hasMany(SubscribeQuiz::class);
    }
    public function isClientOwner()
    {
        return false;
    }
}
