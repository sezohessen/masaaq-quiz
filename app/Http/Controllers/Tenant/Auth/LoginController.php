<?php

namespace App\Http\Controllers\Tenant\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Services\Tenant\Auth\LoginService;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    public function __construct(private LoginService $loginService){
    }
    public function showLoginForm(Request $request)
    {
        return $this->loginService->showLoginForm($request);
    }
    public function login(LoginRequest $request)
    {
        return $this->loginService->login($request);
    }
}
