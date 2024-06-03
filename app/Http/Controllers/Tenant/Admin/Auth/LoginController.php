<?php

namespace App\Http\Controllers\Tenant\Admin\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Tenant\Admin\LoginFormRequest;
use App\Http\Services\Tenant\Admin\Auth\Login\LoginService;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    public function __construct(private LoginService $loginService){
    }
    public function index(Request $request)
    {
        return $this->loginService->index($request);
    }
    public function login(LoginFormRequest $request)
    {
        return $this->loginService->login($request);
    }
}
