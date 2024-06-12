<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Blueprint::macro('dropForeignSafe', function ($args) {
            if (app()->runningUnitTests()) {
                // Do nothing
                /** @see Blueprint::ensureCommandsAreValid */
            } else {
                $this->dropForeign($args);
            }
        });
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
