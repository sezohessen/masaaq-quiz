<?php

namespace App\Http\Controllers\Auth\Tenant;
use App\Http\Controllers\Controller;
use App\Http\Services\Auth\Tenant\TenantService;
use Illuminate\Http\Request;


class TenantController extends Controller
{
    public function __construct(private TenantService $tenantService){
    }
    public function create(Request $request)
    {
        return $this->tenantService->create($request);
    }
}
