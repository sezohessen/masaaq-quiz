<?php

namespace App\Http\Controllers\Auth\Tenant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Tenant\CreateTenantFormRequest;
use App\Http\Services\Auth\Tenant\TenantService;
use Illuminate\Http\Request;


class TenantController extends Controller
{
    public function __construct(private TenantService $tenantService){
    }
    public function index(Request $request)
    {
        return $this->tenantService->index($request);
    }
    public function create(Request $request)
    {
        return $this->tenantService->create($request);
    }
    public function store(CreateTenantFormRequest $request)
    {
        return $this->tenantService->store($request);
    }
}
