<?php
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::post('/login', 'login');
        });
    });
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::prefix('auth')->group(function () {
            Route::controller(AuthController::class)->group(function () {
                Route::post('/logout', 'logout');
                Route::post('/refresh', 'refresh');
                Route::get('/me', 'me');
            });
        });
        
        Route::prefix('user')->group(function () {
            Route::controller(UserController::class)->group(function () {
                Route::get('/', 'index');
                // Route::post('/', 'store');
                Route::get('/{id}', 'show');
                // Route::put('/{id}', 'update');
                // Route::delete('/{id}', 'destroy');
            });
        });
    });
});
