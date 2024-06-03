<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Http\Services\Tenant\Home\HomeService;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function __construct(private HomeService $homeService){
    }
    public function home(Request $request)
    {
        return $this->homeService->home($request);
    }
}
