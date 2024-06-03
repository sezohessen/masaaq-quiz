<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Stancl\Tenancy\Facades\Tenancy;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        if ($tenant = auth()->user()->client) {//TODO: improve redirect
            return $this->redirectToTenant($tenant);
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }
    public function redirectToTenant($tenant)
    {
        $token = tenancy()->impersonate($tenant, auth()->user()->id, '/dashboard');
        tenancy()->initialize($tenant->id);
        $domain = $tenant->name;
        $central_domain = config('tenancy.central_domains')[0];
        return redirect("http://$domain.$central_domain:8000/impersonate/{$token->token}");
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
