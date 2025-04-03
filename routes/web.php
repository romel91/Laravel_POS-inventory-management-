<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::get('/test', [HomeController::class, 'test'])->name('testpage');
Route::post('/user-registration', [UserController::class, 'UserRegistration'])->name('user.registration');
Route::post('/user-login', [UserController::class, 'UserLogin'])->name('user.login');

Route::middleware([TokenVerificationMiddleware::class])->group(function () {
    Route::get('/dashboard', [UserController::class, 'DashboardPage'])->name('dashboard');
    Route::get('/logout', [UserController::class, 'Logout'])->name('logout');
});

