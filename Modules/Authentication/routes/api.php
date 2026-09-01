<?php
declare(strict_types=1);
use Illuminate\Support\Facades\Route;
use Authentication\Http\Controllers\{PasswordController,AdminAuthController, ClientAuthController, EmployeeAuthController};
use Core\Enums\AuthGuardEnum;
Route::prefix('admin')->group(function () {
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::middleware('jwt.custom:admin')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout']);
        Route::post('refresh', [AdminAuthController::class, 'refresh']);
        Route::get('me', [AdminAuthController::class, 'me']);
        Route::post('change-password', [AdminAuthController::class, 'changePassword']);
    });
});

Route::prefix('client')->group(function () {
    Route::post('login', [ClientAuthController::class, 'login']);
    Route::middleware('jwt.custom:client')->group(function () {
        Route::post('logout', [ClientAuthController::class, 'logout']);
        Route::post('refresh', [ClientAuthController::class, 'refresh']);
        Route::get('me', [ClientAuthController::class, 'me']);
        Route::post('change-password', [ClientAuthController::class, 'changePassword']);
    });
});

Route::prefix('employee')->group(function () {
    Route::post('login', [EmployeeAuthController::class, 'login']);
    Route::middleware('jwt.custom:employee')->group(function () {
        Route::post('logout', [EmployeeAuthController::class, 'logout']);
        Route::post('refresh', [EmployeeAuthController::class, 'refresh']);
        Route::get('me', [EmployeeAuthController::class, 'me']);
            Route::post('change-password', [EmployeeAuthController::class, 'changePassword']);
    });
});

Route::prefix('{guard}')->whereIn('guard', AuthGuardEnum::values())->group(function () {
    Route::post('forgot-password', [PasswordController::class, 'forgot']);
    Route::post('reset-password', [PasswordController::class, 'reset']);
});