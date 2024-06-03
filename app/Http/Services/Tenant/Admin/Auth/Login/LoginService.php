<?php

namespace App\Http\Services\Tenant\Admin\Auth\Login;
use Illuminate\Support\Facades\Auth;


class LoginService
{
    public function index($request)
    {
        return view('tenant.pages.admin.login.index');
    }
    public function login($request)
    {
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials,true)) {
            return redirect()->back()->withErrors(__('Invalid email or password'));
        }
        return redirect()->route('dashboard.index');

    }
}
