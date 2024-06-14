<?php

namespace App\Providers;

use App\Http\Services\Tenant\Quiz\GoogleCalendar\GoogleCalendarService;
use App\Interface\GoogleCalendar\CalendarServiceInterface;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CalendarServiceInterface::class, GoogleCalendarService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('link', request()->segment(1));
        View::share('sub_link', request()->segment(2));
    }
}
