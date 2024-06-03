<?php

namespace App\Http\Services\Tenant\Home;


class HomeService
{
    public function home($request)
    {
        return view('tenant.home');
    }
}
