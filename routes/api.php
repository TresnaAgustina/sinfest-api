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
    VisitorRegisterController
};


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

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

// Visitor
Route::post('/register', VisitorRegisterController::class);
