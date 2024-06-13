<?php

use App\Http\Controllers\Auth\Tenant\TenantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tenant\Quiz\GoogleCalendar\GoogleCalendarController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['middleware' => ['universal',InitializeTenancyByDomain::class]], static function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::middleware(['auth', 'administrator'])
        ->prefix('dashboard')
        ->name('dashboard.')
        ->group(function () {
            Route::get('/', function () {
                return view('dashboard');
            })->name('index');
            Route::prefix('tenants')
                ->name('tenants.')
                ->controller(TenantController::class)->group(function () {
                    Route::get('/index', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                });
        });
    Route::middleware(['auth', 'administrator'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    });

    Route::get('/oauthcallback', [GoogleCalendarController::class, 'handleGoogleCallback'])->name('oauthcallback');
    /* Route::get('/connect/google-calendar', [GoogleCalendarController::class, 'connectGoogleCalendar'])->name('connect.google-calendar'); */

});
require __DIR__ . '/auth.php';
