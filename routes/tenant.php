<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\Auth\LoginController;
use App\Http\Controllers\Tenant\Auth\RegisterController;
use App\Http\Controllers\Tenant\Dashboard\DashboardController;
use App\Http\Controllers\Tenant\Dashboard\Quiz\QuizController as DashboardQuizController;
use App\Http\Controllers\Tenant\Quiz\GoogleCalendar\GoogleCalendarController;
use App\Http\Controllers\Tenant\HomeController;
use App\Http\Controllers\Tenant\Quiz\QuizController;
use App\Http\Controllers\Tenant\UserImpersonateController;
use Illuminate\Support\Facades\Route;
use Filament\Http\Controllers\DashboardController as FilamentDashboardController;

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
           /*  Route::prefix('quiz')
            ->name('quiz.')
            ->group(function () {
                Route::get('/create', [DashboardQuizController::class, 'create'])->name('create');
                Route::post('/store', [DashboardQuizController::class, 'store'])->name('store');
                Route::get('/index', [DashboardQuizController::class, 'index'])->name('index');
            }); */
    });
    Route::middleware(['auth'])
        ->group(function () {
        Route::prefix('quiz')
            ->name('quiz.')
            ->controller(QuizController::class)->group(function () {
                Route::get('/start-quiz/{id}/{quiz:slug}', 'show')->name('show');
                Route::get('/subscribe/{quiz}', 'subscribe')->name('subscribe');//TODO:post request
                Route::get('/begin-quiz/{link}', 'begin')->name('begin');
                Route::post('/finish-quiz/{quiz_attempt}', 'finish')->name('finish');
                Route::get('/result/{quiz_attempt}/{quiz:slug}', 'result')->name('result');
            });
        Route::prefix('google-calendar')
            ->name('google-calendar.')
            ->controller(GoogleCalendarController::class)->group(function () {
                Route::get('/authorize', 'authorizeURL')->name('authorize');
                Route::get('/save-access-token/{code}', 'saveAccessToken')->name('save-access-token');
            });
    });
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route("home");
    })->name('logout');
});
