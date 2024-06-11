<?php

use App\Http\Controllers\API\Tenant\Auth\AuthController;
use App\Http\Controllers\API\Tenant\Quiz\QuizController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByRequestData;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware([
    'api',
    InitializeTenancyByRequestData::class
])->name('api.')
->prefix('/tenant/v1')
->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    });
    Route::prefix('quiz')
    ->name('quiz.')
    ->controller(QuizController::class)->group(function () {
        Route::get('/get', 'get')->name('get');
        Route::middleware(['auth:sanctum'])->group(function(){
            Route::get('/show/{quiz}', 'show')->name('show');
            Route::post('/subscribe/{quiz}', 'subscribe')->name('subscribe');
            Route::get('/begin-quiz/{link}', 'begin')->name('begin');
            Route::post('/finish-quiz/{quiz_attempt}', 'finish')->name('finish');
            Route::get('/result/{quiz_attempt}','result')->name('result');
            Route::get('/attempts','attempts')->name('attempts');
        });
    });
});
