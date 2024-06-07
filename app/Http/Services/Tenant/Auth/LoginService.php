<?php

namespace App\Http\Services\Tenant\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;


class LoginService
{
    public function showLoginForm($request)
    {
        return view('tenant.auth.login');
    }
    public function login($request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
