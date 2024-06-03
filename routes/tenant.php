<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\Admin\Auth\LoginController;
use App\Http\Controllers\Tenant\HomeController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Features\UserImpersonation;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

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
    Route::get('/impersonate/{token}', function ($token) {
        return UserImpersonation::makeResponse($token);
    })->name("impersonate");
    Route::get('/', [HomeController::class,'home']);
    /* Route::get('/admin-login', [LoginController::class,'index'])->name('admin.login');
    Route::post('/admin-login', [LoginController::class,'login'])->name('admin.login.store'); */
    Route::middleware(['auth','client_owner'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('/', function(){
            dd(1);
        })->name('index');
    });
});
