<?php

namespace App\Http\Services\Auth\Tenant;

class TenantService
{
    public function create($request)
    {
        return view('auth.tenant.create');
    }
}
