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
        $userId = auth()->user()->id;
        $token = $this->impersonateTenant($tenant, $userId);
        $this->initializeTenant($tenant->id);
        $url = $this->generateTenantUrl($tenant, $token->token);

        return redirect($url);
    }

    private function impersonateTenant($tenant, $userId)
    {
        return tenancy()->impersonate($tenant, $userId, '/dashboard');
    }

    private function initializeTenant($tenantId)
    {
        tenancy()->initialize($tenantId);
    }

    private function generateTenantUrl($tenant, $token)
    {
        $domain = $this->getTenantDomain($tenant);
        $centralDomain = $this->getCentralDomain();
        if (env('APP_ENV') == 'local') {
            return "http://$domain.$centralDomain:8000/impersonate/$token";
        }else{
            return "http://$domain.$centralDomain/impersonate/$token";
        }
    }

    private function getTenantDomain($tenant)
    {
        return $tenant->name;
    }

    private function getCentralDomain()
    {
        return config('tenancy.central_domains')[0];
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
