<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Admin\{
    AdminLoginController,
    AdminLogoutController,
    AdminRegisterController,
    AdminProfileController
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
    // Admin
    Route::get('/admin-only/me', AdminProfileController::class);
    Route::post('/admin-only/logout', AdminLogoutController::class);
});

Route::post('/admin-only/register', AdminRegisterController::class);
Route::post('/admin-only/login', AdminLoginController::class);
