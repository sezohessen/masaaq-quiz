<?php

namespace App\Http\Services\Tenant\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;


class LoginService
{
    public function showLoginForm($request)
    {
        return view('tenant.Auth.login');
    }
    public function login($request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::TENANT);
    }
}
