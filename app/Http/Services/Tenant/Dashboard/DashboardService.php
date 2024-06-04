<?php

namespace App\Http\Services\Tenant\Dashboard;


class DashboardService
{
    public function index($request)
    {
        return view('tenant_dashboard.dashboard.index');
    }
}
