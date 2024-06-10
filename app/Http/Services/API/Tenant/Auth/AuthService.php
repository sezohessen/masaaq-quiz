<?php

namespace App\Http\Services\API\Tenant\Auth;
use App\Traits\ApiHelpersTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\Tenant\Auth\RegisterService;
use App\Http\Resources\MemberResource;

class AuthService
{
    use ApiHelpersTrait;
    public function login($request)
    {
        $request->authenticate();

        $user = Auth::user();
        $token = $this->createToken($user);
        return $this->success('Login successfully', [
            'user' => new MemberResource($user),
            'token' => $token,
        ]);
    }

    public function register($request)
    {
        $member = (new RegisterService)->createMember($request);
        Auth::login($member);
        $user = Auth::user();
        $token = $this->createToken($user);
        return $this->success('Registered successfully', [
            'user' => new MemberResource($user),
            'token' => $token,
        ]);
    }

    public function createToken($user)
    {
        return $user->createToken('authToken')->plainTextToken;
    }
}
