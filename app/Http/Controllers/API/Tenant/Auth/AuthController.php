<?php

namespace App\Http\Controllers\API\Tenant\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Tenant\Auth\LoginRequest;
use App\Http\Requests\Tenant\Auth\RegisterRequest;
use App\Http\Services\API\Tenant\Auth\AuthService;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService){
    }
    public function login(LoginRequest $request)
    {
        return $this->authService->login($request);
    }

    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request);
    }
}
