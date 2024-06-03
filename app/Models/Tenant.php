<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;
    public static function getCustomColumns(): array
    {
        return [
            'id',
            'email',
            'user_id',
            'name'
        ];
    }
    public function primary_domain()
    {
        return $this->hasOne(Domain::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getUrlAttribute(){
        return tenant_route($this->primary_domain->domain .'.'.config("tenancy.central_domains")[0], 'home', [], true) . '/api';
    }
}
