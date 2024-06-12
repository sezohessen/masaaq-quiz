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
        'created_at' => 'date',
        'updated_at' => 'date',
    ];
    public function subscribed_quizzes()
    {
        return $this->hasMany(SubscribeQuiz::class);
    }
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
    public function hasSubscribedQuiz($link)
    {
        $routeLink = route('quiz.begin',['link' => $link]);
        return $this->subscribed_quizzes()
        /* ->hasNotStarted() */
        ->where('link',$routeLink)
        ->first();
    }
    public function hasFinishedQuizAttempt($link)
    {
        return $this->attempts()
        ->finished()
        ->where('link',$link)
        ->first();
    }
    public function isClientOwner()
    {
        return false;
    }
    /* Scopes */
    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search != null, function ($q) use ($search) {
            return $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
        });
    }
}
