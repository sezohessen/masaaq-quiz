<?php

namespace App\Providers;


use App\Models\Member;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class TenancyAuthProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        if (request()->getHost() == config('tenancy.central_domains')[0] || request()->segment(1) == 'impersonate'||request()->segment(1) == 'dashboard') {
            app('config')->set('auth.providers.users.model', User::class);
        } else {
            app('config')->set('auth.providers.users.model', Member::class);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
