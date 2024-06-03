<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, BelongsToTenant, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'domain_name',
        'tenant_id'
    ];
    public const CLIENT_ROLE = "Client owner";
    public const ADMIN_ROLE = "Administrator";
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
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
    ];
    public function isClientOwner()
    {
        return $this->hasRole(self::CLIENT_ROLE);
    }
    /* Scopes */
    public function scopeClients($query)
    {
        return $query->whereHas('roles', function ($q) {
            return $q->where("name", self::CLIENT_ROLE);
        })->orderBy('id','desc');
    }
    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search != null, function ($q) use ($search) {
            return $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('domain_name', 'like', '%' . $search . '%');
        });
    }
    /* Scopes */
    /* relations */
    public function client()
    {
        return $this->hasOne(Tenant::class);
    }

}
