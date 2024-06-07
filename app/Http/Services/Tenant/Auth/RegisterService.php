<?php

namespace App\Http\Services\Tenant\Auth;
use App\Models\Member;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;



class RegisterService
{
    public function showRegistrationForm($request)
    {
        return view('tenant.auth.register');
    }
    public function register($request)
    {
        $member = $this->createMember($request);

        Auth::login($member);

        return redirect(RouteServiceProvider::TENANT);
    }
    public function createMember($request): Member
    {
        return Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => createPassword($request->password),
        ]);
    }
}
