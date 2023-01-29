<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\Admin\{
    AdminLoginController,
    AdminLogoutController,
    AdminRegisterController,
    AdminProfileController
};

use App\Http\Controllers\Auth\Visitor\{
    VisitorLoginController,
    VisitorLogoutController,
    VisitorProfileController,
    VisitorRegisterController
};


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('admin-only')->group(function () {
        Route::get('/me', AdminProfileController::class);
        Route::post('/logout', AdminLogoutController::class);
    });
});

Route::prefix('admin-only')->group(function () {
    Route::post('/register', AdminRegisterController::class);
    Route::post('/login', AdminLoginController::class);
});

Route::middleware('auth:sanctum', 'ability:visitors')->group(function () {
    Route::prefix('visitor')->group(function () {
        Route::get('/me', VisitorProfileController::class);
        Route::post('/logout', VisitorLogoutController::class);
    });
});

Route::prefix('visitor')->group(function () {
    Route::post('/register', VisitorRegisterController::class);
    Route::post('/login', VisitorLoginController::class);
});
