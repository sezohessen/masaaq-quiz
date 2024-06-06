<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\Auth\LoginController;
use App\Http\Controllers\Tenant\Auth\RegisterController;
use App\Http\Controllers\Tenant\Dashboard\DashboardController;
use App\Http\Controllers\Tenant\Dashboard\Quiz\QuizController;
use App\Http\Controllers\Tenant\HomeController;
use App\Http\Controllers\Tenant\UserImpersonateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/
Route::middleware([
    'web',
    'tenant'
])->group(function () {
    Route::get('/impersonate/{token}', [UserImpersonateController::class,'impersonate'])->name("impersonate");
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login']);
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register']);
    });

    Route::middleware(['auth', 'client_owner'])
        ->prefix('dashboard')
        ->name('dashboard.')
        ->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('index');
            Route::prefix('quiz')
            ->name('quiz.')
            ->group(function () {
                Route::get('/create', [QuizController::class, 'create'])->name('create');
                Route::post('/store', [QuizController::class, 'store'])->name('store');
                Route::get('/index', [QuizController::class, 'index'])->name('index');
            });
        });
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route("home");
    })->name('logout');
});
