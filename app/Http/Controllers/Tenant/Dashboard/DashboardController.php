<?php

namespace App\Http\Controllers\Tenant\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Services\Tenant\Dashboard\DashboardService;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService){
    }
    public function index(Request $request)
    {
        return $this->dashboardService->index($request);
    }
}
