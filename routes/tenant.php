<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\Auth\LoginController;
use App\Http\Controllers\Tenant\Auth\RegisterController;
use App\Http\Controllers\Tenant\Dashboard\CSV\FileController;
use App\Http\Controllers\Tenant\Dashboard\DashboardController;
use App\Http\Controllers\Tenant\Dashboard\Member\MemberController;
use App\Http\Controllers\Tenant\Dashboard\Quiz\QuizController as DashboardQuizController;
use App\Http\Controllers\Tenant\Dashboard\QuizAttempt\QuizAttemptController as DashboardQuizAttemptController;
use App\Http\Controllers\Tenant\Quiz\GoogleCalendar\GoogleCalendarController;
use App\Http\Controllers\Tenant\HomeController;
use App\Http\Controllers\Tenant\Quiz\QuizController;
use App\Http\Controllers\Tenant\QuizAttempt\QuizAttemptController;
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
            Route::get('/', [DashboardController::class,'index'])->name('index');
            Route::prefix('quiz')
            ->name('quiz.')
            ->controller(DashboardQuizController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
            });
            Route::prefix('member')
            ->name('member.')
            ->controller(MemberController::class)->group(function () {
                Route::get('/', 'index')->name('index');
            });
            Route::prefix('quiz_attempt')
            ->name('quiz_attempt.')
            ->group(function () {
                Route::get('/', [DashboardQuizAttemptController::class, 'index'])->name('index');
                Route::get('/show/{quiz_attempt}', [DashboardQuizAttemptController::class, 'show'])->name('show');
            });
            Route::prefix('csv_files')
            ->name('csv_files.')
            ->group(function () {
                Route::get('/', [FileController::class, 'index'])->name('index');
                Route::get('/download/{file}', [FileController::class, 'show'])->name('show');
            });
    });
    Route::middleware(['auth'])
        ->group(function () {
        Route::prefix('quiz')
            ->name('quiz.')
            ->controller(QuizController::class)->group(function () {
                Route::get('/start-quiz/{id}/{quiz:slug}', 'show')->name('show');
                Route::get('/subscribe/{quiz}', 'subscribe')->name('subscribe');
                Route::get('/begin-quiz/{link}', 'begin')->name('begin');
                Route::post('/finish-quiz/{quiz_attempt}', 'finish')->name('finish');
                Route::get('/result/{quiz_attempt}/{quiz:slug}', 'result')->name('result');
            });
        Route::prefix('quiz_attempt')
            ->name('quiz_attempt.')
            ->controller(QuizAttemptController::class)->group(function () {
                Route::get('/my-quizzes', 'index')->name('index');
            });
        Route::prefix('google-calendar')
            ->name('google-calendar.')
            ->controller(GoogleCalendarController::class)->group(function () {
                Route::get('/authorize/{quiz:slug}', 'authorizeURL')->name('authorize');
                Route::get('/save-access-token', 'saveAccessToken')->name('save-access-token');
            });
    });
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route("home");
    })->name('logout');
});
