<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stancl\Tenancy\Features\UserImpersonation;


class UserImpersonateController extends Controller
{
    public function impersonate(Request $request, $token)
    {
        return UserImpersonation::makeResponse($token);
    }
}
