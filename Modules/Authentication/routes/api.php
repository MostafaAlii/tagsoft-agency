<?php
declare(strict_types=1);
use Illuminate\Support\Facades\Route;
use Authentication\Http\Controllers\{AdminAuthController, ClientAuthController, EmployeeAuthController};

Route::prefix('admin')->group(function () {
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::middleware('jwt.custom:admin')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout']);
        Route::post('refresh', [AdminAuthController::class, 'refresh']);
        Route::get('me', [AdminAuthController::class, 'me']);
    });
});

Route::prefix('client')->group(function () {
    Route::post('login', [ClientAuthController::class, 'login']);
    Route::middleware('jwt.custom:client')->group(function () {
        Route::post('logout', [ClientAuthController::class, 'logout']);
        Route::post('refresh', [ClientAuthController::class, 'refresh']);
        Route::get('me', [ClientAuthController::class, 'me']);
    });
});

Route::prefix('employee')->group(function () {
    Route::post('login', [EmployeeAuthController::class, 'login']);
    Route::middleware('jwt.custom:employee')->group(function () {
        Route::post('logout', [EmployeeAuthController::class, 'logout']);
        Route::post('refresh', [EmployeeAuthController::class, 'refresh']);
        Route::get('me', [EmployeeAuthController::class, 'me']);
    });
});