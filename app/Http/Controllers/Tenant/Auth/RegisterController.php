<?php

namespace App\Http\Controllers\Tenant\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Auth\RegisterRequest;
use App\Http\Services\Tenant\Auth\RegisterService;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    public function __construct(private RegisterService $registerService){
    }
    public function showRegistrationForm(Request $request)
    {
        return $this->registerService->showRegistrationForm($request);
    }
    public function register(RegisterRequest $request)
    {
        return $this->registerService->register($request);
    }
}
